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
    $row = $db->query("SELECT p.id,CONCAT('./assets/img/products/',$id_company,'/',p.img) AS img,p.name Nombre,p.price Precio,p.cost Costo,(p.price-p.cost) Margen,p.stock Stock,c.name Categoría,
    CASE 
    WHEN p.availability = 1 THEN '<span class=\'text-success\'>Disponible</span>'
    WHEN p.availability = 0 THEN '<span class=\'text-secondary\'>No disponible</span>' 
    ELSE p.availability
    END AS Disponible FROM reg_product p LEFT JOIN reg_category c ON p.id_category = c.id WHERE p.id_company = :id_company",[":id_company"=>$id_company]);
    if(is_array($row) && count($row) > 0){
        $res = table('Product',$row,true,"",["Precio","Costo","Margen"]);
    }
    $db->close();
    echo json_encode($res);
}

function select(){
    $data = getPostData();
    $db = new QueryModel();
    $id = $data['id'];
    $id_company = $_SESSION['MYSESSION']['company']['id'];
    $row = $db->query("SELECT p.id,p.name,c.name category,p.price,p.cost,(p.price-p.cost) margen,p.stock, p.id_contact,t.company,p.sku,p.availability,p.id_user,u.name AS user,
    CASE 
    WHEN p.availability = 1 THEN '<span class=\'text-success\'>Disponible</span>'
    WHEN p.availability = 0 THEN '<span class=\'text-secondary\'>No disponible</span>' 
    ELSE p.availability
    END AS disponible,p.img img_name,CONCAT('./assets/img/products/',$id_company,'/',p.img) AS img,p.timestamp_create,p.timestamp_update FROM reg_product p 
    LEFT JOIN reg_category c ON p.id_category = c.id 
    LEFT JOIN reg_contact t ON p.id_contact = t.id 
    LEFT JOIN sys_user u ON p.id_user = u.id
    WHERE p.id_company = :id_company AND p.id = :id",[":id_company"=>$_SESSION['MYSESSION']['company']['id'],":id"=>$id]);

    echo json_encode($row);
}

function create(){
    $data = $_POST;
    $db = new QueryModel();

    $id_company = $_SESSION['MYSESSION']['company']['id'] ?? "0";
    $rutaBase = '../../../assets/img/products/' . $id_company . '/';
    
    $img = null;
    if($_FILES['img']){
        $img = createFile('img',$rutaBase);
        if($img == 6){
            echo 6;
            return;
        }
    }

    if($data['id_contact'] == "" || $data['id_contact'] == 0){
        unset($data['id_contact']);
    }

    $fields = dataInQuery($data,true,true);

    if($img){
        $fields['img'] = $img;
    }
    
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
        $row = $db->query("INSERT INTO reg_product($setQueryParams) VALUES($setQueryValues)",$params);
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

    if($_FILES['img']){
        $id_company = $_SESSION['MYSESSION']['company']['id'] ?? "0";
        $rutaBase = '../../../assets/img/products/' . $id_company . '/';
        $imgOld = $db->value("reg_product","id = $id","img");
        if($imgOld){
            unlink($rutaBase.$imgOld);
        }
        $img = createFile('img',$rutaBase);
        if($img == 6){
            echo 6;
            return;
        }
        $fields['img'] = $img;
    }

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
        $row = $db->query("UPDATE reg_product SET $setQuery WHERE id=:id",$params);
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
        $id = $data['id'];
        $id_company = $_SESSION['MYSESSION']['company']['id'] ?? "0";
        $rutaBase = '../../../assets/img/products/' . $id_company . '/';
        $imgOld = $db->value("reg_product","id = $id","img");
        if($imgOld){
            unlink($rutaBase.$imgOld);
        }
        $row = $db->query("DELETE FROM reg_product WHERE id=:id",[':id'=>$id]);
    }
    if($row == []){
        echo 1;
    }else{
        echo json_encode($row);
    }
}