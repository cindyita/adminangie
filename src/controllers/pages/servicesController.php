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
        case 'SELECTADDITIONS':
            selectAdditions();
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
    $row = $db->query("SELECT p.id,CONCAT('./assets/img/services/',$id_company,'/',p.img) AS img,p.name Nombre,p.price Precio,p.cost Costo,(p.price-p.cost) Margen,CONCAT(p.standby_days,'d ',p.standby_time) Preparación,c.name Categoría,
    CASE 
    WHEN p.availability = 1 THEN '<span class=\'text-success\'>Disponible</span>'
    WHEN p.availability = 0 THEN '<span class=\'text-secondary\'>No disponible</span>' 
    ELSE p.availability
    END AS Disponible FROM reg_service p
    LEFT JOIN reg_category c ON p.id_category = c.id WHERE p.id_company = :id_company",[":id_company"=>$id_company]);
    if(is_array($row) && count($row) > 0){
        $res = table('Service',$row,true,"",["Precio","Costo","Margen"]);
    }
    $db->close();
    echo json_encode($res);
}

function select(){
    $data = getPostData();
    $db = new QueryModel();
    $id = $data['id'];
    $id_company = $_SESSION['MYSESSION']['company']['id'];
    $row = $db->query("SELECT p.*,(p.price-p.cost) margen,CONCAT('./assets/img/services/',$id_company,'/',p.img) AS img,c.name category,u.name user,
    CASE 
    WHEN p.availability = 1 THEN '<span class=\'text-success\'>Disponible</span>'
    WHEN p.availability = 0 THEN '<span class=\'text-secondary\'>No disponible</span>' 
    ELSE p.availability
    END AS disponible FROM reg_service p
    LEFT JOIN reg_category c ON p.id_category = c.id
    LEFT JOIN sys_user u ON p.id_user = u.id
    WHERE p.id_company = :id_company AND p.id = :id",[":id_company"=>$id_company,":id"=>$id]);
    echo json_encode($row);
}

function selectAdditions(){
    $data = getPostData();
    $db = new QueryModel();
    $id = $data['id'];
    $row = $db->query("SELECT a.* 
    FROM reg_service_additions a WHERE a.id_service = :id",[":id"=>$id]);
    echo json_encode($row);
}

function create(){
    $data = $_POST;
    $db = new QueryModel();

    $id_company = $_SESSION['MYSESSION']['company']['id'] ?? "0";
    $rutaBase = '../../../assets/img/services/' . $id_company . '/';
    
    $img = null;
    if($_FILES['img']){
        $img = createFile('img',$rutaBase);
        if($img == 6){
            echo 6;
            return;
        }
    }

    $row = $db->query("INSERT INTO reg_service(name,id_category,price,cost,standby_time,standby_days,sku,description,includes,num_additions,img,availability,id_user,id_company) VALUES(:name,:id_category,:price,:cost,:standby_time,:standby_days,:sku,:description,:includes,:num_additions,:img,:availability,:id_user,:id_company)",[":name"=>$data['name'],
    ":id_category"=>$data['id_category'],
    ":price"=>$data['price'],
    ":cost"=>$data['cost'],
    ":standby_time"=>$data['standby_time'] ?? null,
    ":standby_days"=>$data['standby_days'] ?? null,
    ":sku"=>$data['sku'] ?? null,
    ":description"=>$data['description'] ?? null,
    "num_additions"=>$data['num_additions'] ?? 0,
    ":includes"=>$data['includes'] ?? null,
    ":img"=>$img ?? null,
    ":availability"=>$data['availability'],
    ":id_user"=>$_SESSION['MYSESSION']['id'],
    ":id_company"=>$id_company]);

    if($row == []){
        $id_service = $db->lastid();
        foreach ($data as $key => $value) {
            if (strpos($key, 'addition_') === 0) {
                $index = str_replace('addition_', '', $key);
                $name_add = $value;
                $price_add = $data["additionPrice_$index"];
                $cost_add = $data["additionCost_$index"];
                if ($name_add && $name_add != "") {
                    $row = $db->query("INSERT INTO reg_service_additions(name,price,cost,id_service) VALUES(:name,:price,:cost,:id_service)", [
                        ':name' => $name_add,
                        ':price' => $price_add,
                        ':cost' => $cost_add,
                        ':id_service' =>$id_service
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

function update(){
    $data = $_POST;
    $db = new QueryModel();
    $id = $data['id'];

    $fields = dataInQuery($data);

    if($_FILES['img']){
        $id_company = $_SESSION['MYSESSION']['company']['id'] ?? "0";
        $rutaBase = '../../../assets/img/services/' . $id_company . '/';
        $imgOld = $db->value("reg_service","id = $id","img");
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

    $row = $db->query("UPDATE reg_service SET name=:name,id_category=:id_category,price=:price,cost=:cost,standby_time=:standby_time,standby_days=:standby_days,sku=:sku,description=:description,includes=:includes,num_additions=:num_additions,img=:img,availability=:availability,id_user=:id_user,id_company=:id_company WHERE id = :id",[":name"=>$data['name'],
    ":id_category"=>$data['id_category'],
    ":price"=>$data['price'],
    ":cost"=>$data['cost'],
    ":standby_time"=>$data['standby_time'] ?? null,
    ":standby_days"=>$data['standby_days'] ?? null,
    ":sku"=>$data['sku'] ?? null,
    ":description"=>$data['description'] ?? null,
    "num_additions"=>$data['num_additions'] ?? 0,
    ":includes"=>$data['includes'] ?? null,
    ":img"=>$img ?? null,
    ":availability"=>$data['availability'],
    ":id_user"=>$_SESSION['MYSESSION']['id'],
    ":id_company"=>$id_company,
    ":id"=>$data['id']]);

    if($row == []){
        $row = $db->delete("reg_service_additions","id_service = $id");
        foreach ($data as $key => $value) {
            if (strpos($key, 'addition_') === 0) {
                $index = str_replace('addition_', '', $key);
                $name_add = $value;
                $price_add = $data["additionPrice_$index"];
                $cost_add = $data["additionCost_$index"];
                if ($name_add && $name_add != "") {
                    $row = $db->query("INSERT INTO reg_service_additions(name,price,cost,id_service) VALUES(:name,:price,:cost,:id_service)", [
                        ':name' => $name_add,
                        ':price' => $price_add,
                        ':cost' => $cost_add,
                        ':id_service' =>$id
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

function delete(){
    $data = $_POST;
    $db = new QueryModel();
    if($data && $data['id']){
        $id = $data['id'];
        $id_company = $_SESSION['MYSESSION']['company']['id'] ?? "0";
        $rutaBase = '../../../assets/img/services/' . $id_company . '/';
        $imgOld = $db->value("reg_service","id = $id","img");
        if($imgOld){
            unlink($rutaBase.$imgOld);
        }
        $row = $db->query("DELETE FROM reg_service WHERE id=:id",[':id'=>$id]);
        $row = $db->query("DELETE FROM reg_service_additions WHERE id_service=:id",[':id'=>$id]);
    }
    if($row == []){
        echo 1;
    }else{
        echo json_encode($row);
    }
}