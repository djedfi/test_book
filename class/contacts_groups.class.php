<?php
/**
 * TEST CASE 2
 * 
 * CLASS CONTACTS_GROUP
 *
 * This class contains everything related to contacts and groups
 *
 * @author EdFi
 * @copyright (c) 2020
 *
 */
final class ContactsGroups extends Connection
{

    /**
    * select_contact_not_group: This class select all contacts are not in the group selected by the user
    * @param  integer $id_group: value of the id the group selected
    * @return array with the following elements:
    *               id_contact: value unique of the contact
    *               last_name: last name of the contact
    *               first_name: first name of the contact
    *               email: email of the contact    
    *               name_city: name of the city where lives the contact
    */
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

    /**
    * select_contact_not_group: This class select all contacts are  in the group selected by the user
    * @param  integer $id_group: value of the id the group selected
    * @return array with the following elements:
    *               id_contact: value unique of the contact
    *               id_contact_group: value unique of the table contacts_groups, where the contact and group relationship is saved
    *               last_name: last name of the contact
    *               first_name: first name of the contact
    *               email: email of the contact    
    *               name_city: name of the city where lives the contact
    */
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

    /**
    * Insert new record in the table contacts_groups, if the contact is inherited from other group it will insert a new record in the table: contacts_groups_inherited too.
    * @param  array $data_array Array with the different values to add new record:
    *               id_contact: value unique of the contact
    *               id_group: value unique of the group
    *               inherited: if the value is true or 1, it will add a record in the table contacts_groups_inherited
    *               idcontgrpexi: this value represents the parent in the record of the table contacts_groups_inherited
    * @return boolean If the value is true, the record was added successfully
    */
    function new_contact_group($data_array)
    {
        if($this->test_connection())
        {
            $this->obj_server->beginTransaction();

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
                $this->obj_server->commit();
                return true;
            }
            else
            {
                $this->obj_server->rollBack();
                return false;
            }

        }
        else
        {
            $this->obj_server->rollBack();
            return false;
        }
    }

    
    /**
    * THIS FUNCTION RETURNS THE CONTACTS THAT HAVE A SELECTED GROUP AND THAT IT IS POSSIBLE TO ADD THEM TO THE GROUP THAT IS DISPLAYED. 
    * THIS FUNCTION WORKS TO ADD  A NEW CONTACT IN THE GROUP INHERITED FROM OTHER GROUP
    * @param  integer $idgroup_current: value of the group displayed
    * @param  integer $id_group_sel: value of the id the group selected to know what contacts they could be added to the group displayed
    * @return array with the following elements:
    *               id_contact: value unique of the contact
    *               id_contact_group: value unique of the table contacts_groups, where the contact and group relationship is saved
    *               last_name: last name of the contact
    *               first_name: first name of the contact
    *               email: email of the contact    
    *               flag_exist: if the value is different from null it could be added to the group
    */
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

    /**
    * THIS FUNCTION WILL RETURN THE CONTACTS BELONGING TO THE GROUP BUT THEY WERE INHERITED FROM ANOTHER GROUP
    * @param  integer $idgroup_current: value of the group displayed
    * @return array with the following elements:
    *               id_contact_group_parent 
    *               id_contact_group_child
    *               name_contact
    *               email_contact
    *               name_group_parent
    */
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


    /**
    * THIS FUNCTION WILL CONSULT THE INFORMATION OF THE FATHER GROUP, THROUGH THE ID OF THE TABLE CONTACTS_GROUPS
    * @param  integer $id_contacts_groups
    * @return array with the following elements:
    *               id: value unique of the contact
    *               name: name of the group
    */
    function select_check_group_parent($id_contacts_groups)
    {
        $sql        =   $this->obj_server->prepare("SELECT gp.id,gp.name FROM contacts_groups cg inner join groups gp on gp.id = cg.id_group where cg.id =:id_contacts_groups LIMIT 1");
        $sql->bindValue(':id_contacts_groups', $id_contacts_groups);

        $sql->execute(); 
        $data        =    $sql->fetchAll(PDO::FETCH_ASSOC);

        return $data[0]['name'];
    }


    /**
    * This function will delete all the contacts added directly to the group and their children and their children's children.
    * @param  array $data_array Array with the different values to delete:
    *               id_contact_group: value unique of the table contacts_groups
    * @return boolean If the value is true, the record was DELETED successfully
    */
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

    //This function allows knowing the child nodes starting from the parent node.
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

    // This function checks if the parent node has children
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