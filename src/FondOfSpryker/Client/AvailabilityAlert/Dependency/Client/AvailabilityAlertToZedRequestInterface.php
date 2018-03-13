<?php

namespace FondOfSpryker\Client\AvailabilityAlert\Dependency\Client;

use Spryker\Shared\Kernel\Transfer\TransferInterface;

interface AvailabilityAlertToZedRequestInterface
{
    /**
     * @param string $url
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $object
     * @param int|null $timeoutInSeconds
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function call($url, TransferInterface $object, $timeoutInSeconds = null);
}
