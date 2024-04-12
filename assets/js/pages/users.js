$(function () {
    sendAjax({}, 'GET').then(
        function (res) {    
            console.log(res);
            data = JSON.parse(res);
            $("#onTable").html(data);
            initTable();
        }).catch(function(error) {
            console.error(error);
        });
});
