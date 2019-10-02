<?php

namespace Jundat\Cert\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Exception\LocalizedException;
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
     * @var \Magento\Eav\Model\Config $config
     */
    protected $config;

    /**
     * @var \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * InstallData constructor.
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Eav\Model\Config $config,
        \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->config = $config;
        $this->customerSetupFactory = $customerSetupFactory;
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
        $setup->startSetup();
        $this->installCustomerAttribute($setup);
        $setup->endSetup();
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @throws \Exception
     */
    public function installCustomerAttribute(ModuleDataSetupInterface $setup)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        /**
         * @var \Magento\Customer\Setup\CustomerSetup $customerSetup
         */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        /**
         * Add attributes to the eav/attribute table
         */
        try {

            /**
             * Create a select box attribute
             */
            $attributeCode = 'my_customer_type';

            $customerSetup->addAttribute(
                \Magento\Customer\Model\Customer::ENTITY,
                $attributeCode,
                [
                    'type'         => 'varchar',
                    'label'        => 'Sample Attribute',
                    'input'        => 'text',
                    'required'     => false,
                    'visible'      => true,
                    'user_defined' => true,
                    'position'     => 999,
                    'system'       => 0,
                ]
            );
            // show the attribute in the following forms
            $attribute = $customerSetup
                ->getEavConfig()
                ->getAttribute(
                    \Magento\Customer\Model\Customer::ENTITY,
                    $attributeCode
                )
                ->addData(
                    ['used_in_forms' => [
                        'adminhtml_customer',
                        'adminhtml_checkout',
                        'customer_account_create',
                        'customer_account_edit'
                    ]
                    ]
                );
            $attribute->save();

        } catch (LocalizedException $e) {
        } catch (\Zend_Validate_Exception $e) {
        }
    }
}
