<?php
    require('../config/db.conf.php');
    require('../class/connection.class.php');
    require('../class/city.class.php');
    $obj_city     =     new City();

    $option       =     isset($_REQUEST['opt']) ? $_REQUEST['opt'] : 1;

    switch($option)
    {
        case 1://return list of Cities
            $id_city        =   isset($_REQUEST['id']) ? trim($_REQUEST['id']) : 0;
            $data           =   $obj_city->select_city($id_city);
        break;

        case 2: //return list of countries
            $data           =   $obj_city->select_country();
        break;

        case 3:
            $data = array(
                'id_country'    => $_REQUEST['id_sel_country'],
                'name'          => strtoupper(trim($_REQUEST['id_txt_city'])),
                'format_code'   => strtoupper(trim($_REQUEST['id_txt_fmt_zip']))
            );
            $data           =   $obj_city->new_city($data);
        break;
    }

    $array_data   =     array('success'=>true,'data'=>$data);
    echo json_encode($array_data);
?>