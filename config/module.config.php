<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole;

use Arp\LaminasSymfonyConsole\Factory\Service\ConsoleCommandManagerFactory;
use Arp\LaminasSymfonyConsole\Factory\Service\ApplicationFactory;
use Arp\LaminasSymfonyConsole\Service\CommandManager;
use Symfony\Component\Console\Application;

return [
    'laminas_symfony_console' => [
        'factories' => [

        ],
    ],

    'service_manager' => [
        'factories' => [
            CommandManager::class => ConsoleCommandManagerFactory::class,

            Application::class => ApplicationFactory::class,
        ],
    ],
];
