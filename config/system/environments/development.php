<?php
declare(strict_types=1);

use TYPO3\CMS\Core\Log\LogLevel;

$GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword'] = '$argon2i$v=19$m=65536,t=16,p=1$OTZKcWsvWi9weHpuRkg3aA$xHSE5r3p2kzHEfRwp99pHeGKXNYMtH0BPzS6gZTQxNM';

$GLOBALS['TYPO3_CONF_VARS']['BE']['debug'] = true;
$GLOBALS['TYPO3_CONF_VARS']['FE']['debug'] = true;
$GLOBALS['TYPO3_CONF_VARS']['BE']['loginRateLimit'] = 0;
$GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['deprecations']['writerConfiguration'][LogLevel::NOTICE]['TYPO3\CMS\Core\Log\Writer\FileWriter']['disabled'] = false;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] = '*';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = 1;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] = 'file';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['exceptionalErrors'] = 12290;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] .= ' | Development DDEV';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern'] = '.*';

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(
    $GLOBALS['TYPO3_CONF_VARS'],
    [
        'DB' => [
            'Connections' => [
                'Default' => [
                    'dbname' => 'db',
                    'driver' => 'mysqli',
                    'host' => 'db',
                    'password' => 'db',
                    'port' => '3306',
                    'user' => 'db',
                ],
            ],
        ],
        // This GFX configuration allows processing by installed ImageMagick 6
        'GFX' => [
            'processor' => 'GraphicsMagick',
            'processor_path' => '/usr/bin/',
            'processor_path_lzw' => '/usr/bin/',
        ],
        // This mail configuration sends all emails to mailhog
        'MAIL' => [
            'transport' => 'smtp',
            'transport_smtp_encrypt' => false,
            'transport_smtp_server' => 'localhost:1025',
        ],
        'SYS' => [
            'trustedHostsPattern' => '.*.*',
            'devIPmask' => '*',
            'displayErrors' => 1,
        ],
    ]
);

