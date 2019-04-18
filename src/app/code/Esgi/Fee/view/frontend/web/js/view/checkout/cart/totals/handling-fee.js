define(
    [
        'Esgi_Fee/js/view/checkout/summary/handling-fee'
    ],
    function (Component) {
        'use strict';
        return Component.extend({
            /**
             * @override
             */
            isDisplayed: function () {
                return true;
            }
        });
    }
);