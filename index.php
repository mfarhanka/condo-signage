<?php

require __DIR__ . '/includes/site-data.php';

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function renderButtons(array $buttons): void
{
    foreach ($buttons as $button) {
        $className = $button['className'] ?? 'btn btn-brand';
        echo '<a class="' . escape($className) . '" href="' . escape($button['href']) . '">' . escape($button['label']) . '</a>';
    }
}

function renderCardGrid(array $items, string $columnClass, string $cardClass): void
{
    foreach ($items as $item) {
        echo '<div class="' . escape($columnClass) . '">';
        if (!empty($item['href'])) {
            echo '<a class="card-link" href="' . escape($item['href']) . '">';
        }
        echo '<article class="' . escape($cardClass) . '">';
        echo '<h3>' . escape($item['title']) . '</h3>';
        echo '<p>' . escape($item['copy']) . '</p>';
        echo '</article>';
        if (!empty($item['href'])) {
            echo '</a>';
        }
        echo '</div>';
    }
}

function renderLogoGrid(array $logos): void
{
    echo '<div class="logo-carousel" data-logo-carousel aria-label="Client logos">';
    echo '<div class="logo-carousel-viewport">';
    echo '<div class="logo-carousel-track" data-logo-track>';

    foreach ($logos as $logo) {
        echo '<div class="logo-carousel-item">';
        echo '<img class="logo-carousel-image" src="' . escape($logo['src']) . '" alt="' . escape($logo['alt']) . '" loading="lazy">';
        echo '</div>';
    }

    echo '</div>';
    echo '</div>';
    echo '</div>';
}

function renderReviewStars(int $rating): void
{
    echo '<div class="review-stars" aria-label="' . escape((string) $rating) . ' out of 5 stars">';

    for ($star = 0; $star < 5; $star++) {
        $className = $star < $rating ? 'review-star is-filled' : 'review-star';
        echo '<span class="' . $className . '">&#9733;</span>';
    }

    echo '</div>';
}

function renderSectionHeader(array $section, bool $darkText = false): void
{
    $tagClass = $darkText ? 'section-tag text-dark' : 'section-tag';
    $titleClass = $darkText ? 'section-title text-dark' : 'section-title';

    echo '<div class="row justify-content-between align-items-end mb-4">';
    echo '<div class="col-lg-7">';
    echo '<span class="' . $tagClass . '">' . escape($section['tag']) . '</span>';
    echo '<h2 class="' . $titleClass . '">' . escape($section['title']) . '</h2>';
    echo '</div>';
    echo '<div class="col-lg-4">';
    echo '<p class="section-copy mb-0">' . escape($section['copy']) . '</p>';
    echo '</div>';
    echo '</div>';
}

function resolveNavHref(array $item, bool $cataloguePage = false): string
{
    if (($item['key'] ?? '') === 'catalogue') {
        return 'catalogue.php';
    }

    return $cataloguePage ? 'index.php' . $item['href'] : $item['href'];
}

