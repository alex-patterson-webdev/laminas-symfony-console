<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Factory\Service;

use Arp\LaminasFactory\AbstractFactory;
use Arp\LaminasSymfonyConsole\Service\CommandManager;
use Interop\Container\ContainerInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Factory\Service
 */
final class ConsoleCommandManagerFactory extends AbstractFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return CommandManager
     *
     * @noinspection PhpMissingParamTypeInspection
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): CommandManager
    {
        $config = $options ?? $this->getApplicationOptions($container, 'laminas_symfony_console');

        return new CommandManager($container, $config);
    }
}
