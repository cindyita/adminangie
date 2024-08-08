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
        case 'GETEVENTS':
            getEvents();
        break;
        case 'CREATEEVENT':
            createEvent();
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

function getEvents(){
    $db = new QueryModel();
    $id_company = $_SESSION['MYSESSION']['company']['id'];
    $row = $db->query("SELECT * FROM reg_events WHERE id_company = :id_company",[":id_company"=>$id_company]);
    echo json_encode($row);
    $db->close();
}

function createEvent(){
    $data = getPostData();
    $db = new QueryModel();

    $fields = dataInQuery($data,true,true);
    
    $setParams = [];
    $setValues = [];
    $params = [];
    foreach ($fields as $key => $value) {
        if ($value !== null && $value != "") {
            $setParams[] = "$key";
            $setValues[] = ":$key";
            $params[":$key"] = $value; 
        }
    }

    if (!empty($setParams)) {
        $setQueryParams = implode(',', $setParams);
        $setQueryValues = implode(',', $setValues);
        $row = $db->query("INSERT INTO reg_events($setQueryParams) VALUES($setQueryValues)",$params);
    }

    if($row == []){
        echo 1;
    }else{
        echo json_encode($row);
    }
}