$brand = $siteConfig['brand'];
$meta = $siteConfig['meta'];
$currentYear = date('Y');
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
    <title><?= escape($meta['title']); ?></title>
    <meta name="description" content="<?= escape($meta['description']); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="90" tabindex="0">
    <nav id="mainNav" class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="#home">
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
                        <li class="nav-item"><a class="nav-link" href="<?= escape(resolveNavHref($item)); ?>"><?= escape($item['label']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <a class="btn btn-brand ms-lg-4" href="#contact">Request a Quote</a>
            </div>
        </div>
    </nav>

    <header id="home" class="hero-section">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php foreach ($siteConfig['heroSlides'] as $index => $slide): ?>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index; ?>" class="<?= $index === 0 ? 'active' : ''; ?>" <?= $index === 0 ? 'aria-current="true"' : ''; ?> aria-label="Slide <?= $index + 1; ?>"></button>
                <?php endforeach; ?>
            </div>
            <div class="carousel-inner">
                <?php foreach ($siteConfig['heroSlides'] as $index => $slide): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active ' : ''; ?>hero-slide <?= escape($slide['className']); ?>">
                        <div class="container">
                            <div class="row min-vh-100 align-items-center pt-5">
                                <div class="col-lg-7">
                                    <span class="section-tag"><?= escape($slide['tag']); ?></span>
                                    <<?= escape($slide['titleTag']); ?>><?= escape($slide['title']); ?></<?= escape($slide['titleTag']); ?>>
                                    <p class="lead"><?= escape($slide['copy']); ?></p>
                                    <?php if (!empty($slide['actions'])): ?>
                                        <div class="d-flex flex-wrap gap-3 mt-4">
                                            <?php renderButtons($slide['actions']); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($slide['metrics'])): ?>
                                        <div class="hero-metrics row g-3 mt-2">
                                            <?php foreach ($slide['metrics'] as $metric): ?>
                                                <div class="col-sm-4">
                                                    <div class="metric-card">
                                                        <strong><?= escape($metric['number']); ?></strong>
                                                        <span><?= escape($metric['label']); ?></span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($slide['panel'])): ?>
                                    <div class="col-lg-5 d-none d-lg-block">
                                        <div class="hero-panel">
                                            <h2><?= escape($slide['panel']['title']); ?></h2>
                                            <p><?= escape($slide['panel']['copy']); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </header>

    <main>
        <section class="py-5 intro-strip">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-8">
                        <p class="mb-0"><?= escape($brand['name']); ?> is presented by <?= escape($brand['company']); ?>, an experienced printing and advertising company serving condominiums, commercial buildings, and managed properties.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a class="btn btn-outline-dark" href="#contact">Get Consultation</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="section-space bg-light-subtle">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <span class="section-tag text-dark"><?= escape($siteConfig['about']['tag']); ?></span>
                        <h2 class="section-title text-dark"><?= escape($siteConfig['about']['title']); ?></h2>
                        <?php foreach ($siteConfig['about']['paragraphs'] as $paragraph): ?>
                            <p><?= escape($paragraph); ?></p>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-lg-6">
                        <figure class="about-media mb-0">
                            <img class="about-photo" src="<?= escape($siteConfig['about']['image']['src']); ?>" alt="<?= escape($siteConfig['about']['image']['alt']); ?>">
                            <figcaption><?= escape($siteConfig['about']['image']['caption']); ?></figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </section>

        <section id="products" class="section-space products-section">
            <div class="container">
                <?php renderSectionHeader($siteConfig['sections']['products']); ?>
                <div class="row g-4">
                    <?php renderCardGrid($siteConfig['sections']['products']['items'], 'col-md-6 col-xl-4', 'product-card'); ?>
                </div>
                <div class="text-center mt-5">
                    <a class="btn btn-brand btn-lg" href="catalogue.php">View Full Catalogue</a>
                </div>
            </div>
        </section>

        <section id="projects" class="section-space bg-light-subtle">
            <div class="container">
                <?php renderSectionHeader($siteConfig['sections']['projects'], true); ?>
                <?php renderLogoGrid($siteConfig['sections']['projects']['logos']); ?>
            </div>
        </section>

        <section id="reviews" class="section-space reviews-section">
            <div class="container">
                <?php renderSectionHeader($siteConfig['sections']['reviews']); ?>
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-4">
                        <aside class="reviews-summary-card">
                            <span class="reviews-kicker">Google</span>
                            <strong class="reviews-rating"><?= escape($siteConfig['sections']['reviews']['summary']['rating']); ?></strong>
                            <?php renderReviewStars(5); ?>
                            <p class="reviews-count mb-4"><?= escape($siteConfig['sections']['reviews']['summary']['countLabel']); ?></p>
                            <a class="btn btn-brand" href="<?= escape($siteConfig['sections']['reviews']['summary']['ctaHref']); ?>" target="_blank" rel="noreferrer"><?= escape($siteConfig['sections']['reviews']['summary']['ctaLabel']); ?></a>
                        </aside>
                    </div>
                    <div class="col-lg-8">
                        <div class="row g-4" data-reviews-rotator>
                            <?php foreach (array_slice($siteConfig['sections']['reviews']['items'], 0, 3) as $slotIndex => $review): ?>
                                <div class="col-md-6 col-xl-4">
                                    <article class="review-card" data-review-slot="<?= escape((string) $slotIndex); ?>">
                                        <div class="review-card-top">
                                            <div data-review-stars><?php renderReviewStars((int) $review['rating']); ?></div>
                                            <span class="review-source">Google Review</span>
                                        </div>
                                        <p class="review-copy" data-review-copy><?= escape($review['copy']); ?></p>
                                        <footer class="review-card-footer">
                                            <strong data-review-author><?= escape($review['author']); ?></strong>
                                            <span data-review-meta><?= escape($review['meta']); ?></span>
                                        </footer>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="services" class="section-space process-section bg-dark text-white">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5">
                        <span class="section-tag"><?= escape($siteConfig['services']['tag']); ?></span>
                        <p class="service-eyebrow mb-2"><?= escape($siteConfig['services']['eyebrow']); ?></p>
                        <h2 class="section-title"><?= escape($siteConfig['services']['title']); ?></h2>
                        <p class="section-copy"><?= escape($siteConfig['services']['copy']); ?></p>
                    </div>
                    <div class="col-lg-7">
                        <div class="row g-3">
                            <?php foreach ($siteConfig['services']['steps'] as $step): ?>
                                <div class="col-md-6 col-xl-3">
                                    <div class="process-card">
                                        <span><?= escape($step['number']); ?></span>
                                        <h3><?= escape($step['title']); ?></h3>
                                        <p><?= escape($step['copy']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mt-4 align-items-start">
                    <div class="col-lg-7">
                        <div class="services-detail-card">
                            <ul class="service-highlight-list mb-0">
                                <?php foreach ($siteConfig['services']['highlights'] as $highlight): ?>
                                    <li><?= escape($highlight); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="services-cta-card">
                            <h3><?= escape($siteConfig['services']['ctaTitle']); ?></h3>
                            <p><?= escape($siteConfig['services']['ctaCopy']); ?></p>
                            <a class="btn btn-brand" href="<?= escape($siteConfig['services']['ctaLinkHref']); ?>"><?= escape($siteConfig['services']['ctaLinkLabel']); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="section-space contact-section">
            <div class="container">
                <div class="row g-5 align-items-start">
                    <div class="col-lg-5">
                        <span class="section-tag"><?= escape($siteConfig['contact']['tag']); ?></span>
                        <h2 class="section-title"><?= escape($siteConfig['contact']['title']); ?></h2>
                        <p class="section-copy"><?= escape($siteConfig['contact']['copy']); ?></p>
                        <div class="branch-tabs" role="tablist" aria-label="Contact branches">
                            <?php foreach ($siteConfig['contact']['branches'] as $branch): ?>
                                <button type="button" class="branch-tab <?= $branch['active'] ? 'is-active' : ''; ?>" data-branch-tab="<?= escape($branch['id']); ?>" aria-pressed="<?= $branch['active'] ? 'true' : 'false'; ?>"><?= escape($branch['label']); ?></button>
                            <?php endforeach; ?>
                        </div>
                        <div class="contact-office-card" data-contact-branch-panel>
                            <h3 data-contact-office-name><?= escape($activeBranch['office']['name']); ?></h3>
                            <p class="contact-registration" data-contact-office-registration><?= escape($activeBranch['office']['registration']); ?></p>
                            <div data-contact-office-address>
                                <?php foreach ($activeBranch['office']['addressLines'] as $line): ?>
                                    <p class="contact-address-line"><?= escape($line); ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="contact-list" data-contact-blocks>
                            <?php foreach ($activeBranch['contactBlocks'] as $detail): ?>
                                <div class="contact-list-item">
                                    <strong><?= escape($detail['label']); ?></strong>
                                    <span><?= escape($detail['value']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="contact-actions">
                            <a class="contact-action-card" data-contact-phone href="<?= escape($activeBranch['quickActions']['phone']['href']); ?>">
                                <span class="contact-action-icon">P</span>
                                <span>
                                    <strong data-contact-phone-label><?= escape($activeBranch['quickActions']['phone']['label']); ?></strong>
                                    <small data-contact-phone-value><?= escape($activeBranch['quickActions']['phone']['value']); ?></small>
                                </span>
                            </a>
                            <a class="contact-action-card" data-contact-email href="<?= escape($activeBranch['quickActions']['email']['href']); ?>">
                                <span class="contact-action-icon">@</span>
                                <span>
                                    <strong data-contact-email-label><?= escape($activeBranch['quickActions']['email']['label']); ?></strong>
                                    <small data-contact-email-value><?= escape($activeBranch['quickActions']['email']['value']); ?></small>
                                </span>
                            </a>
                            <a class="whatsapp-card" data-contact-whatsapp href="<?= escape($activeBranch['whatsApp']['href']); ?>" target="_blank" rel="noreferrer">
                                <span class="whatsapp-icon">W</span>
                                <span>
                                    <strong data-contact-whatsapp-label><?= escape($activeBranch['whatsApp']['label']); ?></strong>
                                    <small data-contact-whatsapp-sublabel><?= escape($activeBranch['whatsApp']['subLabel']); ?></small>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="contact-card">
                            <form>
                                <div class="row g-3">
                                    <?php foreach ($siteConfig['contact']['formFields'] as $field): ?>
                                        <div class="<?= escape($field['columnClass']); ?>">
                                            <label for="<?= escape($field['id']); ?>" class="form-label"><?= escape($field['label']); ?></label>
                                            <?php if ($field['type'] === 'textarea'): ?>
                                                <textarea class="form-control" id="<?= escape($field['id']); ?>" rows="<?= escape((string) ($field['rows'] ?? 5)); ?>" placeholder="<?= escape($field['placeholder']); ?>"></textarea>
                                            <?php elseif ($field['type'] === 'file'): ?>
                                                <input type="file" class="form-control form-control-file" id="<?= escape($field['id']); ?>">
                                            <?php else: ?>
                                                <input type="<?= escape($field['type']); ?>" class="form-control" id="<?= escape($field['id']); ?>" placeholder="<?= escape($field['placeholder']); ?>">
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-brand w-100"><?= escape($siteConfig['contact']['submitLabel']); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer py-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <p class="mb-0">&copy; <?= escape((string) $currentYear); ?> <?= escape($brand['name']); ?> by <?= escape($brand['company']); ?>. All rights reserved.</p>
            <p class="mb-0"><?= escape($brand['tagline']); ?></p>
        </div>
    </footer>

    <script id="contact-branch-data" type="application/json"><?= json_encode($siteConfig['contact']['branches'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?></script>
    <script id="reviews-data" type="application/json"><?= json_encode($siteConfig['sections']['reviews']['items'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/site.js"></script>
</body>
</html>