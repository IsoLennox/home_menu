<?php 
//define("DB_SERVER","pdxlsqla1.entercomcolo.local");
//define("DB_USER","ilennox");
//define("DB_PASS","3ntErc0m1");
//define("DB_NAME","Portland_KB");

define("DB_SERVER","localhost");
define("DB_USER","root");
define("DB_PASS","");
define("DB_NAME","home_menu");


$connection= mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
//test iff connection occured
if(mysqli_connect_error()){
    die("Database connection failed: ".mysqli_connect_error()." (".mysqli_errno() .")"
       );
}else{ //echo "connected!";
     } //end test connection
//END CREATE CONNECTION
?>