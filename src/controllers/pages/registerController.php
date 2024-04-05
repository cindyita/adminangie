<?php
require_once '../../../commons.php';
use ModelsNS\QueryModel;

if (!empty(getView())) {
    switch (getView()) {
        case 'CHECKEMAIL':
            checkExistEmail();
        break;
        case 'CHECKUSERNAME':
            checkExistUsername();
        break;
        case 'REGISTER':
            register();
        break;
        default:
            echo "No action defined";
        break;
    }
}

function checkExistEmail() {
    $data = getPostData();
    $db = new QueryModel();
    if (!empty($data) && count($data)>0) {
        $row = $db->queryUnique("SELECT email FROM users WHERE email=:email",[":email"=>$data['email']]);
        $response = json_encode($row);
    } else {
        $response = json_encode(['error'=>'Invalid format or no info']);
    }
    $db->close();
    echo json_encode($response);
}

function checkExistUsername() {
    $data = getPostData();
    $db = new QueryModel();
    if (!empty($data) && count($data)>0) {
        $row = $db->queryUnique("SELECT username FROM users WHERE username=:username",[":username"=>$data['username']]);
        $response = json_encode($row);
    } else {
        $response = json_encode(['error'=>'Invalid format or no info']);
    }
    $db->close();
    echo json_encode($response);
}

function register(){
    $data = $_POST;
    // if(checkCaptcha($data['g-recaptcha-response']) == true){
        $db = new QueryModel();
        if (!empty($data) && count($data)>0) {
            $row = $db->query("INSERT INTO users(username,email,password) VALUES (:username,:email,:pass)",[":username"=>$data['username'],":email"=>$data['email'],":pass"=>md5($data['pass'])]);
            $response = json_encode($row);
            if($response){
                sendEmail($data['email'],$data['username'],"Welcome","welcome to the page, you have successfully registered");
            }
        } else {
            $response = json_encode(['error'=>'Invalid format or no info']);
        }
        $db->close();
    // } else {
    //     return 3;
    // }
    echo json_encode($response);
}