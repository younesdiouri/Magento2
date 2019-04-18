<?php

declare(strict_types=1);

namespace Esgi\Brewery\Model\ResourceModel\Brewery;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Product
 * @package Esgi\Brewery\Model\ResourceModel\Brewery
 */
class Product extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('esgi_brewery_brewery_product', 'entity_id');
    }
}
