<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Factory\Module;

use Arp\LaminasFactory\AbstractFactory;
use Arp\LaminasSymfonyConsole\Module\HelperManager;
use Interop\Container\ContainerInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Factory\Module
 */
final class HelperManagerFactory extends AbstractFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return HelperManager
     *
     * @noinspection PhpMissingParamTypeInspection
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): HelperManager
    {
        $config = $options ?? $this->getApplicationOptions($container, 'arp_console_helper_manager');

        return new HelperManager($container, $config);
    }
}
