<?php
require_once '../../../commons.php';
use ModelsNS\QueryModel;

if (!empty(getView())) {
    switch (getView()) {
        case 'GETNOTE':
            getNote();
        break;
        case 'SAVENOTE':
            saveNote();
        break;
        default:
            echo json_encode("No se definió una acción");
        break;
    }
}

function getNote(){
    $db = new QueryModel();
    $id_company = $_SESSION['MYSESSION']['company']['id'];
    $row = $db->queryUnique("SELECT notes FROM sys_company WHERE id=:id_company",[":id_company"=>$id_company]);
    echo json_encode($row);
}

function saveNote(){
    $data = getPostData();
    $db = new QueryModel();
    if (!empty($data)) {
        $id_company = $_SESSION['MYSESSION']['company']['id'];
        $row = $db->query("UPDATE sys_company SET notes=:notes WHERE id=:id_company",[":notes"=>$data['notes'],":id_company"=>$id_company]);
    }
    if($row == []){
        echo 1;
    }else{
        echo json_encode($row);
    }
    $db->close();
}