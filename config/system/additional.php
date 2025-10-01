<?php

use TYPO3\CMS\Core\Core\Environment;

defined('TYPO3') or die();

switch (Environment::getContext()) {
    case 'Development':
    case 'Development/Ddev':
        $contextConfiguration = Environment::getProjectPath() . '/config/system/environments/development.php';
        break;

    case 'Production':
        $contextConfiguration = Environment::getProjectPath() . '/config/system/environments/production.php';
        break;
}

if (!empty($contextConfiguration) && @file_exists($contextConfiguration)) {
    require_once $contextConfiguration;
}

$sentryReleaseFilepath = $_SERVER['DOCUMENT_ROOT'] . '/../.sentryrelease';
if (file_exists($sentryReleaseFilepath)) {
    $content = trim(file_get_contents($sentryReleaseFilepath));

    if ($content) {
        putenv('SENTRY_RELEASE=' . $content);
        putenv('SENTRY_ENVIRONMENT=Production');
    }
}

$hostConfigurationPath = Environment::getProjectPath() . '/config/system/host.php';
if (@file_exists($hostConfigurationPath)) {
    require_once $hostConfigurationPath;
}
