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
    <link rel="stylesheet" href="assets/css/styles.css">
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
    <script src="assets/js/site.js"></script>
</body>
</html>