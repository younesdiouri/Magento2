<?php

declare(strict_types=1);

namespace Esgi\Brewery\Model\Brewery;

use Esgi\Brewery\Api\Data\Brewery\ProductInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Esgi\Brewery\Model\ResourceModel\Brewery\Product as BreweryProductResourceModel;

class Product extends AbstractModel implements ProductInterface, IdentityInterface
{
    /**
     * Esgi Brewery brewery cache tag
     */
    const CACHE_TAG = 'esgi_brewery_p';

    /**#@-*/
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'esgi_brewery_product';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'brewery_product';

    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(BreweryProductResourceModel::class);
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
     * Set ID
     *
     * @param int $id
     * @return ProductInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }
}
