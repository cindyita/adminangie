let dataEvents = [];
$(function () {

    $.ajax({
        url: 'https://api.quotable.io/random',
        success: function(data) {
            $('#random-quote').html(`${data.content} — ${data.author}`);
        },
        error: function() {
            $('#random-quote').html('Bienvenid@');
        }
    });
    
    sendAjax({}, 'GETEVENTS').then(
        function (res) {
            dataEvents = JSON.parse(res);
            loadCalendar('calendarHome',dataEvents);
    }).catch(function(error) {
        console.error(error);
    });


    sendAjax({}, 'GETNOTE').then(
        function (res) { 
                    res = JSON.parse(res);
                    $("#notes").val(res['notes']);
                    $("#loadNotes").hide();
                }).catch(function(error) {
                    console.error(error);
            });

    $("#homeNotes").on("submit", async function (event) {
        event.preventDefault();
        let formData = new FormData($(this)[0]);
        sendAjaxForm(formData, 'SAVENOTE').then(
            function (res) {
                if (processError(res)) {
                    message("Se ha guardado la nota", "success");
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });

    $("#addEventForm").on("submit", async function (event) {
        event.preventDefault();
        let formData = new FormData($("#addEventForm")[0]);
        sendAjaxForm(formData, 'CREATEEVENT').then(
            function (res) {
                console.log(res);
                if (processError(res)) {
                    message("El evento fue creado correctamente", "success");
                    $("#addEventForm")[0].reset();
                    // loadCalendar('calendarHome',dataEvents);
                    window.location.reload();
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
            });
    });
    
});

function loadCalendar(idCalendar,dataEvents) {
    $("#loadEvents").show();
    $("#" + idCalendar).empty();
    let calendarElement = document.getElementById(idCalendar);
    let calendar = new FullCalendar.Calendar(calendarElement, {
        initialView: 'dayGridMonth',
        locale: 'es',
        timeZone: 'UTC-7',
        customButtons: {
            myCustomButton: {
            text: 'Crear evento',
                click:
                    function () {
                        showModal('addEvent');
                    }
            }
        },
        headerToolbar: {
            left: 'prev,next today myCustomButton',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: dataEvents
    });
    calendar.render();
    $("#loadEvents").hide();
}