<?php
    require('../config/db.conf.php');
    require('../class/connection.class.php');
    require('../class/addressbook.class.php');
    $obj_addrbook     =     new Addressbook();

    $option       =     isset($_REQUEST['opt']) ? $_REQUEST['opt'] : 1;

    switch($option)
    {
        case 1:
            $id_addrbook        =   isset($_REQUEST['id']) ? trim($_REQUEST['id']) : 0;
            $tag                =   isset($_REQUEST['tag']) ? trim($_REQUEST['tag']) : '';
            $data               =   $obj_addrbook->select_addrbook($id_addrbook,$tag);
        break;

        case 2:
            $data               =   $obj_addrbook->select_city();
        break;

        case 3:
            $data               =   $obj_addrbook->select_pattern_city($_REQUEST['id_city']);
        break;

        case 4:
            $data = array(
                'id_city'               => $_REQUEST['id_sel_city'],
                'last_name'             => strtoupper(trim($_REQUEST['id_txt_lname'])),
                'first_name'            => strtoupper(trim($_REQUEST['id_txt_fname'])),
                'email'                 => trim($_REQUEST['id_txt_email']),
                'street'                => trim($_REQUEST['id_txta_street']),
                'zipcode'               => strtoupper(trim($_REQUEST['id_txt_zip'])),
                'tags'                  => strtolower(trim($_REQUEST['id_txt_tags']))
            );
            $data               =   $obj_addrbook->new_addbook($data);
        break;
        case 5:
            $data = array(
                'id_city'               => $_REQUEST['id_sel_city'],
                'last_name'             => strtoupper(trim($_REQUEST['id_txt_lname'])),
                'first_name'            => strtoupper(trim($_REQUEST['id_txt_fname'])),
                'email'                 => trim($_REQUEST['id_txt_email']),
                'street'                => trim($_REQUEST['id_txta_street']),
                'zipcode'               => strtoupper(trim($_REQUEST['id_txt_zip'])),
                'tags'                  => strtolower(trim($_REQUEST['id_txt_tags'])),
                'id'                    => $_REQUEST['id']
            );
            $data               =   $obj_addrbook->updaddbook($data);
        break;

        case 6:
            $data               =   $obj_addrbook->get_tags_distinct();
        break;
    }

    $array_data   =     array('success'=>true,'data'=>$data);
    echo json_encode($array_data);
?>