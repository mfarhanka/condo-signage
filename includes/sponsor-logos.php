<?php

declare(strict_types=1);

const SPONSOR_LOGO_LIMIT = 10;
const SPONSOR_LOGO_MAX_WIDTH = 600;
const SPONSOR_LOGO_MAX_HEIGHT = 240;

function sponsorLogoDataPath(): string
{
    return dirname(__DIR__) . '/data/sponsor-logos.json';
}

function sponsorLogoUploadDirectory(): string
{
    return dirname(__DIR__) . '/assets/images/sponsors';
}

function sponsorLogoPublicDirectory(): string
{
    return 'assets/images/sponsors';
}

function ensureSponsorLogoStorage(): void
{
    $dataDirectory = dirname(sponsorLogoDataPath());

    if (!is_dir($dataDirectory)) {
        mkdir($dataDirectory, 0775, true);
    }

    if (!is_dir(sponsorLogoUploadDirectory())) {
        mkdir(sponsorLogoUploadDirectory(), 0775, true);
    }
}

function defaultSponsorLogos(): array
{
    return array_map(
        static fn(int $index): array => [
            'id' => 'placeholder-' . $index,
            'src' => 'logo.jpg',
            'alt' => 'Client logo placeholder ' . $index,
        ],
        range(1, SPONSOR_LOGO_LIMIT)
    );
}

function loadSponsorLogos(bool $useFallback = true): array
{
    $dataPath = sponsorLogoDataPath();

    if (!is_file($dataPath)) {
        return $useFallback ? defaultSponsorLogos() : [];
    }

    $decoded = json_decode((string) file_get_contents($dataPath), true);

    if (!is_array($decoded)) {
        return $useFallback ? defaultSponsorLogos() : [];
    }

    $logos = [];

    foreach ($decoded as $item) {
        if (!is_array($item)) {
            continue;
        }

        $id = trim((string) ($item['id'] ?? ''));
        $src = trim((string) ($item['src'] ?? ''));
        $alt = trim((string) ($item['alt'] ?? 'Sponsor logo'));

        if ($id === '' || $src === '') {
            continue;
        }

        $logos[] = [
            'id' => $id,
            'src' => $src,
            'alt' => $alt,
        ];
    }

    if ($logos === [] && $useFallback) {
        return defaultSponsorLogos();
    }

    return array_slice($logos, 0, SPONSOR_LOGO_LIMIT);
}

function saveSponsorLogos(array $logos): void
{
    ensureSponsorLogoStorage();

    $payload = array_values(array_map(
        static fn(array $logo): array => [
            'id' => (string) $logo['id'],
            'src' => (string) $logo['src'],
            'alt' => (string) $logo['alt'],
        ],
        array_slice($logos, 0, SPONSOR_LOGO_LIMIT)
    ));

    file_put_contents(
        sponsorLogoDataPath(),
        json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        LOCK_EX
    );
}

function imageTypeToExtension(int $imageType): string
{
    return match ($imageType) {
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_WEBP => 'webp',
        default => throw new RuntimeException('Only JPG, PNG, and WebP images are supported.'),
    };
}

function createImageResource(string $path, int $imageType)
{
    return match ($imageType) {
        IMAGETYPE_JPEG => imagecreatefromjpeg($path),
        IMAGETYPE_PNG => imagecreatefrompng($path),
        IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? imagecreatefromwebp($path) : throw new RuntimeException('WebP is not available on this server.'),
        default => false,
    };
}

function saveResizedImage($image, string $path, int $imageType): void
{
    $saved = match ($imageType) {
        IMAGETYPE_JPEG => imagejpeg($image, $path, 85),
        IMAGETYPE_PNG => imagepng($image, $path, 6),
        IMAGETYPE_WEBP => function_exists('imagewebp') ? imagewebp($image, $path, 85) : false,
        default => false,
    };

    if ($saved === false) {
        throw new RuntimeException('Unable to save the resized image.');
    }
}

