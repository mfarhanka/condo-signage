<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/includes/sponsor-logos.php';
require_once __DIR__ . '/includes/cms-auth.php';

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $action = (string) ($_POST['action'] ?? '');
        $redirectTarget = 'sponsor-cms.php';

        if ($action === 'login') {
            $isLoggedIn = cmsAttemptLogin((string) ($_POST['username'] ?? ''), (string) ($_POST['password'] ?? ''));
            $_SESSION['sponsor_flash'] = [
                'type' => $isLoggedIn ? 'success' : 'danger',
                'message' => $isLoggedIn ? 'Signed in to sponsor CMS.' : 'Invalid CMS username or password.',
            ];
        } else {
            if (!cmsIsAuthenticated()) {
                throw new RuntimeException('Please sign in to manage sponsor logos.');
            }

            cmsValidateCsrfToken($_POST['csrf_token'] ?? null);

            if ($action === 'logout') {
                cmsLogout();
                $_SESSION['sponsor_flash'] = ['type' => 'success', 'message' => 'Signed out from sponsor CMS.'];
            } elseif ($action === 'upload') {
                addSponsorLogo((string) ($_POST['alt'] ?? ''), $_FILES['logo'] ?? []);
                $_SESSION['sponsor_flash'] = ['type' => 'success', 'message' => 'Sponsor logo uploaded successfully.'];
            } elseif ($action === 'update') {
                $updated = updateSponsorLogo((string) ($_POST['id'] ?? ''), (string) ($_POST['alt'] ?? ''));
                $_SESSION['sponsor_flash'] = [
                    'type' => $updated ? 'success' : 'danger',
                    'message' => $updated ? 'Sponsor logo name updated.' : 'Sponsor logo could not be updated.',
                ];
                $redirectTarget = 'sponsor-cms.php#logo-list';
            } elseif ($action === 'move') {
                $moved = moveSponsorLogo((string) ($_POST['id'] ?? ''), (string) ($_POST['direction'] ?? ''));
                $_SESSION['sponsor_flash'] = [
                    'type' => $moved ? 'success' : 'danger',
                    'message' => $moved ? 'Sponsor logo order updated.' : 'Sponsor logo could not be moved further.',
                ];
                $redirectTarget = 'sponsor-cms.php#logo-list';
            } elseif ($action === 'delete') {
                $deleted = deleteSponsorLogo((string) ($_POST['id'] ?? ''));
                $_SESSION['sponsor_flash'] = [
                    'type' => $deleted ? 'success' : 'danger',
                    'message' => $deleted ? 'Sponsor logo removed.' : 'Sponsor logo could not be found.',
                ];
                $redirectTarget = 'sponsor-cms.php#logo-list';
            }
        }
    } catch (Throwable $error) {
        $_SESSION['sponsor_flash'] = ['type' => 'danger', 'message' => $error->getMessage()];
    }

    header('Location: ' . ($redirectTarget ?? 'sponsor-cms.php'));
    exit;
}

$flash = $_SESSION['sponsor_flash'] ?? null;
unset($_SESSION['sponsor_flash']);

