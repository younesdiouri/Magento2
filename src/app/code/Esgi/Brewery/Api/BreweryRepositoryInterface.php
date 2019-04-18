<?php

declare(strict_types=1);

namespace Esgi\Brewery\Api;

/**
 * Esgi brewery CRUD interface.
 * @api
 */
interface BreweryRepositoryInterface
{
    /**
     * Save block.
     *
     * @param \Esgi\Brewery\Api\Data\BreweryInterface $brewery
     * @return \Esgi\Brewery\Api\Data\BreweryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\BreweryInterface $brewery);

    /**
     * Retrieve $brewery.
     *
     * @param int $breweryId
     * @return \Esgi\Brewery\Api\Data\BreweryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($breweryId);

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
     * @param \Esgi\Brewery\Api\Data\BreweryInterface $brewery
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\BreweryInterface $brewery);

    /**
     * Delete brewery by ID.
     *
     * @param int $breweryId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($breweryId);
}
