<?php

namespace Jundat\Queue\Api;

use Magento\Framework\Exception\CouldNotSaveException;

/***
 *
 * @api
 */
interface SpecialPriceInterface
{

    /**
     * setSpecialPrice
     *
     * @param \Jundat\Queue\Api\Data\SpecialPriceInterface[] $prices
     * @return \Jundat\Queue\Api\Data\SpecialPriceResultInterface[]
     * @throws CouldNotSaveException
     */
    public function setSpecialPrice(array $prices);
}
