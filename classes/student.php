<?php

require_once 'user.php';

class Student extends User{
    private $rollNum;
    private $Dept;
    
    function __construct() {
        
        parent::__construct();
        $this->rollNum="";
        $this->Dept="";
    }
    
    function getRoll()
    {
        return $this->rollNum;
    }
    
    function setRoll($r)
    {
        $this->rollNum=$r;
    }
    
    function  setDept($d)
    {
        $this->Dept=$d;
    }
    
    function  getDept()
    {
        return $this->Dept;
    }
    
    function addUser() {
        $connection = new mysqli('localhost','root','unlock319','cmrs');
 
        if($connection->connect_error) 
            die($connection->connect_error);
        
        $query="INSERT INTO `student` (`Name`, `RollNum`, `Program`, `Question`, `Answer`, `Active_flg`, `Password`) VALUES ('".$this->name."', '".$this->rollNum."', '".$this->Dept."', '".$this->question."', '.".$this->ans."', '1', '".$this->password."')";
        $result = $connection->query($query);
        
        if (!$result)
        {
               return "INSERT failed: $query<br>";
        }
           else 
        {
               return "Entry successful";
        }
    }
    
    function loadUser($roll) {
        $connection = new mysqli('localhost','root','unlock319','cmrs');
 
        if($connection->connect_error) 
            die($connection->connect_error);
        
        $query="SELECT * FROM `student` WHERE `RollNum` = '".$roll."'";
        
        $result = $connection->query($query);
        //$rows=$result->num_rows;
        
        if($result->num_rows ===0)
        {
            return $result;            
        }   
        else
        {
            $result->data_seek(0);
        
            $data = $result->fetch_array(MYSQLI_ASSOC);

            $this->name=$data['Name'];
            $this->Dept=$data['Program'];
            $this->rollNum=$data['RollNum'];
            $this->question=$data['Question'];
            $this->ans=$data['Answer'];
            $this->password=$data['Password'];
            
            return "done";
        
        }
    }
    
    public function toJson() {
    return get_object_vars($this);
}
    
}