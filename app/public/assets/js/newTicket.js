;(function() {
    'use strict';
    window.addEventListener('load', function() {

        document.getElementById('new').addEventListener('click', newEvent);
        document.getElementById('existing').addEventListener('click', showExisting);
    })
})();

function showExisting() {
    document.getElementById('newEvent').style.display = "none";
    document.getElementById('existingEvent').style.display = "block";

}

function newEvent() {
    document.getElementById('newEvent').style.display = "block";
    document.getElementById('existingEvent').style.display = "none";

}
