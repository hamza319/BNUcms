<?php

$user= isset($_POST["user"])? $_POST["user"] : NULL;
$pass=isset($_POST["pass"])? $_POST["pass"] : NULL;

if ($pass !== NULL)
{
    if($user[0]=='f' || $user[0]=='s')
    { 
        $query="SELECT * FROM `student` WHERE `RollNum` = '".$user."' AND `Password` = '".$pass."'"; 
    }
    else
    {
        $query="SELECT * FROM `faculty` WHERE `Faculty_ID` = '".$user."' AND `Password` = '".$pass."'"; 
    }
        
}
 
if($user !== NULL and $pass===NULL)
{
    if($user[0]=='f' || $user[0]=='s')
    {
        $query="SELECT * FROM `student` WHERE `RollNum` = '".$user."'";
    }
    else
    {
        $query="SELECT * FROM `faculty` WHERE `Faculty_ID` = '".$user."'";
    }
}

$connection = new mysqli('localhost','root','unlock319','cmrs');

if($connection->connect_error) 
   die($connection->connect_error);

$result = $connection->query($query);

if ($result->num_rows ===0)
        {
               echo "not found";
        }
           else 
        {
               echo "found";
        }