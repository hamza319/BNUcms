<?php

require_once './classes/student.php';
require_once './classes/faculty.php';
require_once './classes/mailbox.php';
session_start();

if (!isset($_SESSION["user"]))
{
    $id = isset($_POST["roll"])? $_POST["roll"] : "NULL";
    
    if($id !== "nothing")
    {
        if($id[0]=='f' || $id[0]=='s')
        {
            $student=new Student();

            $msg = $student->loadUser($id);

            if ($msg === "done") {

                $mailbox = new Mailbox($id);
                $mailbox->populate();

                $_SESSION["user"]=$student;
                $_SESSION['mailbox']=$mailbox;
                $_SESSION['mode']="student";

                echo json_encode($student->toJson());                       
            } 
            else
            {
                echo "querry failed";
            }
        }
        else
        {
            $faculty = new Faculty();
            
            $msg = $faculty->loadUser($id);

            if ($msg === "done") {

                $mailbox = new Mailbox($id);
                $mailbox->populate();

                $_SESSION["user"]=$faculty;
                $_SESSION['mailbox']=$mailbox;
                $_SESSION['mode']="faculty";

                echo json_encode($faculty->toJson());                       
            } 
            else
            {
                echo "querry failed";
            }
        }
    }
    else
    {
        echo "not logged-in";
    }
}
else
{
    $user=$_SESSION["user"];
    $mode=$_SESSION['mode'];
    
    if($mode === "faculty")
    {
        $id=$user->getId();
    }
    else
    {
        $id=$user->getRoll();
    }
    
    $mailbox = new Mailbox($id);
    $mailbox->populate();
    
    $_SESSION['mailbox']=$mailbox;
    
    echo json_encode($user->toJson());
}