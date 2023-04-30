<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Module;

use Laminas\ServiceManager\AbstractPluginManager;
use Symfony\Component\Console\Command\Command;

class CommandManager extends AbstractPluginManager
{
    /**
     * @var class-string<Command>
     */
    protected $instanceOf = Command::class;
}
