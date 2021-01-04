;(function() {
    'use strict';
    window.addEventListener('load', function() {
        document.getElementById('existing').click();
        showExisting();
        document.getElementById('new').addEventListener('click', newEvent);
        document.getElementById('existing').addEventListener('click', showExisting);
    })
})();

function showExisting() {
    document.getElementById('newEvent').style.display = "none";
    document.getElementById('existingEvent').style.display = "block";
    document.getElementById('typeEvent').value = 'existing';
}

function newEvent() {
    document.getElementById('newEvent').style.display = "block";
    document.getElementById('existingEvent').style.display = "none";
    document.getElementById('typeEvent').value = 'new';
}

let selectedEvent;

function changeSelected(id) {
    if(selectedEvent){
        document.getElementById(selectedEvent).checked = false;
    }
    selectedEvent = id;
    updateIdValue(selectedEvent);
}

function updateIdValue(id){
    document.getElementById('exEventId').value = id;
    console.log(document.getElementById('exEventId').value);
}

