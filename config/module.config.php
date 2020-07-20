<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole;

use Arp\LaminasSymfonyConsole\Factory\ApplicationFactory;
use Arp\LaminasSymfonyConsole\Factory\Service\ConsoleCommandManagerFactory;
use Arp\LaminasSymfonyConsole\Factory\Service\SymfonyApplicationFactory;
use Arp\LaminasSymfonyConsole\Service\Application;
use Arp\LaminasSymfonyConsole\Service\ConsoleCommandManager;
use Symfony\Component\Console\Application as SymfonyApplication;

return [
    'service_manager' => [
        'factories' => [
            Application::class => ApplicationFactory::class,
            SymfonyApplication::class => SymfonyApplicationFactory::class,

            ConsoleCommandManager::class => ConsoleCommandManagerFactory::class,
        ],
    ],
    'laminas_symfony_console' => [
        'factories' => [

        ],
    ],
];
