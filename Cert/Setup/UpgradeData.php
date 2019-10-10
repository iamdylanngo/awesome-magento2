<?php

namespace Jundat\Cert\Setup;

use Magento\Customer\Model\Customer;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
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
     * @var \Magento\Sales\Setup\SalesSetup $salesSetup
     */
    protected $salesSetup;

    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Eav\Model\Config $eavConfig
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    /**
     * Upgrades data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Validate_Exception
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/cert-update-data.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $logger->info("start update data");

        if (version_compare($context->getVersion(), '2.0.8', '>')) {
            /**
             * @var \Magento\Eav\Setup\EavSetup $eavSetup
             */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            $eavSetup->addAttribute(
                Customer::ENTITY,
                'customer_favorites',
                [
                    'type'         => 'varchar', // attribute with varchar type
                    'label'        => 'Customer Favorites', // label
                    'input'        => 'text',  // attribute input field is text
                    'required'     => false,  // field is not required
                    'visible'      => true,
                    'user_defined' => true,
                    'position'     => 150,
                    'sort_order'  => 150,
                    'system'       => true,
                ]
            );

            /**
             * @var \Magento\Eav\Model\Entity\Attribute $attribute
             */
            $attribute = $this->eavConfig->getAttribute(
                Customer::ENTITY,
                'customer_favorites'
            );

            $attribute->setData(
                'used_in_forms',
                ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address', 'customer_account_create']

            );

            $logger->info("add attribute success");

            $eavSetup->addAttribute(
                \Magento\Sales\Model\Order::ENTITY,
                'custom_attribute',
                [
                    'type'         => 'varchar',            // attribute with varchar type
                    'label'        => 'Custom Attribute',   // label
                    'input'        => 'text',               // attribute input field is text
                    'required'     => false,                // field is not required
                    'visible'      => true,
                    'user_defined' => true,
                    'position'     => 150,
                    'sort_order'  => 150,
                    'system'       => true,
                ]
            );

        }

        $installer->endSetup();
    }
}
