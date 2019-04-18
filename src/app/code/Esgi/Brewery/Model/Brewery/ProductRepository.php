<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Esgi\Brewery\Model\Brewery;

use Esgi\Brewery\Api\Brewery\ProductRepositoryInterface;
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
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var BreweryResource
     */
    protected $resource;

    /**
     * @var BreweryFactory
     */
    protected $breweryProductFactory;

    /**
     * @var BreweryCollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @param BreweryResource $resource
     * @param BreweryFactory $breweryProductFactory
     * @param BreweryCollectionFactory $productCollectionFactory
     */
    public function __construct(
        BreweryResource $resource,
        BreweryFactory $breweryProductFactory,
        BreweryCollectionFactory $productCollectionFactory
    ) {
        $this->resource = $resource;
        $this->breweryProductFactory = $breweryProductFactory;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * Save Brewery data
     *
     * @param Data\Brewery\ProductInterface $breweryProduct
     * @return Data\Brewery\ProductInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\Brewery\ProductInterface $breweryProduct)
    {
        try {
            $this->resource->save($breweryProduct);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $breweryProduct;
    }

    /**
     * Load Brewery data by given Brewery Identity
     *
     * @param string $breweryProductId
     * @return Product
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($breweryProductId)
    {
        $breweryProduct = $this->breweryProductFactory->create();
        $this->resource->load($breweryProduct, $breweryProductId);
        if (!$breweryProduct->getId()) {
            throw new NoSuchEntityException(__('Brewery with id "%1" does not exist.', $breweryProduct));
        }

        return $breweryProduct;
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
        $collection = $this->productCollectionFactory->create();

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
     * @param Data\Brewery\ProductInterface $breweryProduct
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\Brewery\ProductInterface $breweryProduct)
    {
        try {
            $this->resource->delete($breweryProduct);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete Brewery by given Brewery Identity
     *
     * @param string $breweryProductId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($breweryProductId)
    {
        return $this->delete($this->getById($breweryProductId));
    }
}
