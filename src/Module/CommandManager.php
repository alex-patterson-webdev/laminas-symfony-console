<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Module;

use Laminas\ServiceManager\AbstractPluginManager;
use Symfony\Component\Console\Command\Command;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Module
 */
class CommandManager extends AbstractPluginManager
{
    /**
     * @var string
     */
    protected $instanceOf = Command::class;
}
