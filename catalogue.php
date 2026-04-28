<?php

require __DIR__ . '/includes/site-data.php';

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function resolveNavHref(array $item): string
{
    if (($item['key'] ?? '') === 'catalogue') {
        return 'catalogue.php';
    }

    return 'index.php' . $item['href'];
}

$brand = $siteConfig['brand'];
$catalogue = $siteConfig['catalogue'];
$currentYear = date('Y');
$stylesVersion = (string) filemtime(__DIR__ . '/assets/css/styles.css');
$scriptVersion = (string) filemtime(__DIR__ . '/assets/js/site.js');
$activeBranch = null;

foreach ($siteConfig['contact']['branches'] as $branch) {
    if (!empty($branch['active'])) {
        $activeBranch = $branch;
        break;
    }
}

if ($activeBranch === null && !empty($siteConfig['contact']['branches'][0])) {
    $activeBranch = $siteConfig['contact']['branches'][0];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= escape($brand['name']); ?> | <?= escape($catalogue['tag']); ?></title>
    <meta name="description" content="<?= escape($catalogue['copy']); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css?v=<?= escape($stylesVersion); ?>">
</head>
<body class="catalogue-page">
    <nav id="mainNav" class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="index.php#home">
                <img src="<?= escape($brand['logo']); ?>" alt="<?= escape($brand['name']); ?> logo">
                <span>
                    <small class="brand-kicker"><?= escape($brand['company']); ?></small>
                    <?= escape($brand['name']); ?>
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php foreach ($siteConfig['nav'] as $item): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($item['key'] ?? '') === 'catalogue' ? 'active' : ''; ?>" href="<?= escape(resolveNavHref($item)); ?>"><?= escape($item['label']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a class="btn btn-brand ms-lg-4" href="index.php#contact">Request a Quote</a>
            </div>
        </div>
    </nav>

    <header class="catalogue-hero">
        <div class="container">
            <div class="row g-4 align-items-end">
                <div class="col-lg-8 catalogue-summary">
                    <span class="section-tag text-white"><?= escape($catalogue['tag']); ?></span>
                    <h1 class="section-title text-white"><?= escape($catalogue['title']); ?></h1>
                    <p class="lead text-white-50 mb-0"><?= escape($catalogue['copy']); ?></p>
                </div>
                <div class="col-lg-4">
                    <div class="catalogue-meta-card">
                        <strong><?= escape((string) count($catalogue['categories'])); ?> Categories</strong>
                        <span>Wayfinding, safety, indoor, outdoor, amenity, and identity signage organized in one reference page.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="catalogue-layout">
        <div class="container">
            <div class="row g-4">
                <aside class="col-lg-4 col-xl-3">
                    <div class="catalogue-sidebar">
                        <h2>Categories</h2>
                        <nav class="catalogue-nav" aria-label="Catalogue categories">
                            <?php foreach ($catalogue['categories'] as $category): ?>
                                <a href="#<?= escape($category['id']); ?>"><?= escape($category['title']); ?></a>
                            <?php endforeach; ?>
                        </nav>
                    </div>
                </aside>
                <div class="col-lg-8 col-xl-9">
                    <section class="catalogue-intro">
                        <span class="section-tag text-dark">Overview</span>
                        <p class="mb-0"><?= escape($catalogue['intro']); ?></p>
                    </section>

                    <div class="catalogue-grid">
                        <?php foreach ($catalogue['categories'] as $index => $category): ?>
                            <article id="<?= escape($category['id']); ?>" class="catalogue-card">
                                <div class="catalogue-card-header">
                                    <h3><?= escape($category['title']); ?></h3>
                                    <span class="catalogue-chip">Category <?= escape((string) ($index + 1)); ?></span>
                                </div>
                                <p class="mb-0"><?= escape($category['copy']); ?></p>
                                <ul class="catalogue-points">
                                    <?php foreach ($category['highlights'] as $highlight): ?>
                                        <li><?= escape($highlight); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php if (!empty($category['gallery'])): ?>
                                    <div class="catalogue-gallery" aria-label="<?= escape($category['title']); ?> examples">
                                        <?php foreach ($category['gallery'] as $image): ?>
                                            <a class="catalogue-gallery-item" href="<?= escape($image['src']); ?>" data-gallery-item data-gallery-group="<?= escape($category['id']); ?>" data-gallery-title="<?= escape($category['title']); ?>">
                                                <img src="<?= escape($image['src']); ?>" alt="<?= escape($image['alt']); ?>" loading="lazy">
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <section class="catalogue-cta">
                        <span class="section-tag text-white">Next Step</span>
                        <h2 class="section-title mb-3">Need a quotation for a specific signage package?</h2>
                        <p class="mb-4">Share your property requirements with our team and we can recommend the right indoor, outdoor, and operational signage mix.</p>
                        <a class="btn btn-brand" href="index.php#contact">Request a Quote</a>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <footer class="site-footer py-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <p class="mb-0">&copy; <?= escape((string) $currentYear); ?> <?= escape($brand['name']); ?> by <?= escape($brand['company']); ?>. All rights reserved.</p>
            <p class="mb-0"><?= escape($brand['tagline']); ?></p>
        </div>
    </footer>

    <a class="whatsapp-float-button" href="<?= escape($activeBranch['whatsApp']['href']); ?>" target="_blank" rel="noreferrer" aria-label="<?= escape($activeBranch['whatsApp']['label']); ?>">
        <span class="whatsapp-float-button__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" focusable="false">
                <path d="M19.05 4.94A9.9 9.9 0 0 0 12 2a9.94 9.94 0 0 0-8.62 14.89L2 22l5.26-1.38A9.94 9.94 0 0 0 12 22h.01A9.99 9.99 0 0 0 22 12a9.9 9.9 0 0 0-2.95-7.06Zm-7.04 15.38h-.01a8.3 8.3 0 0 1-4.23-1.16l-.3-.18-3.12.82.84-3.04-.2-.31A8.28 8.28 0 0 1 12 3.68a8.3 8.3 0 0 1 5.89 14.17 8.25 8.25 0 0 1-5.88 2.47Zm4.56-6.2c-.25-.13-1.47-.72-1.7-.8-.23-.09-.39-.13-.56.12-.16.25-.64.8-.78.97-.14.17-.28.2-.53.07-.25-.13-1.04-.38-1.98-1.2-.73-.65-1.23-1.45-1.37-1.69-.14-.25-.01-.38.11-.5.11-.11.25-.28.37-.42.12-.14.16-.25.24-.41.08-.17.04-.32-.02-.45-.07-.13-.56-1.35-.77-1.84-.2-.49-.41-.42-.56-.43h-.48c-.16 0-.42.06-.64.31-.22.25-.84.82-.84 2s.86 2.32.98 2.48c.12.17 1.69 2.58 4.1 3.62.57.25 1.02.4 1.37.51.58.18 1.11.15 1.52.09.46-.07 1.47-.6 1.67-1.18.21-.59.21-1.09.15-1.18-.06-.1-.22-.16-.47-.28Z" />
            </svg>
        </span>
        <span class="whatsapp-float-button__label">WhatsApp</span>
    </a>

    <div class="catalogue-lightbox" data-gallery-lightbox hidden>
        <button class="catalogue-lightbox-close" type="button" aria-label="Close image viewer" data-gallery-close>&times;</button>
        <button class="catalogue-lightbox-nav catalogue-lightbox-prev" type="button" aria-label="Previous image" data-gallery-prev>&lsaquo;</button>
        <div class="catalogue-lightbox-dialog" role="dialog" aria-modal="true" aria-label="Catalogue image viewer" data-gallery-backdrop>
            <img class="catalogue-lightbox-image" src="" alt="" data-gallery-image>
            <div class="catalogue-lightbox-meta">
                <strong data-gallery-caption></strong>
                <span data-gallery-counter></span>
            </div>
        </div>
        <button class="catalogue-lightbox-nav catalogue-lightbox-next" type="button" aria-label="Next image" data-gallery-next>&rsaquo;</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/site.js?v=<?= escape($scriptVersion); ?>"></script>
</body>
</html>