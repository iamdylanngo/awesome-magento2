<?php

/**
 * Jundat
 *
 * Copyright © Jundat LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.jundat95.com | it.tinhngo@gmail.com
 */

namespace Jundat\Reindex\Model\Config\Source;

class ListMode implements \Magento\Framework\Option\ArrayInterface {

    const ASYNC = 'async';
    const SYNC  = 'sync';

    public function toOptionArray()
    {
     return [
       ['value' => self::ASYNC, 'label' => __('Asynchronous Reindex')],
       ['value' => self::SYNC,  'label' => __('Synchronous Reindex')]
     ];
    }
}