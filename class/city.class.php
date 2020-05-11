<?php
final class City extends Connection
{
    public $id;
    public $id_country;
    public $name;
    public $format_code;
    public $date;

    function new_city($data_array)
    {
        if($this->test_connection())
        {
            
            $sql            =   "INSERT INTO cities (id_country,name,format_code) VALUES (:id_country, :name, :format_code)";
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

    function select_city($id_city = 0)
    {
        if($id_city == 0)
        {
            $sql        =   $this->obj_server->prepare("SELECT ci.name as name_city,co.name as name_country,ci.format_code, ci.date FROM countries co inner join cities ci on ci.id_country = co.id order by ci.date desc, ci.name asc");
            $sql->execute(); 
            $row        =    $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            $sql        =   $this->obj_server->prepare("SELECT ci.name as name_city,co.name as name_country,ci.format_code, ci.date FROM countries co inner join cities ci on ci.id_country = co.id where id =:id_city");
            $sql->bindValue(':id_city', $id_city); 
            $sql->execute(); 
            $row        =   $sql->fetchAll(PDO::FETCH_ASSOC);
        }
       

        return $row;
    }


    function select_country()
    {
        $sql        =   $this->obj_server->prepare("SELECT id, name FROM countries order by name asc");
        $sql->execute(); 
        $row        =    $sql->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
}