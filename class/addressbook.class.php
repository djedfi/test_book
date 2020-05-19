<?php
/**
 * TEST CASE 2
 * 
 * CLASS Addressbook
 *
 * This class has functions to add or update a contact in the table address_book
 *
 * @author EdFi
 * @copyright (c) 2020
 *
 */
final class Addressbook extends Connection
{
    public $id;
    public $id_city;
    public $last_name;
    public $first_name;
    public $email;
    public $street;
    public $zipcode;
    public $tags;
    public $date;

    /**
    * Add a new record in the table: address_book
    * @param  array $data_array Array with the different values to add new record:
    *               id_city: code of the city where it is the contact
    *               last_name: last name of the contact
    *               first_name: first name of the contact
    *               email: email of the contact
    *               street: street of the contact
    *               zipcode: zipcode of the contact
    *               tags: tags of the contact
    * @return boolean If the value is true, the record was added successfully
    */
    function new_addbook($data_array)
    {
        if($this->test_connection())
        {
            
            $sql            =   "INSERT INTO address_book (id_city,last_name,first_name,email,street,zipcode, tags)";
            $sql            .=  "VALUES (:id_city, :last_name, :first_name, :email, :street, :zipcode, :tags)";
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
    * Update a new record in the table: address_book
    * @param  array $data_array Array with the different values to add new record:
    *               id_city: code of the city where it is the contact
    *               last_name: last name of the contact
    *               first_name: first name of the contact
    *               email: email of the contact
    *               street: street of the contact
    *               zipcode: zipcode of the contact
    *               tags: tags of the contact
    *               id: value of the contact will update
    * @return boolean If the value is true, the record was updated successfully
    */
    function updaddbook($data_array)
    {
        if($this->test_connection())
        {
            try 
            {
                $sql            =   "UPDATE address_book SET id_city=:id_city, last_name=:last_name, first_name=:first_name,";
                $sql            .=  "email=:email, street=:street, zipcode=:zipcode, tags=:tags where id=:id";
                
                $pre_sql        =   $this->obj_server->prepare($sql);
                $pre_sql->bindParam(':id_city',$data_array['id_city'],PDO::PARAM_INT);
                $pre_sql->bindParam(':last_name',$data_array['last_name'],PDO::PARAM_STR, 150);
                $pre_sql->bindParam(':first_name',$data_array['first_name'],PDO::PARAM_STR, 150);
                $pre_sql->bindParam(':email',$data_array['email'],PDO::PARAM_STR, 250);
                $pre_sql->bindParam(':street',$data_array['street'],PDO::PARAM_STR, 350);
                $pre_sql->bindParam(':zipcode',$data_array['zipcode'],PDO::PARAM_STR, 10);
                $pre_sql->bindParam(':tags',$data_array['tags'],PDO::PARAM_STR,500);
                $pre_sql->bindParam(':id',$data_array['id'],PDO::PARAM_INT);
                $pre_sql->execute();

                if($pre_sql->rowCount() > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception $e) 
            {
                echo $e->getMessage();
            } 
        }
        else
        {
            return 'error de bd';
        }
    }

    /**
    * Select contacts in the table: address_book
    * @param  integer $id, if the value is 0 it will show all records else it will one specific record 
    * @param  integer $tag, different tag values 
    * @return array with the following elements:
    *               id: primary key of the tabla address_book
    *               last_name: last name of the contact
    *               first_name: first name of the contact
    *               email: email of the contact
    *               zipcode: zip code of the contact
    *               date:  value when it was added the contact
    *               name_city: city name of the contact
    *               id_city: idcity of the contact
    *               street, street of the contact
    *               tags, tags of the contact
    */
    function select_addrbook($id = 0,$tag = '')
    {
        if($tag != '')
        {
            $sql        =   $this->obj_server->prepare("SELECT abo.id, abo.last_name, abo.first_name,abo.email,abo.zipcode,abo.date, cit.name as name_city, cit.id as id_city,abo.street, abo.tags FROM `address_book` abo inner join cities cit on cit.id = abo.id_city where abo.tags like ?");
            $sql->bindValue(1, "%$tag%"); 
            $sql->execute(); 
            $row        =   $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        elseif($id == 0)
        {
            $sql        =   $this->obj_server->prepare("SELECT abo.id, abo.last_name, abo.first_name,abo.email,abo.zipcode,abo.date, cit.name as name_city, cit.id as id_city,abo.street, abo.tags FROM `address_book` abo inner join cities cit on cit.id = abo.id_city order by abo.date desc, abo.last_name,abo.first_name asc");
            $sql->execute(); 
            $row        =    $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            $sql        =   $this->obj_server->prepare("SELECT abo.id, abo.last_name, abo.first_name,abo.email,abo.zipcode,abo.date, cit.name as name_city, cit.id as id_city,abo.street, abo.tags FROM `address_book` abo inner join cities cit on cit.id = abo.id_city where abo.id =:id_abo");
            $sql->bindValue(':id_abo', $id); 
            $sql->execute(); 
            $row        =   $sql->fetchAll(PDO::FETCH_ASSOC);
        }
       

        return $row;
    }

    /**
    * Select all the cities added in the database
    * @return array with the following cities:
    *               id: primary key of the tabla groups
    *               name: name of the city
    */
    function select_city()
    {
        $sql        =   $this->obj_server->prepare("SELECT id, name FROM cities order by name asc");
        $sql->execute(); 
        $row        =    $sql->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    /**
    * Select the format zip code of a specific  city
    * @param  integer $id, value of the city you want to know the zip code
    * @return array with the following elements:
    *               format_code: value of the format code the zip code
    */
    function select_pattern_city($id)
    {
        $sql        =   $this->obj_server->prepare("SELECT format_code FROM cities where id =:id_city");
        $sql->bindValue(':id_city', $id); 
        $sql->execute(); 
        $row        =   $sql->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    /**
    * This function will return all the tags addes in the table address_book, 
    * @return array with the following elements:
    *               tag: value of the tag, it will show once.
    */
    function get_tags_distinct()
    {

        //First, We need to get all tags added in the table address_book
        $sql        =   $this->obj_server->prepare("SELECT tags FROM address_book where tags != ''");
        $sql->execute(); 
        $row        =    $sql->fetchAll(PDO::FETCH_ASSOC);
        $pieces     =   array();
        $array_tag_f=   array();

        foreach($row as $data)
        {
            array_push($pieces,explode(",",$data['tags']));
        }


        foreach($pieces as $i_pieces)
        {
       
            foreach($i_pieces as $f_piece)
            {
                array_push($array_tag_f,trim($f_piece));
            }
        
        }

        return array_unique($array_tag_f);
    }
}