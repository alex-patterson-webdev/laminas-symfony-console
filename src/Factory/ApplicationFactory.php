<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Factory;

use Arp\LaminasFactory\AbstractFactory;
use Arp\LaminasSymfonyConsole\Service\Application;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Symfony\Component\Console\Application as SymfonyApplication;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Factory
 */
final class ApplicationFactory extends AbstractFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return Application
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Application
    {
        $options = $options ?? $this->getServiceOptions($container, $requestedName);

        /**
         * @var ServiceLocatorInterface|ContainerInterface $container
         * @var SymfonyApplication                         $application
         */
        $application = $this->buildService(
            $container,
            SymfonyApplication::class,
            $options,
            $requestedName
        );

        return new Application($application);
    }
}
