<?php

namespace FondOfSpryker\Zed\AvailabilityAlert\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \FondOfSpryker\Zed\AvailabilityAlert\Business\AvailabilityAlertFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\AvailabilityAlert\Persistence\AvailabilityAlertQueryContainerInterface getQueryContainer()
 * @method \FondOfSpryker\Zed\AvailabilityAlert\Communication\AvailabilityAlertCommunicationFactory getFactory()
 */
class NotifySubscribersConsole extends Console
{
    public const COMMAND_NAME = 'availabiliy-alert:notify-subscribers';
    public const COMMAND_DESCRIPTION = 'Notify subscribers that products are available again.';

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
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->getFacade()->notifySubscribers();
        }
        catch (\Exception $exception){
            return Console::CODE_ERROR;
        }
        return Console::CODE_SUCCESS;
    }
}
