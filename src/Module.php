<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole;

use Arp\LaminasSymfonyConsole\Module\CommandManager;
use Arp\LaminasSymfonyConsole\Module\Feature\CommandConfigProviderInterface;
use Arp\LaminasSymfonyConsole\Module\Feature\HelperConfigProviderInterface;
use Arp\LaminasSymfonyConsole\Module\HelperManager;
use Laminas\ModuleManager\Listener\ServiceListenerInterface;
use Laminas\ModuleManager\ModuleManagerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class Module
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
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
