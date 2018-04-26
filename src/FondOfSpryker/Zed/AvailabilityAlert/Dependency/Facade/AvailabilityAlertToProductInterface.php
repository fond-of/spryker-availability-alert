<?php
/**
 * Created by PhpStorm.
 * User: paf
 * Date: 26.04.18
 * Time: 11:07
 */

namespace FondOfSpryker\Zed\AvailabilityAlert\Dependency\Facade;

interface AvailabilityAlertToProductInterface
{
    /**
     * @see \Spryker\Zed\Product\Business\ProductFacadeInterface
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractById($idProductAbstract);
}
