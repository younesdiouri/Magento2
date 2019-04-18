<?php

declare(strict_types=1);

namespace Esgi\Brewery\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Catalog\Model\Product\Url;

class Brewery extends AbstractDb
{
    /**
     * @var Url $_urlModel
     */
    protected $_urlModel;

    /**
     * Brewery constructor.
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param Url $urlModel
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        Url $urlModel
    ) {
        $this->_urlModel = $urlModel;
        parent::__construct($context);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        // Table Name and Primary Key column
        $this->_init('esgi_brewery_brewery', 'entity_id');
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $brewery
     * @return AbstractDb|void
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $brewery)
    {
        /** @var string $slug */
        $slug = $brewery->getName();
        $brewery->setSlug($this->formatUrlKey($slug));
    }

    /**
     * Formats URL key
     *
     * @param string $str URL
     * @return string
     */
    protected function formatUrlKey($str)
    {
        return $this->_urlModel->formatUrlKey($str);
    }
}
