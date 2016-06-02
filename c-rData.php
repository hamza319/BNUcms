<?php
require_once './classes/student.php';
require_once './classes/faculty.php';
require_once './classes/C-R.php';
session_start();

$user=$_SESSION['user'];
$mode=$_SESSION['mode'];


if(isset($_GET['resp']))
{
    $connection = new mysqli('localhost','root','unlock319','cmrs');
 
        if($connection->connect_error) 
            die($connection->connect_error);
        
        $query = "SELECT `Faculty_ID` FROM `faculty`";
        
         $result = $connection->query($query);
         $rows=$result->num_rows;
         
            $options = "<option disabled selected hidden>Select Rcipient</option>";
          for ($i=0; $i<$rows; $i++)
          {
               $result->data_seek($i);
                $data = $result->fetch_array(MYSQLI_ASSOC);
                $options.="<option>".$data['Faculty_ID']."</option>";
                
          }
          echo $options;
}
else
{
$type = isset($_POST["cat"])? $_POST["cat"] : NULL;
$recipient = isset($_POST["resp"])? $_POST["resp"] : NULL;
$subj = isset($_POST["sub"])? $_POST["sub"] : NULL;
$des = isset($_POST["des"])? $_POST["des"] : NULL;
$ath = isset($_POST["ath"])? $_POST["ath"] : NULL;

if($mode === "student")
{
$cr = new cr($des,$type,$user->getRoll(),$subj);
}
else
{
$cr = new cr($des,$type,$user->getId(),$subj);
}

$cr->setRecpt($recipient);
$cr->setAtt($ath);

echo  $cr->sendReq();
}