function preserveImageTransparency($canvas, int $imageType): void
{
    if ($imageType === IMAGETYPE_PNG || $imageType === IMAGETYPE_WEBP) {
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefilledrectangle($canvas, 0, 0, (int) imagesx($canvas), (int) imagesy($canvas), $transparent);
        return;
    }

    $background = imagecolorallocate($canvas, 255, 255, 255);
    imagefilledrectangle($canvas, 0, 0, (int) imagesx($canvas), (int) imagesy($canvas), $background);
}

function storeResizedSponsorLogo(array $upload, string $id): string
{
    if (!extension_loaded('gd')) {
        throw new RuntimeException('GD extension is required to resize sponsor logos.');
    }

    if (($upload['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Please choose an image file to upload.');
    }

    $tmpPath = (string) ($upload['tmp_name'] ?? '');

    if ($tmpPath === '' || !is_uploaded_file($tmpPath)) {
        throw new RuntimeException('The uploaded file could not be verified.');
    }

    $imageInfo = getimagesize($tmpPath);

    if ($imageInfo === false) {
        throw new RuntimeException('The uploaded file is not a valid image.');
    }

    [$sourceWidth, $sourceHeight, $imageType] = $imageInfo;

    if ($sourceWidth < 1 || $sourceHeight < 1) {
        throw new RuntimeException('The uploaded image has invalid dimensions.');
    }

    $extension = imageTypeToExtension($imageType);
    $sourceImage = createImageResource($tmpPath, $imageType);

    if ($sourceImage === false) {
        throw new RuntimeException('The uploaded image format could not be processed.');
    }

    $scale = min(
        1,
        SPONSOR_LOGO_MAX_WIDTH / $sourceWidth,
        SPONSOR_LOGO_MAX_HEIGHT / $sourceHeight
    );

    $targetWidth = max(1, (int) round($sourceWidth * $scale));
    $targetHeight = max(1, (int) round($sourceHeight * $scale));
    $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);

    preserveImageTransparency($targetImage, $imageType);
    imagecopyresampled($targetImage, $sourceImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $sourceWidth, $sourceHeight);

    ensureSponsorLogoStorage();

    $fileName = 'sponsor-' . $id . '.' . $extension;
    $absolutePath = sponsorLogoUploadDirectory() . '/' . $fileName;
    saveResizedImage($targetImage, $absolutePath, $imageType);

    imagedestroy($sourceImage);
    imagedestroy($targetImage);

    return sponsorLogoPublicDirectory() . '/' . $fileName;
}

function addSponsorLogo(string $alt, array $upload): array
{
    $logos = loadSponsorLogos(false);

    if (count($logos) >= SPONSOR_LOGO_LIMIT) {
        throw new RuntimeException('Only 10 sponsor logos can be stored at one time.');
    }

    $id = bin2hex(random_bytes(8));
    $trimmedAlt = trim($alt);
    $src = storeResizedSponsorLogo($upload, $id);

    $logo = [
        'id' => $id,
        'src' => $src,
        'alt' => $trimmedAlt !== '' ? $trimmedAlt : 'Sponsor logo ' . (count($logos) + 1),
    ];

    $logos[] = $logo;
    saveSponsorLogos($logos);

    return $logo;
}

function deleteSponsorLogo(string $id): bool
{
    $logos = loadSponsorLogos(false);
    $remainingLogos = [];
    $deleted = false;

    foreach ($logos as $logo) {
        if ($logo['id'] !== $id) {
            $remainingLogos[] = $logo;
            continue;
        }

        $deleted = true;
        $absolutePath = dirname(__DIR__) . '/' . ltrim($logo['src'], '/');

        if (is_file($absolutePath)) {
            unlink($absolutePath);
        }
    }

    if ($deleted) {
        saveSponsorLogos($remainingLogos);
    }

    return $deleted;
}