<?php
// app/code/Esgi/Brewery/Block/Brewery/List.php
namespace Esgi\Brewery\Block\Brewery;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Esgi\Brewery\Model\ResourceModel\Brewery\Collection;
use Esgi\Brewery\Model\ResourceModel\Brewery\CollectionFactory;

/**
 * List block
 */
class ListBrewery extends \Magento\Framework\View\Element\Template
{
    protected $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory,
        Context $context,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    public function getBreweries()
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        return $collection->getItems();
    }
}
