<?php

declare(strict_types=1);

namespace Esgi\Brewery\Api\Data\Brewery;

/**
 * Esgi brewery interface.
 * @api
 */
interface ProductInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'entity_id';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     * @return ProductInterface
     */
    public function setId($id);
}
