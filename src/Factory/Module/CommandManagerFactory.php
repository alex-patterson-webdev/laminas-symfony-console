<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Factory\Module;

use Arp\LaminasFactory\AbstractFactory;
use Arp\LaminasSymfonyConsole\Module\CommandManager;
use Laminas\ServiceManager\Exception\InvalidArgumentException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Factory\Module
 */
final class CommandManagerFactory extends AbstractFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array<mixed>|null  $options
     *
     * @return CommandManager
     *
     * @throws InvalidArgumentException
     * @throws ServiceNotCreatedException
     * @throws ServiceNotFoundException
     * @throws ContainerExceptionInterface
     */
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        array $options = null
    ): CommandManager {
        $config = $options ?? $this->getApplicationOptions($container, 'arp_console_command_manager');

        return new CommandManager($container, $config);
    }
}
