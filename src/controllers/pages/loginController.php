<?php
require_once '../../../commons.php';
// use ModelsNS\QueryModel;
use ControllersNS\AuthController;

if (!empty(getView())) {
    switch (getView()) {
        case 'LOGIN':
            login();
        break;
        default:
            echo json_encode("No se definió una acción");
        break;
    }
}

function login(){
    $data = $_POST;
    // if(checkCaptcha($data['g-recaptcha-response']) == true){
        $response = AuthController::auth($data);
    // } else {
    //     return 3;
    // }
    echo json_encode($response);
}