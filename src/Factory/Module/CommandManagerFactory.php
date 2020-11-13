<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Factory\Module;

use Arp\LaminasFactory\AbstractFactory;
use Arp\LaminasSymfonyConsole\Module\CommandManager;
use Interop\Container\ContainerInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Factory\Module
 */
final class CommandManagerFactory extends AbstractFactory
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
        $config = $options ?? $this->getApplicationOptions($container, 'arp_console_command_manager');

        return new CommandManager($container, $config);
    }
}