$isAuthenticated = cmsIsAuthenticated();
$csrfToken = $isAuthenticated ? cmsCsrfToken() : '';
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
                        <p class="section-copy mb-0">Upload, rename, reorder, and remove sponsor logos used by the homepage carousel.</p>
                    </div>
                    <?php if ($isAuthenticated): ?>
                        <div class="cms-toolbar">
                            <a class="btn btn-outline-dark" href="index.php#projects">View Homepage Carousel</a>
                            <form method="post">
                                <input type="hidden" name="action" value="logout">
                                <input type="hidden" name="csrf_token" value="<?= escape($csrfToken); ?>">
                                <button class="btn btn-outline-dark" type="submit">Sign Out</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (is_array($flash) && !empty($flash['message'])): ?>
                <div class="alert alert-<?= escape((string) ($flash['type'] ?? 'info')); ?> cms-alert" role="alert">
                    <?= escape((string) $flash['message']); ?>
                </div>
            <?php endif; ?>

            <?php if (!$isAuthenticated): ?>
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-xl-4">
                        <section class="cms-card cms-login-card">
                            <h2>Sign In</h2>
                            <p class="mb-4">Use the CMS login below to manage sponsor logos.</p>
                            <form method="post" class="cms-form">
                                <input type="hidden" name="action" value="login">
                                <div class="mb-3">
                                    <label class="form-label" for="username">Username</label>
                                    <input class="form-control" type="text" id="username" name="username" autocomplete="username" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input class="form-control" type="password" id="password" name="password" autocomplete="current-password" required>
                                </div>
                                <button class="btn btn-brand w-100" type="submit">Sign In</button>
                            </form>
                            <p class="cms-credentials-note mb-0">Default login: <?= escape(cmsUsername()); ?> / <?= escape(cmsDefaultPasswordLabel()); ?>. Change it using the SPONSOR_CMS_USERNAME and SPONSOR_CMS_PASSWORD_HASH environment variables.</p>
                        </section>
                    </div>
                </div>
            <?php else: ?>
                <div class="row g-4 align-items-start">
                    <div class="col-lg-5">
                        <section class="cms-card">
                            <h2>Upload Sponsor Logo</h2>
                            <p class="mb-4">Recommended files: JPG, PNG, or WebP. Images are resized to fit within <?= escape((string) SPONSOR_LOGO_MAX_WIDTH); ?> x <?= escape((string) SPONSOR_LOGO_MAX_HEIGHT); ?> px.</p>
                            <form method="post" enctype="multipart/form-data" class="cms-form">
                                <input type="hidden" name="action" value="upload">
                                <input type="hidden" name="csrf_token" value="<?= escape($csrfToken); ?>">
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
                        <section class="cms-card" id="logo-list">
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
                                    <?php foreach ($logos as $index => $logo): ?>
                                        <article class="cms-logo-item">
                                            <div class="cms-logo-preview">
                                                <img src="<?= escape($logo['src']); ?>" alt="<?= escape($logo['alt']); ?>">
                                            </div>
                                            <div class="cms-logo-meta">
                                                <span class="cms-logo-order">Position <?= escape((string) ($index + 1)); ?></span>
                                                <form method="post" class="cms-logo-edit-form">
                                                    <input type="hidden" name="action" value="update">
                                                    <input type="hidden" name="id" value="<?= escape($logo['id']); ?>">
                                                    <input type="hidden" name="csrf_token" value="<?= escape($csrfToken); ?>">
                                                    <label class="form-label visually-hidden" for="logo-name-<?= escape($logo['id']); ?>">Logo name</label>
                                                    <input class="form-control" type="text" id="logo-name-<?= escape($logo['id']); ?>" name="alt" value="<?= escape($logo['alt']); ?>">
                                                    <div class="cms-logo-controls">
                                                        <button class="btn btn-brand" type="submit">Save Name</button>
                                                    </div>
                                                </form>
                                                <span><?= escape($logo['src']); ?></span>
                                            </div>
                                            <div class="cms-action-stack">
                                                <form method="post">
                                                    <input type="hidden" name="action" value="move">
                                                    <input type="hidden" name="id" value="<?= escape($logo['id']); ?>">
                                                    <input type="hidden" name="direction" value="up">
                                                    <input type="hidden" name="csrf_token" value="<?= escape($csrfToken); ?>">
                                                    <button class="btn btn-outline-dark w-100" type="submit" <?= $index === 0 ? 'disabled' : ''; ?>>Move Up</button>
                                                </form>
                                                <form method="post">
                                                    <input type="hidden" name="action" value="move">
                                                    <input type="hidden" name="id" value="<?= escape($logo['id']); ?>">
                                                    <input type="hidden" name="direction" value="down">
                                                    <input type="hidden" name="csrf_token" value="<?= escape($csrfToken); ?>">
                                                    <button class="btn btn-outline-dark w-100" type="submit" <?= $index === count($logos) - 1 ? 'disabled' : ''; ?>>Move Down</button>
                                                </form>
                                                <form method="post">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= escape($logo['id']); ?>">
                                                    <input type="hidden" name="csrf_token" value="<?= escape($csrfToken); ?>">
                                                    <button class="btn btn-outline-danger w-100" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </section>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>