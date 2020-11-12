<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Service;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Service
 */
interface CommandConfigProviderInterface
{
    /**
     * Return the service configuration for the console command manager.
     *
     * @return array
     */
    public function getConsoleCommandConfig(): array;
}
