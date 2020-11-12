<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Factory\Service;

use Arp\LaminasFactory\AbstractFactory;
use Arp\LaminasFactory\Exception\ServiceNotCreatedException;
use Arp\LaminasSymfonyConsole\Service\CommandManager;
use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Application as SymfonyApplication;
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
    private string $defaultClassName = SymfonyApplication::class;

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return SymfonyApplication
     *
     * @noinspection PhpMissingParamTypeInspection
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): SymfonyApplication
    {
        $options = $options ?? $this->getServiceOptions($container, $requestedName);

        $name = $options['name'] ?? static::NAME_UNKNOWN;
        $version = $options['version'] ?? static::VERSION_UNKNOWN;

        /** @var SymfonyApplication $application */
        $application = new $this->defaultClassName($name, $version);

        /** @var CommandLoaderInterface|string $commandLoader */
        $commandLoader = $options['command_loader'] ?? null;
        if (null !== $commandLoader) {
            if (is_string($commandLoader)) {
                $commandLoader = $this->getService($container, $commandLoader, $requestedName);
            }
            $application->setCommandLoader($commandLoader);
        }

        if (!empty($options['commands'])) {
            $application->addCommands($this->getCommands($container, $options['commands'], $requestedName));
        }

        if (!empty($options['helpers'])) {
            $application->setHelperSet($this->getHelperSet($container, $options['helpers'], $requestedName));
        }


//        $application->register();
//        $application->setDefinition();
//        $application->setAutoExit();
//        $application->setCatchExceptions();
//        $application->setDefaultCommand();
//        $application->setDispatcher();
//        $application->setCommandLoader()

        return $application;
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
     * @param array              $helpers
     * @param string             $serviceName
     *
     * @return HelperSet
     *
     * @throws ServiceNotCreatedException
     */
    private function getHelperSet(ContainerInterface $container, array $helpers, string $serviceName): HelperSet
    {
        $helperSet = new HelperSet();
        foreach ($helpers as $helper) {
            if (is_string($helper)) {
                $helper = $this->getService($container, $helper, $serviceName);
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

            $helperSet->set($helper);
        }

        return $helperSet;
    }
}
