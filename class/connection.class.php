<?php
/**
 * TEST CASE 2
 *
 * CLASS CONNECTION
 * 
 * This class has different function to connect with the database<br>
 * It needs parameter as name of server, name of database, user and password. These information are in the configuration file. 
 *
 * @author EdFi
 * @copyright (c) 2020
 *
 */
class Connection
{
    private     $server     =   '';
    private     $db         =   '';
    private     $user       =   '';
    private     $pass       =   '';
    public      $obj_server;
    public      $flag_connection= FALSE;



    function __construct()
    {
        $this->server       =   SERVER_DB;
        $this->db           =   DB;
        $this->user         =   USER_DB;
        $this->pass         =   PASS_DB;

        try 
        {
            $this->obj_server   =   new PDO('mysql:host='.$this->server.';dbname='.$this->db.'', $this->user,$this->pass);
            $this->obj_server->exec('SET CHARACTER SET utf8');
        }
        catch (PDOException $e) 
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
        
    }

    function __destruct()
    {
        $this->obj_server   =   NULL;
    }


    function test_connection()
    {
        if($this->obj_server)
        {
            $this->flag_connection    =   TRUE;
            
        }
        
        return $this->flag_connection;
    }

}

?>