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
        case 'SELECTPRODUCTS':
            selectProducts();
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
        case 'INTELLIGENTSEARCH':
            searchProducts();
        break;
        case 'ALLPRODUCTSSEARCH':
            allProductSearch();
        break;
        default:
            echo json_encode("No se definió una acción");
        break;
    }
}

function gettable() {
    $db = new QueryModel();
    $id_company = $_SESSION['MYSESSION']['company']['id'];
    $row = $db->query("SELECT s.id,s.total Total,s.num_products Cantidad,m.name AS 'Método de pago',s.name_seller Vendedor,s.sale_date Fecha,s.num_invoice Ref,
    CASE 
    WHEN m.type = 1 THEN '<span class=\'text-success\'>Listo</span>'
    WHEN m.type = 2 THEN '<span class=\'text-secondary\'>En espera</span>' 
    WHEN m.type = 3 THEN '<span class=\'text-secondary\'>Revisar</span>' 
    ELSE s.status
    END AS Estatus
    FROM reg_sales s LEFT JOIN reg_payment_method m ON s.id_payment_method = m.id WHERE s.id_company = :id_company",[":id_company"=>$id_company]);
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
    $row = $db->query("SELECT s.*,m.name payment_method,u.name user FROM reg_sales s LEFT JOIN reg_payment_method m ON s.id_payment_method = m.id LEFT JOIN sys_user u ON s.id_user = u.id WHERE s.id = :id",[":id"=>$id]);
    echo json_encode($row);
}

function selectProducts(){
    $data = getPostData();
    $db = new QueryModel();
    $id = $data['id'];
    $row = $db->query("SELECT r.*,p.name,p.price,p.sku FROM rel_sale_product r LEFT JOIN reg_product p ON r.id_product = p.id WHERE r.id_sale = :id",[":id"=>$id]);
    echo json_encode($row);
}

function create(){
    $data = getPostData();
    $db = new QueryModel();

    if (!empty($data)) {
        $id_company = $_SESSION['MYSESSION']['company']['id'];
        $row = $db->query("INSERT INTO reg_sales(num_invoice,num_products,total,id_payment_method,notes,name_seller,id_user,sale_date,id_company) VALUES(:num_invoice,:num_products,:total,:id_payment_method,:notes,:name_seller,:id_user,:sale_date,:id_company)",[":num_invoice"=>$data['num_invoice'],":num_products"=>$data['num_products'],":total"=>$data['total'],":id_payment_method"=>$data['id_payment_method'],":notes"=>$data['notes'],":name_seller"=>$data['name_seller'],":id_user"=>$_SESSION['MYSESSION']['id'],":sale_date"=>$data['sale_date'],":id_company"=>$id_company]);
        $id_sale = $db->lastid();
        if($id_sale){
            foreach ($data as $key => $value) {
                if (strpos($key, 'id_product_') === 0) {
                    $product_index = str_replace('id_product_', '', $key);
                    $id_product = $value;
                    $num_products = $data["nums_$product_index"];
                    if ($id_product && $id_product != "" && $num_products > 0) {
                        $db->query("INSERT INTO rel_sale_product(id_sale, id_product, num_products) VALUES(:id_sale, :id_product, :num_products)", [
                            ':id_sale' => $id_sale,
                            ':id_product' => $id_product,
                            ':num_products' => $num_products
                        ]);
                    }
                }
            }
        }
        
        if($row == []){
            echo 1;
        }else{
            echo json_encode($row);
        }
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
        $row = $db->query("DELETE FROM rel_sale_product WHERE id_sale=:id",[':id'=>$data['id']]);
    }
    if($row == []){
        echo 1;
    }else{
        echo json_encode($row);
    }
}

function searchProducts(){
    $data = getPostData();
    $db = new QueryModel();
    if($data && !empty($data['text'])){
        $text = $data['text'] . '%';
        $row = $db->query("SELECT id, name, price FROM reg_product WHERE name LIKE :text", [':text' => $text]);
    } else {
        $row = [];
    }
    echo json_encode($row);
}

function allProductSearch(){
    $db = new QueryModel();
    $row = $db->query("SELECT id, name, price FROM reg_product", []);
    echo json_encode($row);
}