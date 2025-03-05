<?php
/**
 * Copyright © 2018 Studio Raz. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace SR\Flixmedia\Block;

use Magento\Catalog\Model\Product;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use SR\Flixmedia\Model\Data\ProductAttributes;

/**
 * Class Flixmedia
 * @package SR\Flixmedia\Block\Flixmedia
 */
class Flixmedia extends Template
{

    /**
     * @var Product
     */
    protected $product = null;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;


    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        if (!$this->product) {
            $this->product = $this->coreRegistry->registry('product');
        }
        return $this->product;
    }

    /**
     * check if possible to show Flixmedia flexmedia data
     *
     * @return bool
     */
    public function canShow()
    {
        return $this->isFlixmediaEnabled()
            && $this->getFlixDistributor()
            && $this->isEnabledForProduct()
            && $this->getFlixmediaBrand();
    }

    /**
     * @return mixed
     */
    public function isEnabledForProduct()
    {
        return (bool)$this->getProduct()->getFlixmediaEnabled();
    }

    /**
     * @return mixed
     */
    public function getFlixmediaBrand()
    {
        return $this->getProduct()->getAttributeText(ProductAttributes::FLIXMEDIA_BRAND);
    }

    /**
     * @return mixed
     */
    public function getFlixmediaEan()
    {
        return $this->getProduct()->getFlixmediaEan();
    }

    /**
     * @return mixed
     */
    public function getFlixmediaMpn()
    {
        return $this->getProduct()->getFlixmediaMpn();
    }

    /**
     * @return mixed
     */
    public function isFlixmediaEnabled()
    {
        return (bool)$this->scopeConfig->getValue(
            'srflixmedia/general/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getFlixDistributor()
    {
        return $this->scopeConfig->getValue(
            'srflixmedia/general/distributor_id',
            ScopeInterface::SCOPE_STORE
        );
    }
}
