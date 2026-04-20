<?php

declare(strict_types=1);

function cmsUsername(): string
{
    $username = getenv('SPONSOR_CMS_USERNAME');

    return is_string($username) && trim($username) !== '' ? trim($username) : 'admin';
}

function cmsPasswordHash(): string
{
    $hash = getenv('SPONSOR_CMS_PASSWORD_HASH');

    if (is_string($hash) && trim($hash) !== '') {
        return trim($hash);
    }

    return '$2y$10$EhgNwK5UBM.lk3w3oG.6QuYssF78SpD7MikDJHx4.dbTseoAI.yAi';
}

function cmsDefaultPasswordLabel(): string
{
    return 'change-me-123';
}

function cmsIsAuthenticated(): bool
{
    return !empty($_SESSION['cms_authenticated']);
}

function cmsAttemptLogin(string $username, string $password): bool
{
    if (!hash_equals(cmsUsername(), trim($username))) {
        return false;
    }

    if (!password_verify($password, cmsPasswordHash())) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['cms_authenticated'] = true;

    return true;
}

function cmsLogout(): void
{
    unset($_SESSION['cms_authenticated'], $_SESSION['cms_csrf_token']);
    session_regenerate_id(true);
}

function cmsCsrfToken(): string
{
    if (empty($_SESSION['cms_csrf_token'])) {
        $_SESSION['cms_csrf_token'] = bin2hex(random_bytes(32));
    }

    return (string) $_SESSION['cms_csrf_token'];
}

function cmsValidateCsrfToken(?string $token): void
{
    $sessionToken = (string) ($_SESSION['cms_csrf_token'] ?? '');

    if ($sessionToken === '' || $token === null || !hash_equals($sessionToken, $token)) {
        throw new RuntimeException('Your session token is invalid. Please refresh and try again.');
    }
}