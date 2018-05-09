<?php

  $realname=$_POST['nombre'];
  $apellido=$_POST['apellido'];
  $mail=$_POST['demo-email'];
  $pass= $_POST['password'];
  //$rpass=$_POST['rpass'];*/
  

  require("conexiondb.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
  $checkemail=mysqli_query($mysqli,"SELECT * FROM login WHERE user='$mail'");
  $check_mail=mysqli_num_rows($checkemail);
    //if($pass==$pass){ 
      if($check_mail>0){
        echo ' <script language="javascript">alert("Atencion, ya existe el mail designado para un usuario, verifique sus datos");</script> ';
      }else{
        
        require("conexiondb.php");
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
        mysqli_query($mysqli,"INSERT INTO login (`id`,`nombre`, `apellido`, `user`, `password`, `passadmin`, `rol`,`estado`) VALUES(NULL,'$realname', '$apellido', '$mail','',md5('$pass'),'2','1')");
        echo 'Se ha registrado con exito';
        echo ' <script language="javascript">alert("Usuario registrado con éxito");</script> ';
        
      }
    //  }
   /* }*/   /*else{
      echo 'Las contraseñas son incorrectas';
    }*/

  
?>