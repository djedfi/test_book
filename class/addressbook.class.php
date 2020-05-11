<?php
final class Addressbook extends Connection
{
    public $id;
    public $id_city;
    public $last_name;
    public $first_name;
    public $email;
    public $street;
    public $zipcode;
    public $date;

    function new_addbook($data_array)
    {
        if($this->test_connection())
        {
            
            $sql            =   "INSERT INTO address_book (id_city,last_name,first_name,email,street,zipcode)";
            $sql            .=  "VALUES (:id_city, :last_name, :first_name, :email, :street, :zipcode)";
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

    function updaddbook($data_array)
    {
        if($this->test_connection())
        {
            try 
            {
                $sql            =   "UPDATE address_book SET id_city=:id_city, last_name=:last_name, first_name=:first_name,";
                $sql            .=  "email=:email, street=:street, zipcode=:zipcode where id=:id";
                
                $pre_sql        =   $this->obj_server->prepare($sql);
                $pre_sql->bindParam(':id_city',$data_array['id_city'],PDO::PARAM_INT);
                $pre_sql->bindParam(':last_name',$data_array['last_name'],PDO::PARAM_STR, 150);
                $pre_sql->bindParam(':first_name',$data_array['first_name'],PDO::PARAM_STR, 150);
                $pre_sql->bindParam(':email',$data_array['email'],PDO::PARAM_STR, 250);
                $pre_sql->bindParam(':street',$data_array['street'],PDO::PARAM_STR, 350);
                $pre_sql->bindParam(':zipcode',$data_array['zipcode'],PDO::PARAM_STR, 10);
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


    function select_addrbook($id = 0)
    {
        if($id == 0)
        {
            $sql        =   $this->obj_server->prepare("SELECT abo.id, abo.last_name, abo.first_name,abo.email,abo.zipcode,abo.date, cit.name as name_city,cit.id as id_city ,abo.street FROM `address_book` abo inner join cities cit on cit.id = abo.id_city order by abo.date desc, abo.last_name,abo.first_name asc");
            $sql->execute(); 
            $row        =    $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            $sql        =   $this->obj_server->prepare("SELECT abo.id, abo.last_name, abo.first_name,abo.email,abo.zipcode,abo.date, cit.name as name_city, cit.id as id_city,abo.street FROM `address_book` abo inner join cities cit on cit.id = abo.id_city where abo.id =:id_abo");
            $sql->bindValue(':id_abo', $id); 
            $sql->execute(); 
            $row        =   $sql->fetchAll(PDO::FETCH_ASSOC);
        }
       

        return $row;
    }


    function select_city()
    {
        $sql        =   $this->obj_server->prepare("SELECT id, name FROM cities order by name asc");
        $sql->execute(); 
        $row        =    $sql->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    function select_pattern_city($id)
    {
        $sql        =   $this->obj_server->prepare("SELECT format_code FROM cities where id =:id_city");
        $sql->bindValue(':id_city', $id); 
        $sql->execute(); 
        $row        =   $sql->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }


    function get_pattern_zip_code($format_zip)
    {
        $tot            = strlen(trim($format_zip));
        $pattern_final  = '';

        for($i=0;$i<$tot;$i++)
        {
            if($format_zip{$i} == 'A')
            {
                $pattern_final .= '[a-zA-Z]{1}';
            }
            else
            {
                $pattern_final .= '[0-9]{1}';
            }
        }

        return $pattern_final;
    }
}