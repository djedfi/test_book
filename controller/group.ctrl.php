<?php
    require('../config/db.conf.php');
    require('../class/connection.class.php');
    require('../class/group.class.php');
    $obj_group     =     new Group();

    $option       =     isset($_REQUEST['opt']) ? $_REQUEST['opt'] : 1;

    switch($option)
    {
        case 1://return list of Groups
            $id_group        =   isset($_REQUEST['id']) ? trim($_REQUEST['id']) : 0;
            $data            =   $obj_group->select_group($id_group);
        break;

        case 2:
            $data = array(
                'name'          => strtoupper(trim($_REQUEST['id_txt_name'])),
                'description'   => strtoupper(trim($_REQUEST['id_txta_desc']))
            );
            $data           =   $obj_group->new_group($data);
        break;
    }

    $array_data   =     array('success'=>true,'data'=>$data);
    echo json_encode($array_data);
?>