<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Module;

use Laminas\ServiceManager\AbstractPluginManager;
use Symfony\Component\Console\Helper\HelperInterface;

final class HelperManager extends AbstractPluginManager
{
    /**
     * @var string
     */
    protected $instanceOf = HelperInterface::class;
}
