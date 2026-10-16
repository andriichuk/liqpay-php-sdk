<?php

declare(strict_types=1);
use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config)
    ->setRiskyAllowed(true)
    ->setRules(require __DIR__.'/tools/php-cs-fixer/laravel.php')
    ->setFinder(Finder::create()
        ->in([__DIR__.'/src', __DIR__.'/tests', __DIR__.'/tools/php-cs-fixer'])
        ->append([__FILE__]));
