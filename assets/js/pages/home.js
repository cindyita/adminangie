$(function () {

    sendAjax({ id: 1 }, 'GET').then(
        function (res) {    
            data = JSON.parse(res);
            data = data[0]['name'];
            $("#info").html(data);
        }).catch(function(error) {
            console.error(error);
        });

});
