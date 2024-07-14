const ACTUALPAGE = actualPage();
const CONTROLLER = pageController();


$(function () {

  $('.page-container').addClass('sbar_collapsed');

  $(".page-overlay").fadeOut();

  initTable();

  disableLinks();

});

/**
 * The function "message" displays a message on the webpage with a specified text and type, fading it
 * out after 4 seconds.
 * @param text - The `text` parameter is the message content that you want to display in the message
 * box. It can be any text or information that you want to communicate to the user.
 * @param [type=info] - The `type` parameter in the `message` function is used to specify the type of
 * message being displayed. By default, the type is set to "info", but it can be overridden with a
 * different type such as "success", "warning", or "error" depending on the message being displayed
 */
var typesAlert = { "error": "alert-danger", "info": "alert-info", "success": "alert-success", "warning": "alert-warning" };
var typesAlertText = { "error": "Error", "info": "Info", "success": "Éxito", "warning": "Aviso" };

function message(text, type = "info") {
  var html = '<div class="message"><div class="alert alert-dismissible '+typesAlert[type]+'"><button type="button" data-bs-dismiss="alert" class="close"><i class="fa-solid fa-xmark"></i></button><strong>'+typesAlertText[type]+':</strong> '+text+'</div></div>';
  var $message = $(html);
  $message.hide().prependTo('body').fadeIn();
  setTimeout(function() {
      $message.fadeOut(function() {
          $(this).remove();
      });
  }, 6500);
}

/**
 * The function `processError` takes a response code as input and handles different error cases based
 * on the code.
 * @param res - The `res` parameter in the `processError` function is expected to be a number that
 * represents an error code.
 * @returns The function `processError` will return either `true` if the `res` value is 1, or `false`
 * if the `res` value is other value.
 */
function processError(res) {
  res = +res;
  switch (res) {
    case 1:
      return true;
    case 2:
      message("El email o la contraseña son incorrectas", "error");
      console.log("Error 2: El email o la contraseña son incorrectas");
      return false;
    case 3:
      message("El usuario está desactivado", "error");
      console.log("Error 3: El usuario está desactivado");
      return false;
    case 4:
      message("Error en el token de acceso", "error");
      console.log("Error 4: Error en el token de acceso");
      return false;
    case 5:
      message("La clave de registro es incorrecta", "error");
      console.log("Error 5: La clave de registro es incorrecta");
      return false;
    case 6:
      message("No se permite ese tipo de archivo", "error");
      console.log("Error 6: No se permite ese tipo de archivo");
      return false;
    case 7:
      message("No se pudo actualizar", "error");
      console.log("Error 7: No se pudo actualizar");
      return false;
    case 8:
      message("No tienes los permisos para esta acción", "error");
      console.log("Error 8: No tienes los permisos para esta acción");
    return false;
    default:
      message("Error desconocido", "error");
      console.log("Error: "+res);
      return false;
  }
}

/**
 * The function `resSuccess` checks if the response is empty, a single value, a string, not set, or
 * does not contain a curly brace.
 * @param res - The `res` parameter seems to be a response object that is expected to be in JSON
 * format. The function `resSuccess` attempts to parse the `res` object as JSON and then checks if it
 * meets certain conditions to determine if the response is successful or not.
 * @returns The function `resSuccess` is checking if the input `res` is an empty array `[]`, the number
 * `1`, an empty string `""`, not set, or does not contain a curly brace `{`. If any of these
 * conditions are met, the function returns `true`, otherwise it returns `false`.
 */
function resSuccess(res){
  res = JSON.parse(res);
  if (res == [] || res == 1 || res == "" || !isset(res) || !res.infexOf("{") > -1) {
    return true;
  } else {
    return false;
  }
}

/**
 * The function `actualPage` extracts the name of the current page from the URL path.
 * @returns The function `actualPage()` returns the name of the current page without the file
 * extension.
 */
function actualPage() {
    var path = window.location.pathname;
    var pageName = path.split('/').pop().split('.').shift();
    return pageName;
}

/**
 * The function `pageController` returns the name of the controller file based on the current page's
 * URL path.
 * @returns homeController.php
 */
function pageController() {
    var path = window.location.pathname ? window.location.pathname : 'home.php';
    var pageName = path.split('/').pop().split('.').shift();
    pageName = pageName ? pageName : "home"
    var controllerName = pageName + "Controller.php";
    return controllerName;
}

/**
 * Performs an AJAX request using jQuery.ajax and returns a promise with the result.
 * @param {Object} data - The data to be sent in the AJAX request.
 * @param {string} action - The action to be performed in the server controller.
 * @returns {Promise} - A promise that resolves with the response data from the AJAX request or rejects with an error.
 */
function sendAjax(data, action) {
  return new Promise(function(resolve, reject) {
    $.ajax({
      url: './src/controllers/pages/' + CONTROLLER,
      type: 'POST',
      data: { data: data,'__view__':action },
      success: function(res) {
        resolve(res);
      },
      error: function(xhr) {
          console.error('Error en la solicitud. Código de estado: ' + xhr.status);
          message('Algo salió mal','error');
          reject('error');
      }
    });
  });
}

/**
 * The function sendAjaxForm sends an AJAX request to a specified URL with form data and returns a
 * promise that resolves with the response or rejects with an error message.
 * @param formData - The formData parameter is an object that contains the data to be sent in the AJAX
 * request. It can be in the form of a FormData object or a serialized string. This data will be sent
 * to the server-side script specified in the action parameter.
 * @param action - The "action" parameter is a string that represents the action to be performed by the
 * server-side code. It is typically used to determine which function or method to execute on the
 * server. In this case, it is appended to the URL as a query parameter in the AJAX request.
 * @returns a Promise object.
 */
