<?php

namespace Esgi\Job\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Esgi\Job\Model\ResourceModel\Department\Collection;
use Esgi\Job\Model\ResourceModel\Department\CollectionFactory;

/**
 * Options provider for countries list
 *
 * @api
 * @since 100.0.2
 */
class Department implements ArrayInterface
{
    /**
     * Countries
     *
     * @var CollectionFactory $departmentCollectionFactory
     */
    protected $departmentCollectionFactory;

    /**
     * Options array
     *
     * @var array
     */
    protected $options;

    /**
     * Department constructor
     *
     * @param CollectionFactory $departmentCollectionFactory
     */
    public function __construct(
        CollectionFactory $departmentCollectionFactory
    ) {
        $this->departmentCollectionFactory = $departmentCollectionFactory;
    }

    /**
     * Return options array
     *
     * @param boolean $isMultiselect
     * @param string|array $foregroundCountries
     * @return array
     */
    public function toOptionArray($isMultiselect = false): array
    {
        if (!$this->options) {
            /** @var Collection $collection */
            $collection = $this->departmentCollectionFactory->create();
            $this->options = $collection->toOptionArray();
        }

        $options = $this->options;
        if (!$isMultiselect) {
            array_unshift($options, ['value' => '', 'label' => __('--Please Select--')]);
        }

        return $options;
    }
}
