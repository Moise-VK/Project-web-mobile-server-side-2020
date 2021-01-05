;(function() {
    'use strict';
    window.addEventListener('load', function() {
        checkCart();
    });
})();

function addToCart(id) {
    cart = checkCart();
    cart = checkIfIdInCart(cart, id);
    localStorage.setItem('shopping_cart', JSON.stringify(cart));
    updateCart(cart, cart.length);
}

function checkCart() {
    let cart = localStorage.getItem('shopping_cart');
    if(cart == null){
        cart = [];
    } else {
        cart = JSON.parse(cart);
    }
    updateCart(cart, cart.length);
    return cart;
}

function checkIfIdInCart(cart, id) {
    if(!cart.includes(id)){
        cart.push(id);
    }
    return cart;
}

function updateCart (cart, cartLength) {
    document.getElementById('shoppingCartTotal').innerHTML = '(' + cartLength + ')';
    document.getElementById('cartTickets').value = cart;
}
