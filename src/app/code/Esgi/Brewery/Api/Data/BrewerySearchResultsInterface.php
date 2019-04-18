<?php

declare(strict_types=1);

namespace Esgi\Brewery\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for brewery brewery search results.
 * @api
 */
interface BrewerySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get breweries list.
     *
     * @return \Esgi\Brewery\Api\Data\BreweryInterface[]
     */
    public function getItems();

    /**
     * Set breweries list.
     *
     * @param \Esgi\Brewery\Api\Data\BreweryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
