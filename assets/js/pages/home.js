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
});
