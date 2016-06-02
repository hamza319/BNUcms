<?php

$connection = new mysqli('localhost','root','unlock319','cmrs');

$desc = isset($_POST['des'])? $_POST["des"] : NULL;

if($connection->connect_error) 
    die($connection->connect_error);

$query = "INSERT INTO `announcements` (`Description`, `ID`) VALUES ('$desc', NULL);";

$result = $connection->query($query);

if (!$result)
{
    echo "INSERT failed: $query<br>";
}
else
{
    echo "done";
}