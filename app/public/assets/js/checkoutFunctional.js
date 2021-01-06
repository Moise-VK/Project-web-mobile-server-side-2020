;(function() {
    'use strict';
    window.addEventListener('load', function() {
        let doc = document.getElementById('finalShoppingCart');
        doc.value = JSON.parse(localStorage.getItem('shopping_cart'));
    });
})();



