<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Module;

use Laminas\ServiceManager\AbstractPluginManager;
use Symfony\Component\Console\Helper\HelperInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Module
 */
final class HelperManager extends AbstractPluginManager
{
    /**
     * @var string
     */
    protected $instanceOf = HelperInterface::class;
}