<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Module\Feature;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Module\Feature
 */
interface HelperConfigProviderInterface
{
    /**
     * @return array
     */
    public function getConsoleHelperManagerConfig(): array;
}
