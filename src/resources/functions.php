<?php

/**
 * The function `getSessionItem` retrieves a value from the `` array based on a specified key,
 * with a default value returned if the key is not found or the value is empty.
 * 
 * @param $key The `` parameter in the `getSessionItem` function is used to specify the key of the
 * item you want to retrieve from the `['MYSESSION']` array.
 * @param $def The `` parameter in the `getSessionItem` function is the default value that will be
 * returned if the session item with the specified key is not set or is empty. If the session item is
 * not found or is empty, the function will return the default value provided in the `` parameter
 * 
 * @return -The function `getSessionItem` is returning the value stored in
 * `['MYSESSION'][]` if it exists and is not empty. If the value does not exist or is
 * empty, it will return the default value ``.
 */
function getSessionItem($key, $def) {
    if (isset($_SESSION['MYSESSION']) && isset($_SESSION['MYSESSION'][$key]) && !empty($_SESSION['MYSESSION'][$key]) ) {
        return $_SESSION['MYSESSION'][$key];
    }
    return $def;
}

/**
 * The function `redirect` in PHP is used to redirect the user to a specified URL.
 * 
 * @param $url The `redirect` function is used to redirect the user to a different URL. When the
 * function is called with a URL parameter, it sends a header to the browser to redirect the user to
 * the specified URL. The `exit()` function is then called to stop the script execution after the
 * redirection.
 */
function redirect($url) {
    header("Location:" . $url);
    exit();
}

/**
 * The function `getPostParam` retrieves a specified POST parameter with optional filtering and default
 * value handling.
 * 
 * @param string $param The `param` parameter in the `getPostParam` function is a string that represents
 * the name of the parameter you want to retrieve from the `` superglobal array.
 * @param string $def The `def` parameter in the `getPostParam` function is a default value that will be
 * returned if the specified POST parameter is not set.
 * @param bool $trans The `trans` parameter in the `getPostParam` function is a boolean flag that
 * determines whether the value retrieved from `[]` should be sanitized using
 * `htmlspecialchars` before returning it. If `trans` is set to `TRUE`, the value will be sanitized;
 * otherwise, it
 * 
 * @return -The function `getPostParam` returns the value of the specified POST parameter after applying
 * `trim` and `htmlspecialchars` functions if the parameter exists in the `` array. If the
 * parameter does not exist, it returns the default value provided.
 */
function getPostParam(string $param, string $def='', bool $trans=TRUE) {
    if (isset($_POST[$param])) {
        if ($trans) {
            return trim(htmlspecialchars($_POST[$param]));
        }
        return trim($_POST[$param]);
    }
    return $def;
}

/**
 * The function `getParam` retrieves a specified parameter from the  superglobal array, sanitizes
 * it, and returns it with an optional default value if the parameter is not set.
 * 
 * @param string $param The `getParam` function is used to retrieve a parameter value from the ``
 * superglobal array in PHP. It takes two parameters: ``, which is the name of the parameter to
 * retrieve, and ``, which is the default value to return if the parameter is not set in
 * @param string $def The `getParam` function takes two parameters: `` and ``.
 * 
 * @return -The function `getParam` takes two parameters: `` and ``. It checks if the ``
 * exists in the `` superglobal array. If it does, it trims and sanitizes the value using
 * `htmlspecialchars` before returning it. If the `` does not exist in ``, it returns the
 * default value ``.
 */
function getParam(string $param, string $def='') {
    return isset($_GET[$param]) ? trim(htmlspecialchars($_GET[$param])) : $def;
}

/**
 * The function `getGUID` generates a unique identifier (GUID) in PHP using either the
 * `com_create_guid` function or a custom implementation based on `md5` and `uniqid`.
 * 
 * @return -A GUID (Globally Unique Identifier) is being returned by this function. The GUID is
 * generated using a combination of methods based on the availability of the `com_create_guid`
 * function. If the `com_create_guid` function is available, it is used to generate the GUID.
 * Otherwise, a custom method is used to create a GUID by combining various elements like `md5`,
 * `uniqid
 */
function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    } else {
        mt_srand((double)microtime()*10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
        .substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12)
        .chr(125);// "}"
        return $uuid;
    }
}

