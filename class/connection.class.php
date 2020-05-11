<?php
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