<?php

namespace Jundat\Todo\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Todo extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'jundat_todo';

    protected $_cacheTag = 'jundat_todo';

    protected $_eventPrefix = 'jundat_todo';

    public function _construct()
    {
        $this->_init(\Jundat\Todo\Model\ResourceModel\Todo::class);
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
