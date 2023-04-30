<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Factory\Service;

use Arp\LaminasFactory\AbstractFactory;
use Arp\LaminasSymfonyConsole\Module\CommandManager;
use Arp\LaminasSymfonyConsole\Module\HelperManager;
use Arp\LaminasSymfonyConsole\Service\Application;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputOption;

final class ApplicationFactory extends AbstractFactory
{
    private const NAME_UNKNOWN = 'UNKNOWN';
    private const VERSION_UNKNOWN = 'UNKNOWN';

    private string $defaultClassName = Application::class;

    /**
     * @throws ServiceNotCreatedException
     * @throws ServiceNotFoundException
     * @throws ContainerExceptionInterface
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): Application
    {
        $options = $options ?? $this->getServiceOptions($container, $requestedName);

        $name = $options['name'] ?? self::NAME_UNKNOWN;
        $version = $options['version'] ?? self::VERSION_UNKNOWN;

        /** @var Application $application */
        $application = new $this->defaultClassName($name, $version);

        if (!empty($options['command_loader'])) {
            $application->setCommandLoader(
                $this->getCommandLoader($container, $options['command_loader'], $requestedName)
            );
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
            foreach ($this->getHelpers($container, $options['helpers'], $requestedName) as $alias => $helper) {
                $helperSet->set($helper, $alias);
            }
        }

        if (!empty($options['commands'])) {
            $application->addCommands($this->getCommands($container, $options['commands'], $requestedName));
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

        if (!empty($options['global_input_options'])) {
            $this->registerGlobalInputOptions(
                $container,
                $application,
                $options['global_input_options'],
                $requestedName
            );
        }

        return $application;
    }

    /**
     * @throws ServiceNotCreatedException
     * @throws ServiceNotFoundException
     * @throws ContainerExceptionInterface
     */
    private function getCommandLoader(
        ContainerInterface $container,
        CommandLoaderInterface|string $commandLoader,
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
                    get_debug_type($commandLoader),
                    $serviceName
                )
            );
        }

        return $commandLoader;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
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
                        get_debug_type($command),
                        $serviceName
                    )
                );
            }

            $commands[] = $command;
        }

        return $commands;
    }

    /**
     * @return array<string, HelperInterface>
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getHelpers(ContainerInterface $container, array $helperConfig, string $serviceName): array
    {
        /** @var HelperManager $helperManager */
        $helperManager = $container->get(HelperManager::class);

        $helpers = [];
        foreach ($helperConfig as $name => $helper) {
            if (is_string($helper)) {
                $helper = $this->getService($helperManager, $helper, $serviceName);
            }

            if (!$helper instanceof HelperInterface) {
                throw new ServiceNotCreatedException(
                    sprintf(
                        'The command must be an object of type \'%s\'; \'%s\' provided for service \'%s\'',
                        HelperInterface::class,
                        get_debug_type($helper),
                        $serviceName
                    )
                );
            }

            $name = is_string($name) ? $name : $helper->getName();
            $helpers[$name] = $helper;
        }

        return $helpers;
    }

    /**
     * @throws ServiceNotCreatedException
     * @throws ServiceNotFoundException
     * @throws ContainerExceptionInterface
     */
    private function registerGlobalInputOptions(
        ContainerInterface $container,
        Application $application,
        array $inputOptions,
        string $serviceName
    ): void {
        $options = [];
        foreach ($inputOptions as $inputOption) {
            if (is_string($inputOption)) {
                $inputOption = $this->getService($container, $inputOption, $serviceName);
            }
            if ($inputOption instanceof InputOption) {
                $options[$inputOption->getName()] = $inputOption;
            }
        }

        if (empty($options)) {
            return;
        }

        foreach ($application->all() as $command) {
            $command->getDefinition()->addOptions($options);
        }
    }
}
