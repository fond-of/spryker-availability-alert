<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \FondOfSpryker\Zed\AvailabilityAlert\Business\AvailabilityAlertFacadeInterface getFacade()
 */
class NotifySubscribersConsole extends Console
{
    const COMMAND_NAME = 'availabiliy-alert:notify-subscribers';
    const COMMAND_DESCRIPTION = 'Notify subscribers that products are available again.';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::COMMAND_DESCRIPTION);
        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->getFacade()->notifySubscribers();
    }
}
