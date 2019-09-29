<?php

namespace Jundat\Todo\Model\ResourceModel\Todo;

use Jundat\Todo\Model\Todo;
use Jundat\Todo\Model\ResourceModel\Todo as TodoResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            Todo::class,
            TodoResource::class
        );
    }
}
