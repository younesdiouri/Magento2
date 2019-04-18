<?php

declare(strict_types=1);

namespace Esgi\Job\Model\ResourceModel\Job;

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
        $this->_init('Esgi\Job\Model\Job', 'Esgi\Job\Model\ResourceModel\Job');
    }
}
