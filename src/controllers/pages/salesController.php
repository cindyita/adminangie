<?php
require_once '../../../commons.php';
use ModelsNS\QueryModel;

if (!empty(getView())) {
    switch (getView()) {
        case "GETTABLE":
            gettable();
        break;
        case 'SELECT':
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
    $id_company = $_SESSION['MYSESSION']['company']['id'];
    $row = $db->query("SELECT s.id,s.num_invoice Folio,s.num_products Cantidad,s.total Total,m.name AS 'Método de pago',u.name Vendedor,s.status Estatus,s.fecha Fecha FROM reg_sales s LEFT JOIN reg_payment_method m ON s.id_payment_method = m.id LEFT JOIN sys_user u ON s.id_seller = u.id WHERE s.id_company = :id_company",[":id_company"=>$id_company]);
    $res = [];
    if(is_array($row)){
        $res = table('Sale',$row,true,"",["Total"]);
    }
    $db->close();
    echo json_encode($res);
}

function select(){
    $data = getPostData();
    $db = new QueryModel();
    $id = $data['id'];
    $id_company = $_SESSION['MYSESSION']['company']['id'];
    $row = $db->query("SELECT p.id,p.name,c.name category,p.price,p.cost,(p.price-p.cost) margen,p.stock, p.id_contact,t.company,p.sku,p.availability,
    CASE 
    WHEN p.availability = 1 THEN '<span class=\'text-success\'>Disponible</span>'
    WHEN p.availability = 0 THEN '<span class=\'text-secondary\'>No disponible</span>' 
    ELSE p.availability
    END AS disponible,p.img img_name,CONCAT('./assets/img/products/',$id_company,'/',p.img) AS img,p.timestamp_create,p.timestamp_update FROM reg_sales p LEFT JOIN reg_category c ON p.id_category = c.id LEFT JOIN reg_contact t ON p.id_contact = t.id WHERE p.id_company = :id_company AND p.id = :id",[":id_company"=>$_SESSION['MYSESSION']['company']['id'],":id"=>$id]);

    echo json_encode($row);
}

function create(){
    $data = $_POST;
    $db = new QueryModel();

    $fields = dataInQuery($data,true,true);
    
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
        $row = $db->query("INSERT INTO reg_sales($setQueryParams) VALUES($setQueryValues)",$params);
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
    $id = $data['id'];

    $fields = dataInQuery($data);

    $setParams = [];
    $params = [":id"=>$id];
    foreach ($fields as $key => $value) {
        if ($value !== null) {
            $setParams[] = "$key = :$key";
            $params[":$key"] = $value;
        }
    }

    if (!empty($setParams)) {
        $setQuery = implode(', ', $setParams);
        $row = $db->query("UPDATE reg_sales SET $setQuery WHERE id=:id",$params);
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
        $row = $db->query("DELETE FROM reg_sales WHERE id=:id",[':id'=>$data['id']]);
    }
    if($row == []){
        echo 1;
    }else{
        echo json_encode($row);
    }
}