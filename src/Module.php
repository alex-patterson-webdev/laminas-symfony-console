<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole;

use Arp\LaminasSymfonyConsole\Service\ConsoleCommandConfigProviderInterface;
use Arp\LaminasSymfonyConsole\Service\ConsoleCommandManager;
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

        $this->bootstrapConsoleCommandManager($serviceManager);
    }

    /**
     * @param ContainerInterface $container
     */
    private function bootstrapConsoleCommandManager(ContainerInterface $container): void
    {
        /** @var ServiceListenerInterface $serviceListener */
        $serviceListener = $container->get('ServiceListener');

        $serviceListener->addServiceManager(
            ConsoleCommandManager::class,
            'laminas_symfony_console',
            ConsoleCommandConfigProviderInterface::class,
            'getConsoleCommandConfig'
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