function sendAjaxForm(formData, action) {
  formData.append("__view__", action);
  return new Promise(function(resolve, reject) {
      $.ajax({
          url: './src/controllers/pages/'+CONTROLLER,
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(res) {
              resolve(res);
          },
          error: function(xhr) {
              console.error('Error en la solicitud. Código de estado: ' + xhr.status);
              message('error', 'Algo salió mal');
              reject('error');
          }
      });
  });
}

/**
 * Validates whether the given URL is valid.
 *
 * @param {string} url - The URL to be validated.
 * @returns {boolean} - True if the URL is valid, false otherwise.
 */
function validarURL(url) {
  var regexURL = /^(ftp|http|https):\/\/[^ "]+$/;
  if (regexURL.test(url)) {
    return true;
  } else {
    return false;
  }
}

/**
 * Copies the specified text to the clipboard.
 * @param {string} text - The text to be copied.
 */
function copyToClipboard(text) {
  navigator.clipboard.writeText(text)
    .then(function() {
      message('Enlace copiado al portapapeles',"success");
    })
    .catch(function() {
      message('No se pudo copiar el enlace',"error");
    });
}

/**
 * The function `transposeData` takes in a modal ID and data object, and updates the corresponding
 * elements in the modal with the values from the data object.
 * @param modalid - The `modalid` parameter is a string that represents the ID of a modal element in
 * the HTML document. This ID is used to select and manipulate elements within the modal.
 * @param data - The `data` parameter is an object that contains key-value pairs. Each key represents
 * the ID of an element in the HTML document, and the corresponding value represents the data that
 * should be assigned to that element.
 */
function transposeData(modalid, data) {
    for (const key in data) {
        if (data.hasOwnProperty(key)) {
            const value = data[key];
            const element = $("#" + modalid + "-" + key);
            if (element.length > 0) {
                
                if (element.is("input") || element.is("select") || element.is("textarea") ) {
                    element.val(value);
                } else {
                    element.html(value);
                }
            }
            if (key == 'id' && $("#" + modalid + "-" + key + "Text").length > 0) {
                $("#"+modalid+"-"+key+"Text").html(value);
            }
        }
    }
}

function transposeDataEdit(data) {
    for (const key in data) {
        if (data.hasOwnProperty(key)) {
            const value = data[key];
            const element = $("#" + key + "Edit");
            if (element.length > 0) {
                
                if (element.is("input") || element.is("select") || element.is("textarea") ) {
                    element.val(value);
                } else {
                    element.html(value);
              }
          }
        }
    }
}

function initTable() {
  $('.table').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            {
                extend: 'colvis',
                text: '<i class="fas fa-columns"></i>',
                titleAttr: 'Visibilidad de Columnas'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: 'Exportar a Excel'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i>',
                titleAttr: 'Imprimir'
          },
            {
                text: '<a onclick="updateTable()"><i class="fa-solid fa-rotate"></i></a>',
                titleAttr: 'Actualizar tabla'
            }
        ],
        order: [[0, 'desc']],
        language: {
            url: './assets/required/dataTables/es-MX.json'
        }
    });
}
//Deshabilitar links con la clase link-disabled
function disableLinks() {
  $('.link-disabled').removeAttr('href');
}

function notJustNumbers(input) {
    var value = input.value;
    var regex = /^[0-9]+$/;
    if (regex.test(value)) {
        message("No puedes ingresar solo números en el campo.","error");
        input.value = "";
    }
}

function searchDataResultsOption(optionId, optionText, idInputText, idInputHidden, idSugDataResults) {
    console.log(optionId);
    $("#"+idSugDataResults).empty();
    $("#"+idSugDataResults).addClass('d-none');
    $("#"+idInputText).val(optionText);
    $("#"+idInputHidden).val(optionId);
    $("#" + idInputText).addClass('orange');
}

function hiddenResults(idSugDataResults) {
    setTimeout(function() {
        $("#"+idSugDataResults).addClass('d-none');
    }, 100);
}

function intelligentSearch(idInputHidden, idInputText, idSugData = 'sug-data', idSugDataResults = 'sug-data-results', numMinWords = 3) {
    
    $("#"+idInputText).removeClass('orange');
    $("#"+idInputHidden).val("");

    const searchText = $("#"+idInputText).val().toLowerCase() ?? $("#"+idInputText).val();
    $("#" + idSugDataResults).empty();

    $("#"+idSugDataResults).addClass('d-none');

  if (searchText != "" && searchText.length >= numMinWords) {
      
    console.log(searchText);

      $("#" + idSugData + " option").each(function () {
            
            const optionText = $(this).data('text');
            const optionIcon = $(this).data('icon') ? '<i class="'+$(this).data('icon')+'"></i> ' : "";
            const suggestion = optionText.toLowerCase();
            const optionId = $(this).attr('value');
            
            if (suggestion.includes(searchText)) {
                $("#"+idSugDataResults).removeClass('d-none');
                $("#" + idSugDataResults).append($("<div onclick='searchDataResultsOption(" + optionId + ",\"" + optionText + "\",\"" + idInputText + "\", \"" + idInputHidden + "\", \"" + idSugDataResults + "\")'>").html('<div class="option-result py-2 px-3">' + optionIcon + optionText + '</div>'));
            }
        });
    }
}

function number(amount) {
    return  parseFloat(amount.replace(/[^0-9.]/g, ''));
}

function money(amount) {
    return amount.toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}