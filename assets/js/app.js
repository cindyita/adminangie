/* The code is initializing two constants `ACTUALPAGE` and `CONTROLLER` by calling the functions `actualPage()` and `pageController()` respectively. */
const ACTUALPAGE = actualPage();
const CONTROLLER = pageController();

/* The code is using jQuery to select all elements with the class "page-overlay" and then calling the
`fadeOut()` method on them. This code is likely intended to fade out any elements with the
"page-overlay" class when the document is ready or when the DOM has finished loading. */
$(function () {
  $(".page-overlay").fadeOut();
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
function message(text, type = "info") {
  var html = '<div class="message '+type+'">'+text+'</div>';
  var $message = $(html);
  $message.hide().prependTo('body').fadeIn();
  setTimeout(function() {
      $message.fadeOut(function() {
          $(this).remove();
      });
  }, 4000);
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
      message("The email or password is incorrect", "error");
      console.log("Error 2: The email or password is incorrect");
      return false;
    default:
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
      message('success', 'Enlace copiado al portapapeles');
    })
    .catch(function() {
      message('error', 'No se pudo copiar el enlace');
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