<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();



ExtensionManagementUtility::addTypoScriptSetup('
    module.tx_form {
        settings {
            yamlConfigurations {
                100 = EXT:telegram_messenger/Configuration/Form/FormSetup.yaml
            }
        }
    }
    plugin.tx_form {
        settings {
            yamlConfigurations {
                100 = EXT:telegram_messenger/Configuration/Form/FormSetup.yaml
            }
        }
    }
');
