<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Module\Feature;

interface CommandConfigProviderInterface
{
    /**
     * @return array<mixed>
     */
    public function getConsoleCommandManagerConfig(): array;
}
