<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Esgi\Job\Model;

use Esgi\Job\Api\DepartmentRepositoryInterface;
use Esgi\Job\Api\Data;
use Esgi\Job\Model\ResourceModel\Department as DepartmentResource;
use Esgi\Job\Model\DepartmentFactory;
use Esgi\Job\Model\ResourceModel\Department\CollectionFactory as DepartmentCollectionFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class BlockRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class DepartmentRepository implements DepartmentRepositoryInterface
{
    /**
     * @var DepartmentResource
     */
    protected $resource;

    /**
     * @var DepartmentFactory
     */
    protected $departmentFactory;

    /**
     * @var DepartmentCollectionFactory
     */
    protected $departmentCollectionFactory;

    /**
     * @var Data\DepartmentSearchResultsInterface
     */
    protected $searchResultsFactory;

    /**
     * @param DepartmentResource $resource
     * @param DepartmentFactory $departmentFactory
     * @param DepartmentCollectionFactory $departmentCollectionFactory
     * @param Data\DepartmentSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        DepartmentResource $resource,
        DepartmentFactory $departmentFactory,
        \Esgi\Job\Api\Data\DepartmentInterfaceFactory $dataDepartmentFactory,
        DepartmentCollectionFactory $departmentCollectionFactory,
        Data\DepartmentSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->departmentFactory = $departmentFactory;
        $this->departmentCollectionFactory = $departmentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Save Department data
     *
     * @param \Esgi\Job\Api\Data\DepartmentInterface $department
     * @return Department
     * @throws CouldNotSaveException
     */
    public function save(Data\DepartmentInterface $department)
    {
        try {
            $this->resource->save($department);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $department;
    }

    /**
     * Load Department data by given Department Identity
     *
     * @param string $departmentId
     * @return Department
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($departmentId)
    {
        $department = $this->departmentFactory->create();
        $this->resource->load($department, $departmentId);
        if (!$department->getId()) {
            throw new NoSuchEntityException(__('Department with id "%1" does not exist.', $department));
        }

        return $department;
    }

    /**
     * Load Department data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Esgi\Job\Api\Data\DepartmentSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Esgi\Job\Model\ResourceModel\Department\Collection $collection */
        $collection = $this->departmentCollectionFactory->create();

        /** @var Data\DepartmentSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete Department
     *
     * @param \Esgi\Job\Api\Data\DepartmentInterface $department
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\DepartmentInterface $department)
    {
        try {
            $this->resource->delete($department);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete Department by given Department Identity
     *
     * @param string $departmentId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($departmentId)
    {
        return $this->delete($this->getById($departmentId));
    }
}
