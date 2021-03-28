<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Command;

use Arp\LaminasSymfonyConsole\Module\CommandManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Exception\CommandNotFoundException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Command
 */
class CommandLoader implements CommandLoaderInterface
{
    /**
     * @var CommandManager
     */
    private CommandManager $commandManager;

    /**
     * @var array
     */
    private array $mapping;

    /**
     * @param CommandManager $commandManager
     * @param array          $mapping
     */
    public function __construct(CommandManager $commandManager, array $mapping)
    {
        $this->commandManager = $commandManager;
        $this->mapping = $mapping;
    }

    /**
     * @param string $name
     *
     * @return Command
     */
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

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        $serviceName = $this->mapping[$name] ?? $name;
    }

    public function getNames()
    {
        return [];
    }
}
