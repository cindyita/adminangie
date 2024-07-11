<?php

function table($id,$data, $actions = false, $customActions = "",$formatMoney = []){
    $html = '<div class="p-2"><table class="table table-striped"><thead class="table-primary"><tr>';

    if(is_array($data) && count($data) > 0){
        
        foreach ($data[0] as $key => $value) {
            $html .= '<th>'.$key.'</th>';
        }
        
        if($actions && !$customActions){
            $html .= '<th></th>';
        }else if($actions && $customActions){
            $html .= '<th>Acciones</th>';
        }
        $html .= '</tr></thead><tbody>';
        
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $key => $value) {
                if($formatMoney != [] && in_array($key,$formatMoney)){
                    $html .= '<td>'.money($value).'</td>';
                }elseif($key == "img"){
                    $html .= '<td><a href="'.$value.'" target="_blank"><img src="'.$value.'" onerror="this.src = \'./assets/img/system/user.avif\'" loading="lazy" width="30px"></a></td>';
                }else{
                    $html .= '<td>'.$value.'</td>';
                }
                
            }

            $html .= '<td>'.btnActions($actions,$id,$row['id']).'</td>';

            $html .= '</tr>';
        }
    } else {
        return '';
    }

    $html .= '</tbody></table></div>';
    return $html;
}

function btnActions($actions,$idModal,$id,$customActions = ""){
    if($actions){
        if($customActions == ""){
            return '<div class="dropdown w-100 d-flex justify-content-end">
                <button type="button" class="btn btn-light2 dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#view'.$idModal.'" onclick="openModal(\'view\',\''.$idModal.'\','.$id.')"><i class="fa-solid fa-eye"></i> Ver</a></li>
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit'.$idModal.'" onclick="openModal(\'edit\',\''.$idModal.'\','.$id.')"><i class="fa-solid fa-pen-to-square"></i> Editar</a></li>
                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete'.$idModal.'" onclick="openModal(\'delete\',\''.$idModal.'\','.$id.')"><i class="fa-solid fa-trash"></i> Eliminar</a></li>
                </ul>
            </div>';
        }else{
            return $customActions;
        }
    }else{
        return "";
    }
}

function modal($idModal, $title, $content,$size = ""){
    $size = $size != "" ? 'modal-'.$size : "";
    $html = '<div class="modal" id="'.$idModal.'">
                <div class="modal-dialog modal-dialog-centered '.$size.'">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">'.$title.'</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <div class="modal-body">'.$content.'</div>
                    </div>
                </div>
            </div>';
    return $html;
}

function generateDatalist($array,$target = 0) {
    $options = '';
    foreach ($array as $item) {
        $name = $target != 0 ? $item[$target] : (isset($item['name']) ? $item['name'] : $item[1]);
        $options .= '<option value="' . $item['id'] . '" data-text="' . $name . '">';
    }
    return $options;
}
