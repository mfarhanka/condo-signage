<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/includes/sponsor-logos.php';

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $action = (string) ($_POST['action'] ?? '');

        if ($action === 'upload') {
            addSponsorLogo((string) ($_POST['alt'] ?? ''), $_FILES['logo'] ?? []);
            $_SESSION['sponsor_flash'] = ['type' => 'success', 'message' => 'Sponsor logo uploaded successfully.'];
        } elseif ($action === 'delete') {
            $deleted = deleteSponsorLogo((string) ($_POST['id'] ?? ''));
            $_SESSION['sponsor_flash'] = [
                'type' => $deleted ? 'success' : 'danger',
                'message' => $deleted ? 'Sponsor logo removed.' : 'Sponsor logo could not be found.',
            ];
        }
    } catch (Throwable $error) {
        $_SESSION['sponsor_flash'] = ['type' => 'danger', 'message' => $error->getMessage()];
    }

    header('Location: sponsor-cms.php');
    exit;
}

$flash = $_SESSION['sponsor_flash'] ?? null;
unset($_SESSION['sponsor_flash']);

$logos = loadSponsorLogos(false);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sponsor Logo CMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="cms-page">
    <main class="cms-shell py-5">
        <div class="container">
            <div class="cms-header mb-4">
                <p class="section-tag text-dark mb-2">Simple CMS</p>
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-end">
                    <div>
                        <h1 class="section-title text-dark mb-2">Sponsor Logo Manager</h1>
                        <p class="section-copy mb-0">Upload up to <?= escape((string) SPONSOR_LOGO_LIMIT); ?> sponsor logos. Each image is resized on upload and used automatically in the homepage sponsor carousel.</p>
                    </div>
                    <a class="btn btn-outline-dark" href="index.php#projects">View Homepage Carousel</a>
                </div>
            </div>

            <?php if (is_array($flash) && !empty($flash['message'])): ?>
                <div class="alert alert-<?= escape((string) ($flash['type'] ?? 'info')); ?> cms-alert" role="alert">
                    <?= escape((string) $flash['message']); ?>
                </div>
            <?php endif; ?>

            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <section class="cms-card">
                        <h2>Upload Sponsor Logo</h2>
                        <p class="mb-4">Recommended files: JPG, PNG, or WebP. Images are resized to fit within <?= escape((string) SPONSOR_LOGO_MAX_WIDTH); ?> x <?= escape((string) SPONSOR_LOGO_MAX_HEIGHT); ?> px.</p>
                        <form method="post" enctype="multipart/form-data" class="cms-form">
                            <input type="hidden" name="action" value="upload">
                            <div class="mb-3">
                                <label class="form-label" for="alt">Logo Name</label>
                                <input class="form-control" type="text" id="alt" name="alt" placeholder="Example: Sky Residence">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="logo">Logo Image</label>
                                <input class="form-control" type="file" id="logo" name="logo" accept=".jpg,.jpeg,.png,.webp" required>
                            </div>
                            <button class="btn btn-brand w-100" type="submit" <?= count($logos) >= SPONSOR_LOGO_LIMIT ? 'disabled' : ''; ?>>Upload Logo</button>
                        </form>
                    </section>
                </div>
                <div class="col-lg-7">
                    <section class="cms-card">
                        <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                            <div>
                                <h2 class="mb-1">Current Sponsor Logos</h2>
                                <p class="mb-0"><?= escape((string) count($logos)); ?> / <?= escape((string) SPONSOR_LOGO_LIMIT); ?> logos in use</p>
                            </div>
                        </div>

                        <?php if ($logos === []): ?>
                            <div class="cms-empty-state">
                                <strong>No sponsor logos uploaded yet.</strong>
                                <p class="mb-0">The homepage is still showing placeholders. Upload the first logo here to replace them.</p>
                            </div>
                        <?php else: ?>
                            <div class="cms-logo-list">
                                <?php foreach ($logos as $logo): ?>
                                    <article class="cms-logo-item">
                                        <div class="cms-logo-preview">
                                            <img src="<?= escape($logo['src']); ?>" alt="<?= escape($logo['alt']); ?>">
                                        </div>
                                        <div class="cms-logo-meta">
                                            <strong><?= escape($logo['alt']); ?></strong>
                                            <span><?= escape($logo['src']); ?></span>
                                        </div>
                                        <form method="post">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= escape($logo['id']); ?>">
                                            <button class="btn btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </section>
                </div>
            </div>
        </div>
    </main>
</body>
</html>