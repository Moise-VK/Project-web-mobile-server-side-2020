;(function() {
    'use strict';
    window.addEventListener('load', function() {
        document.getElementById('price').addEventListener('change', updateValue);
    });
})();

function updateValue(){
    document.getElementById('priceInd').innerHTML = "€ " + document.getElementById('price').value;
}

function addToCart(id) {
    let cart = localStorage.getItem('shopping_cart');
    if(cart == null){
        cart = [];
    } else {
        cart = JSON.parse(cart);
    }
    cart = checkIfIdInCart(cart, id);
    localStorage.setItem('shopping_cart', JSON.stringify(cart));
    console.log(cart);
}

function checkIfIdInCart(cart, id) {
    if(!cart.includes(id)){
        cart.push(id);
    }
    updateCart();
    return cart;
}

function updateCart() {

}

function sendFormToAPI(route, data) {
    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(json => checkResponse(json))
        .catch(function (error) {
            console.log(error);
        });
}
