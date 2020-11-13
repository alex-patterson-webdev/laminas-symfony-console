<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole;

use Arp\LaminasSymfonyConsole\Factory\Module\CommandManagerFactory;
use Arp\LaminasSymfonyConsole\Factory\Service\ApplicationFactory;
use Arp\LaminasSymfonyConsole\Factory\Module\HelperManagerFactory;
use Arp\LaminasSymfonyConsole\Module\CommandManager;
use Arp\LaminasSymfonyConsole\Module\HelperManager;
use Symfony\Component\Console\Application;

return [
    'arp_console_command_manager' => [
        'factories' => [

        ],
    ],
    'arp_console_helper_manager' => [
        'factories' => [

        ],
    ],
    'service_manager' => [
        'factories' => [
            Application::class => ApplicationFactory::class,

            // Plugin Managers
            CommandManager::class => CommandManagerFactory::class,
            HelperManager::class => HelperManagerFactory::class,
        ],
    ],
];
