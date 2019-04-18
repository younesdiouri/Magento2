<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Esgi\Brewery\Model;

use Esgi\Brewery\Api\BreweryRepositoryInterface;
use Esgi\Brewery\Api\Data;
use Esgi\Brewery\Model\ResourceModel\Brewery as BreweryResource;
use Esgi\Brewery\Model\BreweryFactory;
use Esgi\Brewery\Model\ResourceModel\Brewery\CollectionFactory as BreweryCollectionFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class BlockRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BreweryRepository implements BreweryRepositoryInterface
{
    /**
     * @var BreweryResource
     */
    protected $resource;

    /**
     * @var BreweryFactory
     */
    protected $breweryFactory;

    /**
     * @var BreweryCollectionFactory
     */
    protected $breweryCollectionFactory;

    /**
     * @var Data\BrewerySearchResultsInterface
     */
    protected $searchResultsFactory;

    /**
     * @param BreweryResource $resource
     * @param BreweryFactory $breweryFactory
     * @param BreweryCollectionFactory $breweryCollectionFactory
     * @param Data\BrewerySearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        BreweryResource $resource,
        BreweryFactory $breweryFactory,
        \Esgi\Brewery\Api\Data\BreweryInterfaceFactory $dataBreweryFactory,
        BreweryCollectionFactory $breweryCollectionFactory,
        Data\BrewerySearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->breweryFactory = $breweryFactory;
        $this->breweryCollectionFactory = $breweryCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Save Brewery data
     *
     * @param \Esgi\Brewery\Api\Data\BreweryInterface $brewery
     * @return Brewery
     * @throws CouldNotSaveException
     */
    public function save(Data\BreweryInterface $brewery)
    {
        try {
            $this->resource->save($brewery);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $brewery;
    }

    /**
     * Load Brewery data by given Brewery Identity
     *
     * @param string $breweryId
     * @return Brewery
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($breweryId)
    {
        $brewery = $this->breweryFactory->create();
        $this->resource->load($brewery, $breweryId);
        if (!$brewery->getId()) {
            throw new NoSuchEntityException(__('Brewery with id "%1" does not exist.', $brewery));
        }

        return $brewery;
    }

    /**
     * @param $slug
     * @return Brewery
     * @throws NoSuchEntityException
     */
    public function getBySlug($slug)
    {
        $brewery = $this->breweryFactory->create();
        $this->resource->load($brewery, $slug, 'slug');
        if (!$brewery->getId()) {
            throw new NoSuchEntityException(__('Brewery with slug "%1" does not exist.', $slug));
        }

        return $brewery;
    }

    /**
     * Load Brewery data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Esgi\Brewery\Api\Data\BrewerySearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Esgi\Brewery\Model\ResourceModel\Brewery\Collection $collection */
        $collection = $this->breweryCollectionFactory->create();

        /** @var Data\BrewerySearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete Brewery
     *
     * @param \Esgi\Brewery\Api\Data\BreweryInterface $brewery
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\BreweryInterface $brewery)
    {
        try {
            $this->resource->delete($brewery);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete Brewery by given Brewery Identity
     *
     * @param string $breweryId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($breweryId)
    {
        return $this->delete($this->getById($breweryId));
    }
}
