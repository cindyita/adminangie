<?php
require_once '../../../commons.php';
use ModelsNS\QueryModel;

if (!empty(getView())) {
    switch (getView()) {
        case "GETTABLE":
            getUsers();
        break;
        case 'REGISTER':
            registerUser();
        break;
        case 'CHECKEMAIL':
            checkExistEmail();
        break;
        case 'SELECT':
            select();
        break;
        case 'UPDATE':
            update();
        break;
        case 'DELETE':
            delete();
        break;
        default:
            echo json_encode("No se definió una acción");
        break;
    }
}

function getUsers() {
    $db = new QueryModel();
    $id_company = $_SESSION['MYSESSION']['company']['id'];
    $row = $db->query("SELECT id,CONCAT('./assets/img/users/{$id_company}/',img) AS img,name Nombre,email Email,
    CASE 
    WHEN status = 1 THEN '<span class=\'text-success\'>Activo</span>'
    WHEN status = 0 THEN '<span class=\'text-secondary\'>Inactivo</span>' 
    ELSE status
    END AS Estatus,DATE_FORMAT(timestamp_create, '%d-%m-%Y') Registro FROM sys_user WHERE id_company = :id_company",[":id_company"=>$_SESSION['MYSESSION']['company']['id']]);
    if(is_array($row) && count($row) > 0){
        $res = table('User',$row,true);
    }
    $db->close();
    echo json_encode($res);
}

function registerUser(){
    $data = $_POST;
    if($_SESSION['MYSESSION']['id_role'] == 1){
        $db = new QueryModel();
        if (!empty($data) && count($data)>0) {

            $idCompany = $_SESSION['MYSESSION']['company']['id'];
            $idUser = $_SESSION['MYSESSION']['id'];
            $pass = password_hash($data['pass'], PASSWORD_DEFAULT);
            $row = $db->query("INSERT INTO sys_user(name,email,password,id_role,status,id_user,id_company) VALUES (:name,:email,:pass,:id_role,:status,:id_user,:id_company)",[":name"=>$data['name'],":email"=>$data['email'],":pass"=>$pass,":id_role"=>$data['id_role'],":status"=>$data['status'],":id_user"=>$idUser,":id_company"=>$idCompany]);
            if($row == []){
                $response = 1;
            }else{
                $response = $row;
            }
            
            // if($response){
            //     sendEmail($data['email'],$data['name'],"Bienvenid@ a Angie","Te has registrado correctamente");
            // }
        } else {
            $response = ['error'=>'Invalid format or no info'];
        }
        $db->close();
    } else {
        return 8;
    }
    echo json_encode($response);
}

function checkExistEmail() {
    $data = getPostData();
    $db = new QueryModel();
    if (!empty($data)) {
        $row = $db->queryUnique("SELECT email FROM sys_user WHERE email=:email",[":email"=>$data['email']]);
        $response = json_encode($row);
    } else {
        $response = json_encode(['error'=>'Invalid format or no info']);
    }
    $db->close();
    echo json_encode($response);
}

function select(){
    $data = getPostData();
    $db = new QueryModel();
    $id = $data['id'];
    $row = $db->queryUnique("SELECT u.*,
    CASE 
    WHEN u.status = 1 THEN '<span class=\'text-success\'>Activo</span>'
    WHEN u.status = 0 THEN '<span class=\'text-secondary\'>Inactivo</span>' 
    ELSE u.status
    END AS estatus,r.name AS role FROM sys_user u LEFT JOIN sys_rol r ON u.id_role = r.id WHERE u.id = :id",[":id" => $id]);
    echo json_encode($row);
}

function update(){
    $data = $_POST;
    $db = new QueryModel();

    $fields = [
        'name' => $data['name'],
        'email' => $data['email'],
        'id_role' => $data['id_role'],
        'status' => $data['status']
    ];

    $setParams = [];
    $params = [":id" => $data['id']];
    foreach ($fields as $key => $value) {
        if ($value !== null) {
            $setParams[] = "$key = :$key";
            $params[":$key"] = $value;    
        }
    }

    if (!empty($setParams)) {
        $setQuery = implode(', ', $setParams);
        $row = $db->query("UPDATE sys_user SET $setQuery WHERE id=:id",$params);
    }

    if($row == []){
        echo 1;
    }else{
        echo json_encode($row);
    }
    
}

function delete(){
    $data = $_POST;
    $db = new QueryModel();
    if($data && $data['id']){
        $row = $db->query("DELETE FROM sys_user WHERE id=:id",[':id'=>$data['id']]);
    }
    if($row == []){
        echo 1;
    }else{
        echo json_encode($row);
    }
}