
<?php

session_start();
 
    if(isset($_GET["logout"]) && $_GET["logout"] === "yes")
        {
            session_destroy();
            unset($_SESSION['user']);
            header('location: index.php');
        }

 
           
  

