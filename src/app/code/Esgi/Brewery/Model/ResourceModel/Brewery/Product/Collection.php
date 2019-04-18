<?php

declare(strict_types=1);

namespace Esgi\Brewery\Model\ResourceModel\Brewery\Product;

use Esgi\Brewery\Model\Brewery;
use Magento\Catalog\Ui\DataProvider\Product\ProductCollection;

/**
 * Class Collection
 * @package Esgi\Brewery\Model\ResourceModel\Brewery\Product
 */
class Collection extends ProductCollection
{
    /**
     * @param Brewery $brewery
     */
    public function addBreweryFilter(Brewery $brewery)
    {
        $this->getSelect()->join(
            ['brewery_product' => 'esgi_brewery_brewery_product'],
            'e' . '.entity_id=brewery_product.product_id',
            ['brewery_id' => 'brewery_product.brewery_id']
        );

        $this->getSelect()->where("brewery_id=". $brewery->getId());
    }
}
