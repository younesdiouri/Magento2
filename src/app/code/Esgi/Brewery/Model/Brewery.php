<?php

declare(strict_types=1);

namespace Esgi\Brewery\Model;

use Esgi\Brewery\Api\Data\BreweryInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Esgi\Brewery\Model\ResourceModel\Brewery as BreweryResourceModel;
use Esgi\Brewery\Model\ResourceModel\Brewery\Product\CollectionFactory;

class Brewery extends AbstractModel implements BreweryInterface, IdentityInterface
{
    /**
     * Esgi Brewery brewery cache tag
     */
    const CACHE_TAG = 'esgi_brewery_b';

    /**#@-*/
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'esgi_brewery';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'brewery';

    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @var CollectionFactory $_breweryProductsCollectionFactory
     */
    protected $_breweryProductsCollectionFactory;

    /**
     * Brewery constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param CollectionFactory $breweryProductsCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        CollectionFactory $breweryProductsCollectionFactory,
        array $data = []
    ) {
        $this->_breweryProductsCollectionFactory = $breweryProductsCollectionFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(BreweryResourceModel::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Retrieve brewery id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Retrieve brewery name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Retrieve brewery slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->getData(self::SLUG);
    }

    /**
     * Retrieve brewery content
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return BreweryInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Set name
     *
     * @param string $title
     * @return BreweryInterface
     */
    public function setName($title)
    {
        return $this->setData(self::NAME, $title);
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return BreweryInterface
     */
    public function setSlug($slug)
    {
        return $this->setData(self::SLUG, $slug);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return BreweryInterface
     */
    public function setDescription($content)
    {
        return $this->setData(self::DESCRIPTION, $content);
    }

    /**
     * @return BreweryResourceModel\Product\Collection
     */
    public function getProducts()
    {
        /** @var BreweryResourceModel\Product\Collection $collection */
        $collection = $this->_breweryProductsCollectionFactory->create();
        $collection->addBreweryFilter($this);
        $collection->addFieldToSelect('name');
        $collection->addFieldToSelect('description');
        $collection->addFieldToSelect('price');
        $collection->addFieldToSelect('image');

        return $collection;
    }
}
