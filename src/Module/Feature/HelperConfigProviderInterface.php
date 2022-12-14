<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Module\Feature;

interface HelperConfigProviderInterface
{
    /**
     * @return array<mixed>
     */
    public function getConsoleHelperManagerConfig(): array;
}
