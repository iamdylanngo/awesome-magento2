<?php

namespace Jundat\Reindex\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{

    public function getConfigValue($config_path, $scope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            $scope
        );
    }

}