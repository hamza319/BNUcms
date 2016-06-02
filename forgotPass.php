<?php

$connection = new mysqli('localhost','root','unlock319','cmrs');

if($connection->connect_error) 
   die($connection->connect_error);

$user= isset($_POST["user"])? $_POST["user"] : NULL;
$ans=isset($_POST["ans"])? $_POST["ans"] : NULL;

if(isset($_GET['setPass']))
{
    $pass=isset($_POST["pass"])? $_POST["pass"] : NULL;
    
    if($user[0]=='f' || $user[0]=='s')
    { 
        $query="UPDATE `student` SET `Password` = '$pass' WHERE `RollNum` = '$user'"; 
    }
    else
    {
        $query="UPDATE `faculty` SET `Password` = '$pass' WHERE `Faculty_ID` = '$user'"; 
    }
    
    $result = $connection->query($query);
        
        if (!$result)
        {
               echo "INSERT failed: $query<br>";
        }
           else 
        {
               echo "done";
        }
}
else if ($ans !== NULL)
{
    if($user[0]=='f' || $user[0]=='s')
    { 
        $query="SELECT * FROM `student` WHERE `RollNum` = '".$user."' AND `Answer` = '".$ans."'"; 
    }
    else
    {
        $query="SELECT * FROM `faculty` WHERE `Faculty_ID` = '".$user."' AND `Answer` = '".$ans."'"; 
    }
        $result = $connection->query($query);
        
        if ($result->num_rows ===0)
{
echo "not found";
}
else 
{
   
    echo "found";
}
        
}else if($user !== NULL and $ans===NULL)
{
    if($user[0]=='f' || $user[0]=='s')
    {
        $query="SELECT * FROM `student` WHERE `RollNum` = '".$user."'";
        $Qquery = "SELECT `Question` FROM `student` WHERE `RollNum` = '".$user."'";
    }
    else
    {
        $query="SELECT * FROM `faculty` WHERE `Faculty_ID` = '".$user."'";
        $Qquery="SELECT `Question` FROM `faculty` WHERE `Faculty_ID` = '".$user."'";
    }
    
 $result = $connection->query($query);
$Qresult = $connection->query($Qquery);

if ($result->num_rows ===0)
{
echo "not found";
}
else 
{
   $Qresult->data_seek(0);
   $data = $result->fetch_array(MYSQLI_ASSOC);
    echo $data['Question'];
}
    
}


