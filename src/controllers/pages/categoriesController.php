<?php
require_once '../../../commons.php';
use ModelsNS\QueryModel;

if (!empty(getView())) {
    switch (getView()) {
        case "GETTABLE":
            gettable();
        break;
        case "SELECT":
            select();
        break;
        case 'CREATE':
            create();
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

function gettable() {
    $db = new QueryModel();
    $row = $db->query("SELECT id,name Categoría,CASE 
    WHEN type = 'P' THEN 'Producto'
    WHEN type = 'S' THEN 'Servicio' 
    ELSE type
    END AS Tipo FROM reg_category WHERE id_company = :id_company",[":id_company"=>$_SESSION['MYSESSION']['company']['id']]);
    $res = "";
    if(is_array($row) && count($row) > 0){
        $res = table('Category',$row,true);
    }
    $db->close();
    echo json_encode($res);
}

function select(){
    $data = getPostData();
    $db = new QueryModel();
    $id = $data['id'];
    $row = $db->queryUnique("SELECT id,name,
    CASE 
    WHEN type = 'P' THEN 'Producto'
    WHEN type = 'S' THEN 'Servicio' 
    ELSE type
    END AS tipo,type,DATE_FORMAT(timestamp_create, '%d-%m-%Y') FechaCreado,DATE_FORMAT(timestamp_update, '%d-%m-%Y') FechaActualizado FROM reg_category WHERE id_company = :id_company AND id = :id",[":id_company" => $_SESSION['MYSESSION']['company']['id'],":id"=>$id]);
    echo json_encode($row);
}

function create(){
    $data = $_POST;
    $db = new QueryModel();
    if (!empty($data) && count($data)>0) {

        $idCompany = $_SESSION['MYSESSION']['company']['id'];
        $row = $db->query("INSERT INTO reg_category(name,type,id_company) VALUES (:name,:type,:id_company)",[":name"=>$data['name'],":type"=>$data['type'],":id_company"=>$idCompany]);
        if($row == []){
            $response = 1;
        }else{
            $response = $row;
        }
        
    } else {
        $response = ['error'=>'Invalid format or no info'];
    }
    $db->close();
    echo json_encode($response);
}

function update(){
    $data = $_POST;
    $db = new QueryModel();

    $fields = [
        'name' => $data['name'] ?? null,
        'type' => $data['type'] ?? null
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
        $row = $db->query("UPDATE reg_category SET $setQuery WHERE id=:id",$params);
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
        $row = $db->query("DELETE FROM reg_category WHERE id=:id",[':id'=>$data['id']]);
    }
    if($row == []){
        echo 1;
    }else{
        echo json_encode($row);
    }
}