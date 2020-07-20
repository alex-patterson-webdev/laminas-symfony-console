<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Factory\Service;

use Arp\LaminasFactory\AbstractFactory;
use Arp\LaminasFactory\Exception\ServiceNotCreatedException;
use Arp\LaminasSymfonyConsole\Service\ConsoleCommandManager;
use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Factory\Service
 */
final class SymfonyApplicationFactory extends AbstractFactory
{
    private const NAME_UNKNOWN = 'UNKNOWN';
    private const VERSION_UNKNOWN = 'UNKNOWN';

    /**
     * @var string
     */
    private $defaultClassName = SymfonyApplication::class;

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return SymfonyApplication
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
            /** @var ConsoleCommandManager $commandManager */
            $commandManager = $container->get(ConsoleCommandManager::class);
            foreach ($options['commands'] as $command) {
                if (is_string($command)) {
                    $command = $this->getService($commandManager, $command, $requestedName);
                }
                if (!$command instanceof Command) {
                    throw new ServiceNotCreatedException(
                        sprintf(
                            'The command must be an object of type \'%s\'; \'%s\' provided for service \'%s\'',
                            Command::class,
                            (is_object($command) ? get_class($command) : gettype($command)),
                            $requestedName
                        )
                    );
                }
                $application->add($command);
            }
        }

//        $application->register();
//        $application->setDefinition();
//        $application->setAutoExit();
//        $application->setCatchExceptions();
//        $application->setHelperSet();
//        $application->setDefaultCommand();
//        $application->setDispatcher();
//        $application->setCommandLoader()

        return $application;
    }
}
