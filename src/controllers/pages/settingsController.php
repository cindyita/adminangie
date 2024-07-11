<?php
require_once '../../../commons.php';
use ModelsNS\QueryModel;

if (!empty(getView())) {
    switch (getView()) {
        case 'SAVE':
            savesettings();
        break;
        case 'CHANGE_DBTYPE':
            changedbtype();
        break;
        default:
            echo json_encode("No se definió una acción");
        break;
    }
}

function savesettings() {
    $data = $_POST;
    $db = new QueryModel();
    $id_company = $_SESSION['MYSESSION']['company']['id'] ?? "0";
    $rutaBase = '../../../assets/img/company/' . $id_company . '/';
    
    $img_logo = null;
    if($_FILES['img_logo']){
        // $imgOld1 = $db->value("sys_company","id = $id_company","img_logo");
        // if($imgOld1){
        //     unlink($rutaBase.$imgOld1);
        // }
        $img_logo = createFile('img_logo',$rutaBase);
        if($img_logo == 6){
            echo 6;
            return;
        }
        if($img_logo){
            $_SESSION['MYSESSION']['company']['img_logo'] = $img_logo;
        }
    }

    $img_favicon = null;
    if($_FILES['img_favicon']){
        // $imgOld2 = $db->value("sys_company","id = $id_company","img_favicon");
        // if($imgOld2){
        //     unlink($rutaBase.$imgOld2);
        // }
        $img_favicon = createFile('img_favicon',$rutaBase);
        if($img_favicon == 6){
            echo 6;
            return;
        }
        if($img_favicon){
            $_SESSION['MYSESSION']['company']['img_favicon'] = $img_favicon;
        }
    }
    $img_font = null;
    if($_FILES['img_font']){
        // $imgOld3 = $db->value("sys_company","id = $id_company","img_font");
        // if($imgOld3){
        //     unlink($rutaBase.$imgOld3);
        // }
        $img_font = createFile('img_font',$rutaBase);
        if($img_font == 6){
            echo 6;
            return;
        }
        if($img_font){
            $_SESSION['MYSESSION']['company']['img_font'] = $img_font;
        }
    }

    $fields = [
        'register_password' => $data['register_password'] ?? null,
        'app_title' => $data['app_title'] ?? null,
        'company' => $data['company'] ?? null,
        'primary_color' => $data['primary_color'] ?? null,
        'secondary_color' => $data['secondary_color'] ?? null,
        'tertiary_color' => $data['tertiary_color'] ?? null,
        'accent_color' => $data['accent_color'] ?? null,
        'menutext_color' => $data['menutext_color'] ?? null,
        'text_size_plus' => $data['text_size_plus'] ?? 0,
        'img_logo' => $img_logo ?? null,
        'img_favicon' => $img_favicon ?? null,
        'img_font' => $img_font ?? null
    ];

    $setParams = [];
    $params = [":id" => $id_company];
    foreach ($fields as $key => $value) {
        if ($value !== null) {
            $setParams[] = "$key = :$key";
            if($key === 'register_password'){
                $params[":$key"] =  password_hash($value, PASSWORD_DEFAULT);
            }else{
                $params[":$key"] = $value;
                $_SESSION['MYSESSION']['company'][$key] = $value;
            }
        }
    }

    if (!empty($setParams)) {
        $setQuery = implode(', ', $setParams);
        $row = $db->query("UPDATE sys_company SET $setQuery WHERE id=:id",$params);
    }


    if($row == []){
        echo 1;
    }else{
        echo json_encode($row);
    }
}

function changedbtype(){
    $id_company = $_SESSION['MYSESSION']['company']['id'] ?? 1;

    $dbtype = $_SESSION['MYSESSION']['company']['db_type'] == "1" ? "0" : "1";
    $_SESSION['MYSESSION']['company']['db_type'] = $dbtype;

    $db = new QueryModel();
    
    $row = $db->query("UPDATE sys_company SET db_type = :db_type WHERE id=:id",[":db_type"=>$dbtype,":id" => $id_company]);

    if($row == []){
        echo 1;
    }else{
        echo 7;
    }
}