<?php

namespace Esgi\Brewery\Block\Brewery;

use Esgi\Brewery\Model\ResourceModel\Brewery\Entity;
use Esgi\Brewery\Api\BreweryRepositoryInterface;
use Magento\Catalog\Block\Product\AbstractProduct;

/**
 * Class View
 * @package Esgi\Brewery\Block\Brewery
 */
class View extends AbstractProduct
{
    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    protected $request;
    /**
     * @var BreweryRepositoryInterface $breweryRepository
     */
    protected $breweryRepository;

    /**
     * View constructor.
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\App\RequestInterface $request
     * @param BreweryRepositoryInterface $breweryRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\App\RequestInterface $request,
        BreweryRepositoryInterface $breweryRepository ,
        array $data = []
    ) {
        $this->request = $request;
        $this->breweryRepository = $breweryRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getBrewery()
    {
        /** @var string $slug */
        $slug = $this->request->getParam('name');
        $brewery = $this->breweryRepository->getBySlug($slug);

        return $brewery;
    }
}
