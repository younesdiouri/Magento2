<?php
// app/code/Esgi/Job/Block/Department.php
namespace Esgi\Job\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Esgi\Job\Model\ResourceModel\Department\Collection;
use Esgi\Job\Model\ResourceModel\Department\CollectionFactory;

/**
 * Department block
 */
class Department extends Template
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

    public function getDepartments()
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        return $collection->getItems();
    }
}
