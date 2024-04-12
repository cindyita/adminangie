<?php

function table($data, $actions = false){
    $html = '<div class="p-2"><table class="table table-striped"><thead class="table-primary"><tr>';

    if(is_array($data) && count($data) > 0){
        foreach ($data[0] as $key => $value) {
            $html .= '<th>'.$key.'</th>';
        }
        if($actions){
            $html .= '<th>Acciones</th>';
            $btnsActions = '<div class="dropdown w-100 d-flex justify-content-end">
                                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-pen-to-square"></i> Editar</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-ban"></i> Desactivar</a></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="fa-solid fa-trash"></i> Eliminar</a></li>
                                </ul>
                            </div>';
        }
        $html .= '</tr></thead><tbody>';
        
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $value) {
                $html .= '<td>'.$value.'</td>';
            }
            if($actions){
                $html .= '<td>'.$btnsActions.'</td>';
            }
            $html .= '</tr>';
        }
    } else {
        return '';
    }

    $html .= '</tbody></table></div>';
    return $html;
}

function modal($idModal, $title, $content){
    $html = '<div class="modal" id="'.$idModal.'">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">'.$title.'</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">'.$content.'</div>
                    </div>
                </div>
            </div>';
    return $html;
}