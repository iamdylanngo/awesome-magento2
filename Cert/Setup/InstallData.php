<?php

namespace Jundat\Cert\Setup;

use Magento\Customer\Model\Customer;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    /**
     * @var \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * @var \Magento\Eav\Model\Config $eavConfig
     */
    protected $eavConfig;

    /**
     * InstallData constructor.
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     * @param \Magento\Eav\Model\Config $eavConfig
     */
    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Eav\Model\Config $eavConfig
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws \Exception
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->installCustomerAttribute($setup);
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @throws \Exception
     */
    public function installCustomerAttribute(ModuleDataSetupInterface $setup)
    {
        /**
         * @var \Magento\Eav\Setup\EavSetup $eavSetup
         */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            Customer::ENTITY,
            'phone_number',
            [
                'type'         => 'varchar', // attribute with varchar type
                'label'        => 'Phone Number',
                'input'        => 'text',  // attribute input field is text
                'required'     => false,  // field is not required
                'visible'      => true,
                'user_defined' => false,
                'position'     => 999,
                'sort_order'  => 999,
                'system'       => 0,
                'is_used_in_grid' => 1,   //setting grid options
                'is_visible_in_grid' => 1,
                'is_filterable_in_grid' => 1,
                'is_searchable_in_grid' => 1,
            ]
        );

        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'phone_number');

        $attribute->setData(
            'used_in_forms',
            ['adminhtml_customer', 'customer_account_create']

        );
        $attribute->save();

        /**
         * Create a select box attribute
         */
        $attributeCode = 'my_customer_type';

        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            $attributeCode,
            [
                'type' => 'int',
                'label' => 'My Customer Type',
                'input' => 'select',
                'source' => 'Jundat\Cert\Model\Config\Source\MyCustomerType',
                'required' => false,
                'visible' => true,
                'position' => 300,
                'system' => false,
                'backend' => ''
            ]
        );

        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, $attributeCode);

        //ex ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address', 'customer_account_create']
        $attribute->setData(
            'used_in_forms',
            ['adminhtml_customer', 'customer_account_create']

        );
        $attribute->save();
    }
}
