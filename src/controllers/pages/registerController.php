<?php
require_once '../../../commons.php';
use ModelsNS\QueryModel;

if (!empty(getView())) {
    switch (getView()) {
        case 'CHECKEMAIL':
            checkExistEmail();
        break;
        case 'REGISTER':
            register();
        break;
        default:
            echo json_encode("No se definió una acción");
        break;
    }
}

function checkExistEmail() {
    $data = getPostData();
    $db = new QueryModel();
    if (!empty($data)) {
        $row = $db->queryUnique("SELECT email FROM sys_users WHERE email=:email",[":email"=>$data['email']]);
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

            $key = password_hash($data['registerKey'], PASSWORD_DEFAULT);
            $idCompany = $db->value("sys_company","register_password = '$key'","id");

            if(empty($idCompany) || !$idCompany || $idCompany == []){
                return 5;
            }
            $pass = password_hash($data['pass'], PASSWORD_DEFAULT);
            $row = $db->query("INSERT INTO sys_users(name,email,password,id_company) VALUES (:name,:email,:pass,:id_company)",[":name"=>$data['name'],":email"=>$data['email'],":pass"=> $pass,":id_company"=>$idCompany]);
            $response = json_encode($row);
            // if($response){
            //     sendEmail($data['email'],$data['name'],"Bienvenid@ a Angie","Te has registrado correctamente");
            // }
        } else {
            $response = json_encode(['error'=>'Invalid format or no info']);
        }
        $db->close();
    // } else {
    //     return 3;
    // }
    echo json_encode($response);
}