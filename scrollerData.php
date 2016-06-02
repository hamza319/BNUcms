<?php

$connection = new mysqli('localhost','root','unlock319','cmrs');

if($connection->connect_error) 
   die($connection->connect_error);

$query = "SELECT * FROM `announcements`";

$result = $connection->query($query);

$messages = array();

for ($i=0; $i<$result->num_rows;$i++)
{
    $result->data_seek($i);
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $messages[]=$data['Description'];
}

echo json_encode($messages);