<?php
    require('../config/db.conf.php');
    require('../class/connection.class.php');
    require('../class/contacts_groups.class.php');
    require('../class/group.class.php');
    $obj_cont_group     =       new ContactsGroups();
    $obj_group          =       new Group();

    $option       =     isset($_REQUEST['opt']) ? $_REQUEST['opt'] : 1;

    switch($option)
    {
        case 1://return list of added contacts in the group
            $id_group        =   isset($_REQUEST['id_group']) ? trim($_REQUEST['id_group']) : 0;
            $data            =   $obj_cont_group->select_contact_in_group($id_group);
        break;

        case 2://retunr list of contacts are not in the group
            $id_group        =   isset($_REQUEST['id_group']) ? trim($_REQUEST['id_group']) : 0;
            $data            =   $obj_cont_group->select_contact_not_group($id_group);
        break;

        case 3: 
            $data = array(
                'id_contact'                => trim($_REQUEST['id_contact']),
                'id_group'                  => trim($_REQUEST['id_group']),
                'inherited'                 => isset($_REQUEST['inherited']) ? trim($_REQUEST['inherited']) : 0,
                'idcontgrpexi'              => isset($_REQUEST['idcontgrpexi']) ? trim($_REQUEST['idcontgrpexi']) : 0
            );
            $data               =   $obj_cont_group->new_contact_group($data);
        break;

        case 4: 
            $data = array(
                'id_contact_group'                => trim($_REQUEST['id_cont_group'])
            );
            $data               =   $obj_cont_group->delete_contact_inherited($data);
        break;

        case 5:
            $id_group        =   isset($_REQUEST['id_group']) ? trim($_REQUEST['id_group']) : 0;
            $data            =   $obj_group->select_group_distinct($id_group);
        break;

        case 6:
            $id_group        =   isset($_REQUEST['id_group']) ? trim($_REQUEST['id_group']) : 0;
            $data            =   $obj_group->select_group($id_group);
        break;

        case 7:
            $id_group_current        =   isset($_REQUEST['id_group_current']) ? trim($_REQUEST['id_group_current']) : 0;
            $id_group_select         =   isset($_REQUEST['id_group_select']) ? trim($_REQUEST['id_group_select']) : 0;
            $data                    =   $obj_cont_group->select_contact_add_by_group($id_group_current,$id_group_select);
        break;

        case 8:
            $id_group_current        =   isset($_REQUEST['id_group_current']) ? trim($_REQUEST['id_group_current']) : 0;
            $data                    =   $obj_cont_group->select_contact_inherited_group($id_group_current);
        break;
    }

    $array_data   =     array('success'=>true,'data'=>$data);
    echo json_encode($array_data);
?>