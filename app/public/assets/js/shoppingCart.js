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

function deleteFromCart(id) {
    cart = checkCart();
    cart = checkIfIdInCart(cart, id, 'rem');
}

function checkCart() {
    let cart = localStorage.getItem('shopping_cart');
    if(cart === null || cart === ''){
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

function removeItemFromArray(cart, id) {
    for(let i = 0; i < cart.length; i++) {
        if(cart[i] === id) {
            console.log('Ik verwijder nu id: ' + id);
            cart.splice(i, 1);
        }
    }
    return cart;
}

function updateCart (cart, cartLength) {
    document.getElementById('shoppingCartTotal').innerHTML = '(' + cartLength + ')';
    document.getElementById('cartTickets').value = cart;
}

function removeTicketFromCart(ticketID) {
    if(confirm('Bent u zeker?') == true) {
        document.getElementById(ticketID).remove();
        cart = removeItemFromArray(checkCart(), ticketID);
        localStorage.setItem('shopping_cart', JSON.stringify(cart));
        updateCart(cart, cart.length);
        document.getElementById('cartButton').click();
    }
}

function emptyCart() {
    let cart = localStorage.getItem('shopping_cart');
    cart = '';
    localStorage.setItem('shopping_cart', cart);
    updateCart(cart, 0);
}
