<?php

namespace Esgi\Brewery\Block\Adminhtml\Product\Edit\Tab;

use Esgi\Brewery\Model\Brewery;
use Esgi\Brewery\Model\ResourceModel\Brewery\Product\Collection;
use Esgi\Brewery\Model\ResourceModel\Brewery\Product\CollectionFactory;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Catalog\Model\Product;

/**
 * Class Related
 * @package Esgi\Brewery\Block\Adminhtml\Product\Edit\Tab
 */
class Related extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Tab\Related
{
    /** @var CollectionFactory $_breweryProductsCollectionFactory */
    protected $_breweryProductsCollectionFactory;
    /** @var \Esgi\Brewery\Api\BreweryRepositoryInterface $_breweryRepository */
    protected $_breweryRepository;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Catalog\Model\Product\LinkFactory $linkFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $setsFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Catalog\Model\Product\Type $type
     * @param \Magento\Catalog\Model\Product\Attribute\Source\Status $status
     * @param \Magento\Catalog\Model\Product\Visibility $visibility
     * @param \Magento\Framework\Registry $coreRegistry
     * @param CollectionFactory $breweryProductsCollectionFactory
     * @param \Esgi\Brewery\Api\BreweryRepositoryInterface $breweryRepository
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Catalog\Model\Product\LinkFactory $linkFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $setsFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\Product\Type $type,
        \Magento\Catalog\Model\Product\Attribute\Source\Status $status,
        \Magento\Catalog\Model\Product\Visibility $visibility,
        \Magento\Framework\Registry $coreRegistry,
        CollectionFactory $breweryProductsCollectionFactory,
        \Esgi\Brewery\Api\BreweryRepositoryInterface $breweryRepository,
        array $data = []
    ) {
        $this->_linkFactory = $linkFactory;
        $this->_setsFactory = $setsFactory;
        $this->_productFactory = $productFactory;
        $this->_type = $type;
        $this->_status = $status;
        $this->_visibility = $visibility;
        $this->_coreRegistry = $coreRegistry;
        $this->_breweryProductsCollectionFactory = $breweryProductsCollectionFactory;
        $this->_breweryRepository = $breweryRepository;
        parent::__construct($context, $backendHelper, $linkFactory, $setsFactory, $productFactory, $type, $status, $visibility, $coreRegistry, $data);
    }

    /**
     * Retrieve currently edited product model
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->_productFactory->create();
    }

    /**
     * Checks when this block is readonly
     *
     * @return bool
     */
    public function isReadonly()
    {
        return false;
    }

    /**
     * Prepare collection
     *
     * @return Extended
     */
    protected function _prepareCollection()
    {
        $collection = $collection = $this->_productFactory->create()
            ->getCollection()
            ->addAttributeToSelect('*');

        if ($this->isReadonly()) {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = [0];
            }
            $collection->addFieldToFilter('entity_id', ['in' => $productIds]);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Add columns to grid
     *
     * @return \Magento\Catalog\Block\Adminhtml\Product\Edit\Tab\Related
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @throws \Exception
     */
    protected function _prepareColumns()
    {
        if (!$this->isReadonly()) {
            $this->addColumn(
                'in_products',
                [
                    'type' => 'checkbox',
                    'name' => 'in_products',
                    'values' => $this->_getSelectedProducts(),
                    'align' => 'center',
                    'index' => 'entity_id',
                    'header_css_class' => 'col-select',
                    'column_css_class' => 'col-select'
                ]
            );
        }

        $this->addColumn(
            'entity_id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );

        $this->addColumn(
            'type',
            [
                'header' => __('Type'),
                'index' => 'type_id',
                'type' => 'options',
                'options' => $this->_type->getOptionArray(),
                'header_css_class' => 'col-type',
                'column_css_class' => 'col-type'
            ]
        );

        $sets = $this->_setsFactory->create()->setEntityTypeFilter(
            $this->_productFactory->create()->getResource()->getTypeId()
        )->load()->toOptionHash();

        $this->addColumn(
            'set_name',
            [
                'header' => __('Attribute Set'),
                'index' => 'attribute_set_id',
                'type' => 'options',
                'options' => $sets,
                'header_css_class' => 'col-attr-name',
                'column_css_class' => 'col-attr-name'
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => $this->_status->getOptionArray(),
                'header_css_class' => 'col-status',
                'column_css_class' => 'col-status'
            ]
        );

        $this->addColumn(
            'visibility',
            [
                'header' => __('Visibility'),
                'index' => 'visibility',
                'type' => 'options',
                'options' => $this->_visibility->getOptionArray(),
                'header_css_class' => 'col-visibility',
                'column_css_class' => 'col-visibility'
            ]
        );

        $this->addColumn(
            'sku',
            [
                'header' => __('SKU'),
                'index' => 'sku',
                'header_css_class' => 'col-sku',
                'column_css_class' => 'col-sku'
            ]
        );

        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'currency_code' => (string)$this->_scopeConfig->getValue(
                    \Magento\Directory\Model\Currency::XML_PATH_CURRENCY_BASE,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                ),
                'index' => 'price',
                'header_css_class' => 'col-price',
                'column_css_class' => 'col-price'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Rerieve grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl(
            'brewery/product/relatedGrid',
            ['_current' => true, 'collapse' => null]
        );
    }

    /**
     * Retrieve related products
     *
     * @return array
     */
    public function getSelectedRelatedProducts()
    {
        /** @var mixed[] $products */
        $products = [];
        /** @var Brewery|bool $brewery */
        $brewery = $this->getBrewery();
        if ($brewery === false) {
            return $products;
        }
        /** @var Collection $collection */
        $collection = $this->_breweryProductsCollectionFactory->create();
        $collection->addBreweryFilter($this->getBrewery());
        foreach ($collection as $product) {
            $products[$product->getId()] = ['position' => $product->getPosition()];
        }

        return $products;
    }

    /**
     * @return \Esgi\Brewery\Api\Data\BreweryInterface|false
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBrewery()
    {
        /** @var int $breweryId */
        $breweryId = (int)$this->getRequest()->getParam('id', null);
        if ($breweryId < 1) {
            return false;
        }

        return $this->_breweryRepository->getById($breweryId);
    }
}
