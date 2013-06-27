<?php
include "class_mysqli.php";

class Register
{
    private $username;
    private $password;
    private $passmd5;
    private $email;

    private $errors;
    private $token;

    private $link;

    public function __construct(Database $connection)
    {

        $this->link = $connection->getLink();   //Linking Connection to Other Instance

        $this->errors   =   array();
        $this->username =   $this->filter($_POST['uname']);
        $this->password =   $this->filter($_POST['upass']);
        $this->email    =   $this->filter($_POST['umail']);

        $this->token    =   $_POST['token'];

        $this->passmd5  =   md5($this->password);


    }

    public function process()
    {
      if($this->valid_token() && $this->valid_data())
        $this->register();

        return count($this->errors) ? 0 : 1;
    }

    public function filter($var)
    {
      return preg_replace('/[^a-zA-Z0-9@.]/','',$var);
    }

    public function user_exists()
    {
        $result = $this->link->query("SELECT ID FROM users WHERE username='$this->username'");
        return($result->num_rows > 0) ? 1 : 0;

    }
    public function register()
    {
       $result = $this->link->query("INSERT INTO users (username,password) VALUES ('$this->username', '$this->passmd5')");
        if($this->link->affected_rows < 1)
            $this->errors[] = 'Nemožno vytvoriť účet';
    }

    public function show_errors()
    {
        echo "<h3>Errors</h3>";
        foreach($this->errors as $key=>$value)
            echo $value.'<br>';

    }

    public function valid_data()
    {
        if($this->user_exists())
            $this->errors[] = 'Uživateľské meno je obsadené';
        if(empty($this->username))
            $this->errors[] = 'Nesprávne uživateľské meno';
        if(empty($this->password))
            $this->errors[] = 'Nesprávne uživateľské heslo';
        if(empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL))
            $this->errors[] = 'Nesprávny e-mail';

        return count($this->errors) ? 0 : 1;
    }

    public function valid_token()
    {
        if(!isset($_SESSION['token']) || $this->token != $_SESSION['token'])
            $this->errors[] = 'Nesprávna Relácia';

        return count($this->errors) ? 0 : 1;
    }

}


?>