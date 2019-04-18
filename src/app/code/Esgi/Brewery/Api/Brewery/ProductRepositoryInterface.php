<?php

declare(strict_types=1);

namespace Esgi\Brewery\Api\Brewery;

use Esgi\Brewery\Api\Data as Data;

/**
 * Esgi brewery CRUD interface.
 * @api
 */
interface ProductRepositoryInterface
{
    /**
     * Save block.
     *
     * @param \Esgi\Brewery\Api\Data\Brewery\ProductInterface $breweryProduct
     * @return \Esgi\Brewery\Api\Data\Brewery\ProductInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\Brewery\ProductInterface $breweryProduct);

    /**
     * Retrieve $breweryProduct.
     *
     * @param int $breweryProductId
     * @return \Esgi\Brewery\Api\Data\Brewery\ProductInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($breweryProductId);

    /**
     * Retrieve brewerys matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Esgi\Brewery\Api\Data\BrewerySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete brewery.
     *
     * @param \Esgi\Brewery\Api\Data\Brewery\ProductInterface $breweryProduct
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\Brewery\ProductInterface $breweryProduct);

    /**
     * Delete brewery by ID.
     *
     * @param int $breweryProductId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($breweryProductId);
}
