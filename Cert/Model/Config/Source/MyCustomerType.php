<?php

namespace Jundat\Cert\Model\Config\Source;

class MyCustomerType extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => '', 'label' => __('Please Select')],
                ['value' => '1', 'label' => __('My Option 1')],
                ['value' => '2', 'label' => __('My Option 2')],
                ['value' => '3', 'label' => __('My Option 3')],
                ['value' => '4', 'label' => __('My Option 4')]
            ];
        }
        return $this->_options;
    }

    /**
     * Get text of the option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionValue($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}
