<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Factory\Service;

use Arp\LaminasFactory\AbstractFactory;
use Arp\LaminasFactory\Exception\ServiceNotCreatedException;
use Arp\LaminasSymfonyConsole\Module\CommandManager;
use Arp\LaminasSymfonyConsole\Module\HelperManager;
use Arp\LaminasSymfonyConsole\Service\Application;
use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Factory\Service
 */
final class ApplicationFactory extends AbstractFactory
{
    private const NAME_UNKNOWN = 'UNKNOWN';
    private const VERSION_UNKNOWN = 'UNKNOWN';

    /**
     * @var string
     */
    private string $defaultClassName = Application::class;

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return Application
     *
     * @noinspection PhpMissingParamTypeInspection
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Application
    {
        $options = $options ?? $this->getServiceOptions($container, $requestedName);

        $name = $options['name'] ?? static::NAME_UNKNOWN;
        $version = $options['version'] ?? static::VERSION_UNKNOWN;

        /** @var Application $application */
        $application = new $this->defaultClassName($name, $version);

        if (!empty($options['command_loader'])) {
            $application->setCommandLoader(
                $this->getCommandLoader($container, $options['command_loader'], $requestedName)
            );
        }

        if (!empty($options['commands'])) {
            $application->addCommands($this->getCommands($container, $options['commands'], $requestedName));
        }

        if (!empty($options['helper_set'])) {
            if (is_string($options['helper_set'])) {
                $options['helper_set'] = $this->getService($container, $options['helper_set'], $requestedName);
            }
            if ($options['helper_set'] instanceof HelperSet) {
                $application->setHelperSet($options['helper_set']);
            }
        }

        if (!empty($options['helpers'])) {
            $helperSet = $application->getHelperSet();
            foreach ($this->getHelpers($container, $options['helpers'], $requestedName) as $helper) {
                $helperSet->set($helper);
            }
        }

        if (isset($options['auto_exit'])) {
            $application->setAutoExit((bool)$options['auto_exit']);
        }

        if (isset($options['catch_exceptions'])) {
            $application->setCatchExceptions((bool)$options['catch_exceptions']);
        }

        if (isset($options['default_command'])) {
            $application->setDefaultCommand($options['default_command']);
        }

        // @todo $application->setDispatcher();

        return $application;
    }

    /**
     * @param ContainerInterface $container
     * @param CommandLoaderInterface|string $commandLoader
     * @param string $serviceName
     *
     * @return CommandLoaderInterface
     */
    private function getCommandLoader(
        ContainerInterface $container,
        $commandLoader,
        string $serviceName
    ): CommandLoaderInterface {
        if (is_string($commandLoader)) {
            $commandLoader = $this->getService($container, $commandLoader, $serviceName);
        }

        if (!$commandLoader instanceof CommandLoaderInterface) {
            throw new ServiceNotCreatedException(
                sprintf(
                    'The command loader must be an object of type \'%s\'; \'%s\' provided for service \'%s\'',
                    CommandLoaderInterface::class,
                    (is_object($commandLoader) ? get_class($commandLoader) : gettype($commandLoader)),
                    $serviceName
                )
            );
        }

        return $commandLoader;
    }

    /**
     * @param ContainerInterface $container
     * @param array              $data
     * @param string             $serviceName
     *
     * @return array
     *
     * @throws ServiceNotCreatedException
     */
    private function getCommands(ContainerInterface $container, array $data, string $serviceName): array
    {
        /** @var CommandManager $commandManager */
        $commandManager = $container->get(CommandManager::class);

        $commands = [];
        foreach ($data as $command) {
            if (is_string($command)) {
                $command = $this->getService($commandManager, $command, $serviceName);
            }

            if (!$command instanceof Command) {
                throw new ServiceNotCreatedException(
                    sprintf(
                        'The command must be an object of type \'%s\'; \'%s\' provided for service \'%s\'',
                        Command::class,
                        (is_object($command) ? get_class($command) : gettype($command)),
                        $serviceName
                    )
                );
            }

            $commands[] = $command;
        }

        return $commands;
    }

    /**
     * @param ContainerInterface $container
     * @param array              $helperConfig
     * @param string             $serviceName
     *
     * @return HelperInterface[]
     *
     * @throws ServiceNotCreatedException
     */
    private function getHelpers(ContainerInterface $container, array $helperConfig, string $serviceName): array
    {
        /** @var HelperManager $helperManager */
        $helperManager = $container->get(HelperManager::class);

        $helpers = [];
        foreach ($helperConfig as $helper) {
            if (is_string($helper)) {
                $helper = $this->getService($helperManager, $helper, $serviceName);
            }

            if (!$helper instanceof HelperInterface) {
                throw new ServiceNotCreatedException(
                    sprintf(
                        'The command must be an object of type \'%s\'; \'%s\' provided for service \'%s\'',
                        HelperInterface::class,
                        (is_object($helper) ? get_class($helper) : gettype($helper)),
                        $serviceName
                    )
                );
            }

            $helpers[] = $helper;
        }

        return $helpers;
    }
}
