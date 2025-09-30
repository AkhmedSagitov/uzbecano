<?php

declare(strict_types=1);

$headerComment = <<<COMMENT
This file is part of the "Kickstarter Website".

For the full copyright and license information, please read the
LICENSE.txt file that was distributed with this source code.

(c) Leuchtfeuer Digital Marketing <dev@Leuchtfeuer.com>
COMMENT;

$config = include './vendor/leuchtfeuer/ci-config/php-cs-fixer/config.php';
$config->setHeader($headerComment, true);

$finder = $config->getFinder()
    ->exclude('solrfal');
$config->setFinder($finder);

return $config;
