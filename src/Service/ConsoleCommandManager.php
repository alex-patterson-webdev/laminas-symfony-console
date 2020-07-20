<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Service;

use Laminas\ServiceManager\AbstractPluginManager;
use Symfony\Component\Console\Command\Command;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Service
 */
class ConsoleCommandManager extends AbstractPluginManager
{
    /**
     * @var string
     */
    protected $instanceOf = Command::class;
}
