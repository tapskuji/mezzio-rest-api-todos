<?php
/**
 * This file is used with the Doctrine CLI console, which is accessed from the application root.
 *
 * $ php vendor/bin/doctrine list
 *
 * Or if using Docker container gain shell access first.
 *
 * https://github.com/DASPRiD/container-interop-doctrine
 */

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

$container = require __DIR__ . '/container.php';

return new HelperSet([
    'em' => new EntityManagerHelper(
        $container->get(EntityManager::class) // Factory for EntityManager mapped in App/ConfigProvider.php
    ),
]);
