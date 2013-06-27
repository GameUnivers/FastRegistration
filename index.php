<?php session_start();
     if(isset($_POST['register'])){
       require_once("class/class_register.php");

       $db = new Database();
       $register = new Register($db);


       if($register->process())
            echo "Úspešne zaregistrovaný";
       else
            $register->show_errors();
     }
     $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));
?>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
   <table>
        <tr>
            <td><label for="uname">Meno:</label></td>
            <td><input type="text" id="uname" name="uname" /></td>
        </tr>
        <tr>
            <td><label for="upass">Heslo:</label></td>
            <td><input type="password" id="upass" name="upass" /></td>
        </tr>

        <tr>
            <td><label for="umail">E-Mail:</label></td>
            <td><input type="text" id="umail" name="umail" /></td>
        </tr>
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <tr><td><input type="submit" name="register" value="Registrovať" /></td></tr>
   </table>

</form>