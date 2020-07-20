<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Factory\Service;

use Arp\LaminasSymfonyConsole\Service\ConsoleCommandManager;
use Laminas\Mvc\Service\AbstractPluginManagerFactory;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Factory\Service
 */
class ConsoleCommandManagerFactory extends AbstractPluginManagerFactory
{
    public const PLUGIN_MANAGER_CLASS = ConsoleCommandManager::class;
}
