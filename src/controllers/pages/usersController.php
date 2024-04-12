<?php
require_once '../../../commons.php';
use ModelsNS\QueryModel;

if (!empty(getView())) {
    switch (getView()) {
        case "GET":
            getUsers();
        break;
        default:
            echo "No action defined";
        break;
    }
}

function getUsers() {
    $db = new QueryModel();
    $row = $db->query("SELECT id,name Nombre,email Email,
    CASE status
    WHEN status = 1 THEN '<span class=\'text-success\'>Activo</span>'
    WHEN status = 0 THEN '<span class=\'text-secondary\'>Inactivo</span>' 
    END AS Estatus,DATE_FORMAT(timestamp_create, '%d-%m-%Y') FechaCreado FROM sys_users");
    if(is_array($row) && count($row) > 0){
        $res = table($row,true);
    }
    $db->close();
    echo json_encode($res);
}
