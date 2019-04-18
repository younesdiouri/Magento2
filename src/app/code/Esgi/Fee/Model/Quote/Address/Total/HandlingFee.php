<?php
namespace Esgi\Fee\Model\Quote\Address\Total;

use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;

/**
 * Class HandlingFee
 * @package Esgi\Fee\Model\Quote\Address\Total
 */
class HandlingFee extends AbstractTotal
{
    /**
     * @var PriceCurrencyInterface $priceCurrencyInterface
     */
    protected $priceCurrencyInterface;

    /**
     * HandlingFee constructor.
     * @param PriceCurrencyInterface $priceCurrencyInterface
     */
    public function __construct(
        PriceCurrencyInterface $priceCurrencyInterface
    ) {
        $this->priceCurrencyInterface = $priceCurrencyInterface;
    }

    /**
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total $total
     * @return HandlingFee
     */
    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ): HandlingFee {
        parent::collect($quote, $shippingAssignment, $total);

        $handlingFee = 10;
        $total->addTotalAmount('handlingfee', $handlingFee);
        $total->addBaseTotalAmount('handlingfee', $handlingFee);
        $quote->setHandlingFee($handlingFee);

        return $this;
    }

    /**
     * @param Quote $quote
     * @param Total $total
     * @return array
     */
    public function fetch(
        Quote $quote,
        Total $total
    ): array {
        return [
            'code' => 'Handling_Fee',
            'title' => $this->getLabel(),
            'value' => 10
        ];
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return __('Handling Fee');
    }
}
