<?php

namespace Jundat\Queue\Model\Data;

use Jundat\Queue\Api\Data\SpecialPriceResultInterface;

/**
 * Class Custom Data
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class SpecialPriceResult extends \Magento\Framework\Api\AbstractExtensibleObject implements
    SpecialPriceResultInterface
{

    /**
     * Get message.
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->_get(self::MESSAGE);
    }

    /**
     * Set message.
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message = "")
    {
        return $this->setData(self::MESSAGE, $message);
    }
}
