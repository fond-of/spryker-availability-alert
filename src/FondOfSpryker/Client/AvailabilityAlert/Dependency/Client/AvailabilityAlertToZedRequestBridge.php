<?php

namespace FondOfSpryker\Client\AvailabilityAlert\Dependency\Client;

use Spryker\Shared\Kernel\Transfer\TransferInterface;

class AvailabilityAlertToZedRequestBridge implements AvailabilityAlertToZedRequestInterface
{
    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \Spryker\Client\Storage\StorageClientInterface $zedRequestClient
     */
    public function __construct($zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param string $url
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $object
     * @param int|null $timeoutInSeconds
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function call($url, TransferInterface $object, $timeoutInSeconds = null)
    {
        return $this->zedRequestClient->call($url, $object, $timeoutInSeconds);
    }
}
