<?php
class Database
{
    private $mysqli;

    private $db_host = "127.0.0.1";
    private $db_user = "register";
    private $db_pass = "159753";
    private $db_database = "registration";

    public function __construct()
    {
       $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_database);
       if($this->mysqli->connect_error){
         printf("Nastala chyba pripojenia s hláškou: %s a správou: %s", $this->mysqli->connect_errno,$this->mysqli->connect_error);
         die();

       }
    }

    public function __destruct()
    {
        $this->mysqli->close();
    }


    public function getLink()
    {
        return $this->mysqli;
    }

}





?>