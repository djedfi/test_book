<?php
final class ContactsGroups extends Connection
{
    function select_contact_not_group($id_group)
    {
        $sql        =   $this->obj_server->prepare("select addb.id as id_contact,addb.last_name,addb.first_name,addb.email,cit.name as name_city
        from address_book addb 
        inner join cities cit on cit.id = addb.id_city
        where addb.id not in (select id_contact from contacts_groups where id_group =:id_group)");
        $sql->bindValue(':id_group', $id_group);
        $sql->execute(); 
        $row        =    $sql->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    function select_contact_in_group($id_group)
    {
        $sql        =   $this->obj_server->prepare("select addb.id as id_contact,cgr.id as id_contact_group,addb.last_name,addb.first_name,addb.email,cit.name as name_city
        from address_book addb 
        inner join cities cit on cit.id = addb.id_city
        inner join contacts_groups cgr on cgr.id_contact = addb.id
        where cgr.id_group =:id_group and cgr.inherited = 0");
        $sql->bindValue(':id_group', $id_group);
        $sql->execute(); 
        $row        =    $sql->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    function new_contact_group($data_array)
    {
        if($this->test_connection())
        {
            
            $sql            =   "INSERT INTO contacts_groups (id_contact,id_group,inherited)";
            $sql            .=  "VALUES (:id_contact, :id_group, :inherited)";
            $pre_sql        =   $this->obj_server->prepare($sql);
            $pre_sql->bindParam(':id_contact',$data_array['id_contact'],PDO::PARAM_INT);
            $pre_sql->bindParam(':id_group',$data_array['id_group'],PDO::PARAM_INT);
            $pre_sql->bindParam(':inherited',$data_array['inherited'],PDO::PARAM_INT);
            $pre_sql->execute();

            $id_new_contacts_group = $this->obj_server->lastInsertId();

            if($data_array['inherited'] == 1)
            {
                $sql2            =   "INSERT INTO contacts_groups_inherited (id_contact_group_parent,id_contact_group_child)";
                $sql2            .=  "VALUES (:id_contact_group_parent,:id_contact_group_child)";
                $pre_sql2        =   $this->obj_server->prepare($sql2);
                $pre_sql2->bindParam(':id_contact_group_parent',$data_array['idcontgrpexi'],PDO::PARAM_INT);
                $pre_sql2->bindParam(':id_contact_group_child',$id_new_contacts_group,PDO::PARAM_INT);
                $pre_sql2->execute();
            }

            if($pre_sql->rowCount() > 0)
            {
               return true;
            }
            else
            {
                return false;
            }

        }
        else
        {
            return false;
        }
    }

    //ESTA FUNCION RETORNARA LOS CONTACTOS QUE SE POSEE UN GRUPO SELECCIONADO Y QUE SEA POSIBLE AGREGARLOS AL GRUPO QUE SE MUESTRA EN PANTALLA.
    function select_contact_add_by_group($idgroup_current,$id_group_sel)
    {
        $sql        =   $this->obj_server->prepare("select addb.id as id_contact,cgr.id as id_contact_group,addb.last_name,addb.first_name,addb.email,
        (select id_contact from contacts_groups where id_group =:idgroup_current  and id_contact = addb.id)  as flag_exist
        from address_book addb 
        inner join contacts_groups cgr on cgr.id_contact = addb.id 
        where cgr.id_group =:id_group_sel");
        $sql->bindValue(':idgroup_current', $idgroup_current);
        $sql->bindValue(':id_group_sel', $id_group_sel);
        $sql->execute(); 
        $row        =    $sql->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    //ESTA FUNCION MOSTRAR LOS CONTACTOS HEREDADOS DEL GRUPO QUE SE MUESTRA EN PANTALLA
    function select_contact_inherited_group($id_group)
    {
        $sql        =   $this->obj_server->prepare("SELECT cg.id,cg.id_contact,cgi.id_contact_group_parent as id_group_parent,
        cgi.id_contact_group_child as id_contact_group_child, con.last_name,con.first_name,con.email 
        from contacts_groups cg 
        inner join contacts_groups_inherited cgi on cgi.id_contact_group_child = cg.id 
        inner join address_book con on con.id = cg.id_contact where cg.id_group =:idgroup_current and cg.inherited = 1");
        $sql->bindValue(':idgroup_current', $id_group);

        $sql->execute(); 
        $data               =    $sql->fetchAll(PDO::FETCH_ASSOC);
        $colect_array       =    array();
        $colect_array_total =    array();
        foreach ($data as $row) 
        {
            $colect_array   =   array(
                                    'id_contact_group_parent'=> $row['id_group_parent'],
                                    'id_contact_group_child'=> $row['id_contact_group_child'],
                                    'name_contact'=> $row['first_name'].' '.$row['last_name'],
                                    'email_contact'=> $row['email'],
                                    'name_group_parent' => $this->select_check_group_parent($row['id_group_parent'])
                                );
            array_push($colect_array_total,$colect_array);
        }

        return $colect_array_total;
    }

    //ESTA FUNCION CONSULTARA LA INFORMACION DEL GRUPO PADRE, MEDIANTE EL ID DE LA TABLA CONTACTS_GROUPS
    function select_check_group_parent($id_contacts_groups)
    {
        $sql        =   $this->obj_server->prepare("SELECT gp.id,gp.name FROM contacts_groups cg inner join groups gp on gp.id = cg.id_group where cg.id =:id_contacts_groups");
        $sql->bindValue(':id_contacts_groups', $id_contacts_groups);

        $sql->execute(); 
        $data        =    $sql->fetchAll(PDO::FETCH_ASSOC);

        return $data[0]['name'];
    }


    //esta funcion eliminara todos los contactos agregados directamente al grupo y sus hijos e los hijos de sus hijos.
    function delete_contact_inherited($data_array)
    {
        $string_where       = '';

        if($this->test_connection())
        {
            try 
            {
                $this->obj_server->beginTransaction();

                $array_child_to_delete  =  $this->array_nodes_to_delete($data_array['id_contact_group']);
                
                foreach($array_child_to_delete as $node)
                {
                    $string_where .= "'".$node."',";
                }
                
                $string_where                   =   rtrim($string_where,',');
                $delete_child_contac_group      =   $this->obj_server->prepare("DELETE FROM contacts_groups WHERE id IN (".$string_where.")");
                $delete_child_contac_group->execute();

                if($delete_child_contac_group->rowCount() > 0)
                {
                    $this->obj_server->commit();
                    return true;
                }
                else
                {
                    $this->obj_server->rollBack();
                    return false;
                }
            }
            catch (Exception $e) 
            {
                $this->obj_server->rollBack();
                echo $e->getMessage();
            } 
        }
        else
        {
            return 'error';
        }
    }
    //esta funcion permitira saber los nodos hijos partiendo del nodo padre.
    function array_nodes_to_delete($id_parent)
    {
        $array_data_pares   =   array();
        
        if($this->check_child_relation($id_parent))
        {
            $flag_child = true;
        }
        else
        {
            $flag_child = false;
            
        }
        array_push($array_data_pares,$id_parent);
        

        
        while($flag_child)
        {
            $sql_rec        =   $this->obj_server->query("SELECT id_contact_group_child FROM contacts_groups_inherited where id_contact_group_parent =".$id_parent);
            $row            =   $sql_rec->fetch(PDO::FETCH_ASSOC);

            if($this->check_child_relation($row['id_contact_group_child']))
            {
                $flag_child = true;
            }
            else
            {
                $flag_child = false;
                
            }
            $id_parent = $row['id_contact_group_child'];
            array_push($array_data_pares,$id_parent);
        }

        return $array_data_pares;
    }

    function check_child_relation($id_parent)
    {
        $sql        =   $this->obj_server->query("SELECT id_contact_group_child FROM contacts_groups_inherited where id_contact_group_parent =".$id_parent);
        if($sql->rowCount() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

?>