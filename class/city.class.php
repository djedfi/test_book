<?php
/**
 * TEST CASE 2
 * 
 * CLASS CITY
 *
 * This class has functions to add a city in the database
 *
 * @author EdFi
 * @copyright (c) 2020
 *
 */
final class City extends Connection
{
    public $id;
    public $id_country;
    public $name;
    public $format_code;
    public $date;

    /**
    * Add a new record in the table: cities
    * @param  array $data_array Array with the different values to add new record:
    *               id_country: Id of the country  what it belong the city
    *               name: name of the city
    *               format_code: value of the format the zip code
    * @return boolean If the value is true, the record was added successfully
    */
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

    /**
    * Select cities in the table: cities
    * @param  integer $id_city, if the value is 0 it will show all records else it will one specific record 
    * @return array with the following elements:
    *               name_city name of the city
    *               name_country name of the country
    *               format_code format of the zip code
    *               date, value when it was added
    */
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

    /**
    * Select countries in the table: countries
    * @param  
    * @return array with the following elements:
    *               id: primary key of the tabla countries
    *               name: name of country
    */
    function select_country()
    {
        $sql        =   $this->obj_server->prepare("SELECT id, name FROM countries order by name asc");
        $sql->execute(); 
        $row        =    $sql->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
}