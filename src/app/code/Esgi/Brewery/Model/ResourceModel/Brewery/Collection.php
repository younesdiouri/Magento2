<?php

declare(strict_types=1);

namespace Esgi\Brewery\Model\ResourceModel\Brewery;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Esgi\Brewery\Model\Brewery', 'Esgi\Brewery\Model\ResourceModel\Brewery');
    }
}