/**
 * The getRandomString function generates a random string of a specified length using a combination of
 * uppercase letters, lowercase letters, and numbers.
 * 
 * @param $length The `getRandomString` function generates a random string of a specified length. The
 * parameter `` specifies the length of the random string that will be generated.
 * 
 * @return -The function `getRandomString` returns a random string of the specified length generated
 * using characters from the alphabet containing uppercase letters, lowercase letters, and numbers.
 */
function getRandomString($length) {
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet) - 1;
    for ($i = 0; $i < $length; $i ++) {
        $token .= $codeAlphabet[cryptoRandSecure(0, $max)];
    }
    return $token;
}

/**
 * The function `cryptoRandSecure` generates a cryptographically secure random number within a
 * specified range.
 * 
 * @param $min The `min` parameter in the `cryptoRandSecure` function represents the minimum value of
 * the range from which you want to generate a random number. This function generates a
 * cryptographically secure random number within the specified range.
 * @param $max The `max` parameter in the `cryptoRandSecure` function represents the maximum value that
 * you want to generate a random number up to. This function generates a cryptographically secure
 * random number within the range specified by the `min` and `max` parameters.
 * 
 * @return -The function `cryptoRandSecure` returns a cryptographically secure random number within the
 * specified range (, ).
 */
function cryptoRandSecure($min, $max) {
    $range = $max - $min;
    if ($range < 1) {
        return $min;
    }
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1;
    $bits = (int) $log + 1;
    $filter = (int) (1 << $bits) - 1; 
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter;
    } while ($rnd >= $range);
    return $min + $rnd;
}

/**
 * Get and compare current page (Without params, returns current page name)
 * 
 * @param string $name - Name to campare
 * @param string $optA - If name match, value to return
 * @param string value - If name match, dont match
 * @return string
 */
function currentPage(string $name=NULL, $optA=NULL, $optB=NULL) {
    $result = basename($_SERVER['PHP_SELF']);
    if ($optA == NULL) {
        return $result;
    }
    return $result == $name ? $optA : $optB;
}

/**
 * The function getView() returns the value of a post parameter named VIEW in PHP.
 * 
 * @return -The `getView` function is returning the value of the `VIEW` post parameter by calling the
 * `getPostParam` function.
 */
function getView() {
    return getPostParam(VIEW);
}

/**
 * The function `getData` checks if the input is in JSON format and returns it as JSON, otherwise
 * returns the POST data.
 * 
 * @return -The `getData` function is returning the data from the input stream if it is in JSON format,
 * otherwise it is returning the data from the `` superglobal array.
 */
function getData() {
    return isJson(file_get_contents('php://input')) ? json_encode(file_get_contents('php://input')) : $_POST;
}

/**
 * This PHP function retrieves data from the POST request.
 * 
 * @return -The function `getPostData()` is returning the value of `['data']`.
 */
function getPostData() {
    return $_POST['data'];
}

/**
 * The function `isJson` checks if a given string is a valid JSON format in PHP.
 * 
 * @param $string The `isJson` function in the code snippet checks if a given string is a valid JSON
 * string. The function uses the `json_decode` function to decode the string and then checks if there
 * was no error during the decoding process by comparing the result of `json_last_error()` with
 * `JSON_ERROR
 * 
 * @return -The function `isJson` is checking if the input string is a valid JSON format. It returns
 * `true` if the input string is a valid JSON and `false` if it is not valid.
 */
function isJson($string) {
   json_decode($string, TRUE);
   return json_last_error() === JSON_ERROR_NONE;
}

/**
 * The function `checkCaptcha` in PHP is used to verify a user's response to a reCAPTCHA challenge.
 * 
 * @param $response The `checkCaptcha` function you provided is used to verify a reCAPTCHA response. The
 * function sends a request to Google's reCAPTCHA verification endpoint with the secret key and the
 * user's response, and then checks if the verification was successful.
 * 
 * @return -The function `checkCaptcha` is returning the value of `->success`, which is the
 * success status of the ReCaptcha verification.
 */
function checkCaptcha($response){
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
    $recaptcha_secret = $_ENV["RECAPTCHA_SECRET"]; 
    $recaptcha_response = $response; 
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
    $recaptcha = json_decode($recaptcha); 

    return $recaptcha->success;
}
