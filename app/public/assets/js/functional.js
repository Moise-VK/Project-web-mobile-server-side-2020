;(function() {
    'use strict';
    window.addEventListener('load', function() {
        document.getElementById('price').addEventListener('change', updateValue);
    });
})();

function updateValue(){
    document.getElementById('priceInd').innerHTML = "€ " + document.getElementById('price').value;
}
