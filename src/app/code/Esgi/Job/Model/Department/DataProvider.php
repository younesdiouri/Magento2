<?php

namespace Esgi\Job\Model\Department;

use Esgi\Job\Model\ResourceModel\Department\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Esgi\Job\Model\ResourceModel\Department\Collection
     */
    protected $collection;
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string                 $name
     * @param string                 $primaryFieldName
     * @param string                 $requestFieldName
     * @param CollectionFactory      $departmentCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array                  $meta
     * @param array                  $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $departmentCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection    = $departmentCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Esgi\Job\Model\Department $department */
        foreach ($items as $department) {
            $this->loadedData[$department->getId()] = $department->getData();
        }

        $data = $this->dataPersistor->get('job_department');

        if (!empty($data)) {
            $department = $this->collection->getNewEmptyItem();
            $department->setData($data);
            $this->loadedData[$department->getId()] = $department->getData();
            $this->dataPersistor->clear('job_department');
        }

        return $this->loadedData;
    }
}
