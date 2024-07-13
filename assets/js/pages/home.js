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

    var calendarElement = document.getElementById('calendarHome');
    var calendar = new FullCalendar.Calendar(calendarElement, {
        initialView: 'dayGridMonth',
        locale: 'es',
        timeZone: 'UTC-7',
        customButtons: {
            myCustomButton: {
            text: 'Crear evento',
            click: function() {
                
            }
            }
        },
        headerToolbar: {
            left: 'prev,next today myCustomButton',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: [
            {
                id: 'a1',
                title: 'Pedido prueba',
                start: '2024-07-01',
                end: '2024-07-05',
                // startRecur:,
                // endRecur:,
                // daysOfWeek:
                // startTime:'02:00',
                // endTime:'04:00',
                backgroundColor: 'var(--secondary)',
                borderColor: 'var(--secondary)',
                textColor: 'white',
            // url:'home'
            }
        ]
    });
    calendar.render();

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
        var formData = new FormData($(this)[0]);
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
    
});
