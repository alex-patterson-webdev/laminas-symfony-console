<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Module\Feature;

interface HelperConfigProviderInterface
{
    /**
     * @return array
     */
    public function getConsoleHelperManagerConfig(): array;
}
