<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Command;

use Arp\LaminasSymfonyConsole\Module\CommandManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class CommandLoader implements CommandLoaderInterface
{
    public function __construct(
        private readonly CommandManager $commandManager,
        private readonly array $mapping
    ) {
    }

    public function get(string $name): Command
    {
        $serviceName = $this->mapping[$name] ?? $name;

        if (!$this->has($serviceName)) {
            throw new CommandNotFoundException(
                sprintf('Unable to find console command \'%s\' registered with the service manager', $serviceName)
            );
        }

        return $this->get($serviceName);
    }

    public function has(string $name): bool
    {
        return false;
    }

    public function getNames()
    {
        return [];
    }
}
