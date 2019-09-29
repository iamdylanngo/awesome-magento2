<?php

namespace Jundat\Queue\Api\Data;

/**
 * Custom Data interface.
 * @api
 */
interface SpecialPriceResultInterface extends \Magento\Framework\Api\CustomAttributesDataInterface
{
    /**#@+
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const MESSAGE = 'message';

    /**#@-*/

    /**
     * Get message.
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * Set message.
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message = "");
}
