<?php

declare(strict_types=1);

namespace Arp\LaminasSymfonyConsole\Service;

use Arp\LaminasSymfonyConsole\Exception\ApplicationException;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\LaminasSymfonyConsole\Service
 */
class Application
{
    /**
     * @var SymfonyApplication
     */
    private SymfonyApplication $application;

    /**
     * @param SymfonyApplication $application
     */
    public function __construct(SymfonyApplication $application)
    {
        $this->application = $application;
    }

    /**
     * @param Command $command
     */
    public function addCommand(Command $command): void
    {
        $this->application->add($command);
    }

    /**
     * @param InputInterface|null  $input
     * @param OutputInterface|null $output
     *
     * @return int
     *
     * @throws ApplicationException
     */
    public function run(InputInterface $input = null, OutputInterface $output = null): int
    {
        try {
            return $this->application->run($input, $output);
        } catch (\Throwable $e) {
            throw new ApplicationException(
                sprintf('Failed to execute console command : %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }
}
