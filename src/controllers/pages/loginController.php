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
            echo "No action defined";
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