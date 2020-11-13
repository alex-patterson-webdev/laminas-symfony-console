<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole;

use Arp\LaminasSymfonyConsole\Module\CommandManager;
use Arp\LaminasSymfonyConsole\Module\Feature\CommandConfigProviderInterface;
use Arp\LaminasSymfonyConsole\Module\Feature\HelperConfigProviderInterface;
use Arp\LaminasSymfonyConsole\Module\HelperManager;
use Laminas\ModuleManager\Listener\ServiceListenerInterface;
use Laminas\ModuleManager\ModuleManager;
use Laminas\ModuleManager\ModuleManagerInterface;
use Psr\Container\ContainerInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole
 */
final class Module
{
    /**
     * @param ModuleManagerInterface|ModuleManager $moduleManager
     */
    public function init(ModuleManagerInterface $moduleManager): void
    {
        /** @var ContainerInterface $serviceManager */
        $serviceManager = $moduleManager->getEvent()->getParam('ServiceManager');

        /** @var ServiceListenerInterface $serviceListener */
        $serviceListener = $serviceManager->get('ServiceListener');

        $serviceListener->addServiceManager(
            CommandManager::class,
            'arp_console_command_manager',
            CommandConfigProviderInterface::class,
            'getConsoleCommandManagerConfig'
        );

        $serviceListener->addServiceManager(
            HelperManager::class,
            'arp_console_helper_manager',
            HelperConfigProviderInterface::class,
            'getConsoleHelperManagerConfig'
        );
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return require __DIR__ . '/../config/module.config.php';
    }
}
