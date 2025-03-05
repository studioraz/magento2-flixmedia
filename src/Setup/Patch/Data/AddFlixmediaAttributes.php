<?php
/**
 * Copyright © 2018 Studio Raz. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace SR\Flixmedia\src\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use SR\Flixmedia\src\Model\Data\ProductAttributes;

class AddFlixmediaAttributes implements DataPatchInterface
{
    private const ATTRIBUTE_SET = 'Default';

    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var EavSetupFactory */
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        // Remove existing attributes before re-adding them
        $attributesToRemove = [
            ProductAttributes::FLIXMEDIA_ENABLED,
            ProductAttributes::FLIXMEDIA_EAN,
            ProductAttributes::FLIXMEDIA_MPN
        ];

        foreach ($attributesToRemove as $attributeCode) {
            if ($eavSetup->getAttributeId(Product::ENTITY, $attributeCode)) {
                $eavSetup->removeAttribute(Product::ENTITY, $attributeCode);
            }
        }

        $attributeSetId = $eavSetup->getDefaultAttributeSetId(Product::ENTITY);
        $eavSetup->addAttributeGroup(
            Product::ENTITY,
            $attributeSetId,
            ProductAttributes::FLIXMEDIA_ATTRIBUTE_GROUP,
            16 // Positioning after "Gift Options" and before "Downloadable Info"
        );

        $attrPropsDefault = [
            'group' => ProductAttributes::FLIXMEDIA_ATTRIBUTE_GROUP,
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => '',
            'input' => 'text',
            'visible' => true,
            'is_used_in_grid' => 1,
            'is_visible_in_grid' => 1,
            'is_filterable_in_grid' => 1,
            'is_searchable_in_grid' => 1,
            'required' => false,
            'user_defined' => false,
            'default' => null,
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'used_in_product_listing' => false,
            'unique' => false,
        ];

        $attributes = [
            ProductAttributes::FLIXMEDIA_ENABLED => [
                'type' => 'int',
                'label' => 'Enable Flixmedia',
                'input' => 'boolean',
                'source' => 'Magento\\Eav\\Model\\Entity\\Attribute\\Source\\Boolean'
            ],
            ProductAttributes::FLIXMEDIA_MPN => [
                'label' => 'Flixmedia MPN',
            ],
            ProductAttributes::FLIXMEDIA_EAN => [
                'label' => 'Flixmedia EAN',
            ],
        ];

        foreach ($attributes as $attrId => $attrProps) {
            $attrProps = array_replace_recursive($attrPropsDefault, $attrProps);
            $eavSetup->addAttribute(Product::ENTITY, $attrId, $attrProps);
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }
}
