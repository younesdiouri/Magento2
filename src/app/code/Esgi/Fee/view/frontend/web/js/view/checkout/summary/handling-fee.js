define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals',
        'Magento_Catalog/js/price-utils'
    ],
    function ($,Component,quote,totals,priceUtils) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Esgi_Fee/checkout/summary/handling-fee'
            },
            totals: quote.getTotals(),
            isDisplayedHandlingfeeTotal : function () {
                return true;
            },
            getHandlingfeeTotal : function () {
                var price = 10;
                return this.getFormattedPrice(price);
            }
        });
    }
);