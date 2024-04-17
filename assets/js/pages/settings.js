$(function () {
    
    $("#saveSettings").on("click", function (event) {
        event.preventDefault();
        var formData = new FormData($("#saveSettingsForm")[0]);

        if ($("#img_logo")[0].files[0]) {
            var file = $("#img_logo")[0].files[0];
            formData.append('file', file);
        }

        if ($("#img_favicon")[0].files[0]) {
            var file = $("#img_favicon")[0].files[0];
            formData.append('file', file);
        }

        if ($("#img_font")[0].files[0]) {
            var file = $("#img_font")[0].files[0];
            formData.append('file', file);
        }

        sendAjaxForm(formData, 'SAVE').then(
            function (res) { 
                if (processError(res)) {
                    message("Has guardado los cambios correctamente. Actualizando..", "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2500);
                }
            }).catch(function (error) {
                message("Algo salió mal", "error");
                console.error(error);
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    $("#db_type").on("change", function () {
        $("#db_type").prop('disabled', true);
        sendAjax({}, 'CHANGE_DBTYPE').then(
            function (res) {    
            console.log(res);
            if (processError(res)) {
                message("Se ha actualizado la conexión", "success");
                $("#db_type").prop('disabled', false);
            }
        }).catch(function(error) {
            console.error(error);
        });
    });

});

$("#img_logo").on('change', function() {
    var file = this.files[0];
    var limit = 10;
    var maxSize = limit * 1024 * 1024;

      if (file.size > maxSize) {
          message('El archivo excede el tamaño máximo permitido (' + limit + 'MB)', "error");
          $(this).val('');
      }
});
 
$("#img_favicon").on('change', function() {
    var file = this.files[0];
    var limit = 10;
    var maxSize = limit * 1024 * 1024;

      if (file.size > maxSize) {
          message('El archivo excede el tamaño máximo permitido (' + limit + 'MB)', "error");
          $(this).val('');
      }
});

$("#img_font").on('change', function() {
    var file = this.files[0];
    var limit = 10;
    var maxSize = limit * 1024 * 1024;

      if (file.size > maxSize) {
          message('El archivo excede el tamaño máximo permitido (' + limit + 'MB)', "error");
          $(this).val('');
      }
});