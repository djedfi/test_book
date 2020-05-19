<?php
/**
 * TEST CASE 2
 * 
 * CLASS GROUP
 *
 * This class has functions to add a group in the database
 *
 * @author EdFi
 * @copyright (c) 2020
 *
 */
final class Group extends Connection
{
    public $id;
    public $name;
    public $description;
    public $date;

    /**
    * Add a new record in the table: Group
    * @param  array $data_array Array with the different values to add new record:
    *               name: name of the group
    *               description: description of the group
    * @return boolean If the value is true, the record was added successfully
    */
    function new_group($data_array)
    {
        if($this->test_connection())
        {
            
            $sql            =   "INSERT INTO groups (name,description) VALUES (:name, :description)";
            $exe_sql        =   $this->obj_server->prepare($sql);
            $exe_sql->execute($data_array);

            if($exe_sql)
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
    /**
    * Select groups in the table: groups
    * @param  integer $id_group, if the value is 0 it will show all records else it will one specific record 
    * @return array with the following elements:
    *               id: primary key of the tabla groups
    *               name: name of the groups
    *               description: description of the country
    *               date, value when it was added
    */

    function select_group($id_group = 0)
    {
        if($id_group == 0)
        {
            $sql        =   $this->obj_server->prepare("SELECT id,name,description,date,(select count(*) from contacts_groups where id_group = groups.id) as total_contacts FROM groups order by date desc");
            $sql->execute(); 
            $row        =    $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            $sql        =   $this->obj_server->prepare("SELECT id,name,description,date FROM groups where id = :id order by date desc");
            $sql->bindValue(':id', $id_group); 
            $sql->execute(); 
            $row        =   $sql->fetchAll(PDO::FETCH_ASSOC);
        }
       

        return $row;
    }

    /**
    * Select different groups that is different from the group that is sent as parameter
    * @param  integer $id_group, this id will not select 
    * @return array with the following elements:
    *               id: primary key of the tabla groups
    *               name: name of the groups
    *               description: description of the country
    *               date, value when it was added
    */
    function select_group_distinct($id_group = 0)
    {
            $sql        =   $this->obj_server->prepare("SELECT id,name,description,date FROM groups where id != :id order by date desc");
            $sql->bindValue(':id', $id_group); 
            $sql->execute(); 
            $row        =   $sql->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }
}