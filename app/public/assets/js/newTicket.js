;(function() {
    'use strict';
    window.addEventListener('load', function() {
        document.getElementById('existing').click();
        document.getElementById('new').addEventListener('click', newEvent);
        document.getElementById('existing').addEventListener('click', showExisting);

        document.getElementById('ticketDetailsEx').addEventListener('click', showTicketDetailsFormEx);
        document.getElementById('ticketDetailsNw').addEventListener('click', showTicketDetailsFormNw);
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

function showTicketDetailsFormEx(e){
    e.preventDefault();
    console.log('idfjgghgir');
    document.getElementById('eventSelection').style.display = "none";
    document.getElementById('ticketDetails').style.display = "block";
}

function showTicketDetailsFormNw(e){
    e.preventDefault();
    console.log('odfjghrjyhtofjehtrjr');
}
