<?php

require_once 'user.php';

class Faculty extends User{
    
    private $Id;
    private $Dept;
    
    public function __construct() {
        parent::__construct();
        $this->Id="";
        $this->Dept-="hello";
    }
    
    public function getId() {
        return $this->Id;
    }

    public function getDept() {
        return $this->Dept;
    }

    public function setId($Id) {
        $this->Id = $Id;
    }

    public function setDept($Dept) {
        $this->Dept = $Dept;
    }

    public function addUser() {
        $connection = new mysqli('localhost','root','unlock319','cmrs');
 
        if($connection->connect_error) 
            die($connection->connect_error);
        
        $query="INSERT INTO `faculty` (`Name`, `Faculty_ID`, `Department`, `Question`, `Answer`, `Active_flg`, `Password`) VALUES ('".$this->name."', '".$this->Id."', '".$this->Dept."', '".$this->question."', '.".$this->ans."', '1', '".$this->password."')";
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

    public function loadUser($id) {
    $connection = new mysqli('localhost','root','unlock319','cmrs');
 
        if($connection->connect_error) 
            die($connection->connect_error);
        
        $query="SELECT * FROM `faculty` WHERE `Faculty_ID` = '".$id."'";
        
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
            $this->Dept=$data['Department'];
            $this->Id=$data['Faculty_ID'];
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