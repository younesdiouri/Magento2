<?php

declare(strict_types=1);

namespace Esgi\Brewery\Api\Data;

/**
 * Esgi brewery interface.
 * @api
 */
interface BreweryInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID      = 'entity_id';
    const NAME    = 'name';
    const SLUG    = 'slug';
    const DESCRIPTION = 'description';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Get slug
     *
     * @return string|null
     */
    public function getSlug();

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Get brewery related products
     *
     * @return \Esgi\Brewery\Model\ResourceModel\Brewery\Product\Collection
     */
    public function getProducts();

    /**
     * Set ID
     *
     * @param int $id
     * @return BreweryInterface
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param string $title
     * @return BreweryInterface
     */
    public function setName($title);

    /**
     * Set slug
     *
     * @param string $slug
     * @return BreweryInterface
     */
    public function setSlug($slug);

    /**
     * Set content
     *
     * @param string $content
     * @return BreweryInterface
     */
    public function setDescription($content);
}
