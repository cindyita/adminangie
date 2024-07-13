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
    $row = $db->query("SELECT c.id,c.company Empresa,c.name_contact Contacto,c.tel1 Teléfono, t.name Tipo, c.prod_serv AS 'Producto/Servicio'
    FROM reg_contact c LEFT JOIN reg_type_contact t ON c.id_type = t.id WHERE c.id_company = :id_company",
    [":id_company"=>$_SESSION['MYSESSION']['company']['id']]);
    $res = "";
    if(is_array($row) && count($row) > 0){
        $res = table('Contact',$row,true);
    }
    $db->close();
    echo json_encode($res);
}

function select(){
    $data = getPostData();
    $db = new QueryModel();
    $id = $data['id'];
    $row = $db->queryUnique("SELECT c.*, t.name tipo, u.name AS user
    FROM reg_contact c 
    LEFT JOIN reg_type_contact t ON c.id_type = t.id 
    LEFT JOIN sys_user u ON c.id_user = u.id
    WHERE c.id_company = :id_company AND c.id = :id",[":id_company" => $_SESSION['MYSESSION']['company']['id'],":id"=>$id]);
    echo json_encode($row);
}

function create(){
    $data = $_POST;
    $db = new QueryModel();

    $idCompany = $_SESSION['MYSESSION']['company']['id'];
    $fields = [
        'company' => $data['company'] ?? null,
        'name_contact' => $data['name_contact'] ?? null,
        'tel1' => $data['tel1'] ?? null,
        'tel2' => $data['tel2'] ?? null,
        'address' => $data['address'] ?? null,
        'rfc' => $data['rfc'] ?? null,
        'id_type' => $data['id_type'] ?? null,
        'prod_serv' => $data['prod_serv'] ?? null,
        'extra_data' => $data['extra_data'] ?? null,
        'id_company' => $idCompany,
        'id_user' => $_SESSION['MYSESSION']['id']
    ];

    $setParams = [];
    $setValues = [];
    $params = [];
    foreach ($fields as $key => $value) {
        if ($value !== null) {
            $setParams[] = "$key";
            $setValues[] = ":$key";
            $params[":$key"] = $value;    
        }
    }

    if (!empty($setParams)) {
        $setQueryParams = implode(',', $setParams);
        $setQueryValues = implode(',', $setValues);
        $row = $db->query("INSERT INTO reg_contact($setQueryParams) VALUES($setQueryValues)",$params);
    }

    if($row == []){
        echo 1;
    }else{
        echo json_encode($row);
    }
    
}

function update(){
    $data = $_POST;
    $db = new QueryModel();

    $fields = dataInQuery($data);

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
        $row = $db->query("UPDATE reg_contact SET $setQuery WHERE id=:id",$params);
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
        $row = $db->query("DELETE FROM reg_contact WHERE id=:id",[':id'=>$data['id']]);
    }
    if($row == []){
        echo 1;
    }else{
        echo json_encode($row);
    }
}