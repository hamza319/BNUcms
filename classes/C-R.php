<?php

class cr
{
    protected $type,$decrpiton,$cat,$id,$roll,$subject,$response,$att,$date,$recpt;
    
    function __construct($decrpiton,$type,$roll,$subject) {
        $this->cat="";
        $this->type=$type;
        $this->decrpiton=$decrpiton;
        $this->id="";
        $this->roll=$roll;
        $this->subject=$subject;
        $this->response="";
        $this->att = NULL;
        $this->date=NULL;
        $this->recpt=NULL;
    }
    public function getRecpt() {
        return $this->recpt;
    }

    public function setRecpt($recpt) {
        $this->recpt = $recpt;
    }

        function getID()
    {
        return $this->id;
    }
    
    function setID($id)
    {
        $this->id=$id;
    }
            
    function sendReq()
    {            
        $connection = new mysqli('localhost','root','unlock319','cmrs');
 
        if($connection->connect_error) 
            die($connection->connect_error);
        
        $id = $this->roll;
        if($id[0] === "f" || $id[0]==="s")
        {
        $query="INSERT INTO `c/rs` (`Type`, `Description`, `subject`, `Attatchment`, `Category`, `ID`, `Date`, `stdt_fk`, `fclty_fk`, `recipient`) VALUES ('".$this->type."', '".$this->decrpiton."', '".$this->subject."',' ".$this->att."', '".$this->cat."', NULL , '".date('Y-m-d')."', '$this->roll', NULL, '$this->recpt');";
        }
        else 
        {
            $query="INSERT INTO `c/rs` (`Type`, `Description`, `subject`, `Attatchment`, `Category`, `ID`, `Date`, `stdt_fk`, `fclty_fk`, `recipient`) VALUES ('".$this->type."', '".$this->decrpiton."', '".$this->subject."',' ".$this->att."', '".$this->cat."', NULL , '".date('Y-m-d')."', NULL, '$this->roll', '$this->recpt');";
        }
        
        $result = $connection->query($query);
        
        if (!$result)
        {
               return "INSERT failed: $query<br>";
        }
           else 
        {        
            $this->populate();
            //echo $this->id;
            $ans = $this->inputToMailbox($connection);
            $connection->close();
            if($ans === "done")
            {
            return "Entry successful";
            }
            else
            {
               return $ans;
            }
        }
    }
    
    function inputToMailbox($connection)
    {
        $id = $this->roll;
        if($id[0] === "f" || $id[0]==="s") //if student sends
        {
            $recipientQuery= "INSERT INTO `mailbox` (`type_flag`, `Student_fk`, `Faculty_fk`, `C/R_fk`) VALUES ('2', NULL, '$this->recpt', '$this->id');";
            $senderQuery= "INSERT INTO `mailbox` (`type_flag`, `Student_fk`, `Faculty_fk`, `C/R_fk`) VALUES ('1', '$this->roll', NULL, '$this->id');";
        }
        else //if faculty sends
        {   
            $senderQuery= "INSERT INTO `mailbox` (`type_flag`, `Student_fk`, `Faculty_fk`, `C/R_fk`) VALUES ('1', NULL,'$this->roll',  '$this->id');";
            $recipientQuery= "INSERT INTO `mailbox` (`type_flag`, `Student_fk`, `Faculty_fk`, `C/R_fk`) VALUES ('2', NULL, '$this->recpt', '$this->id');";
        }
        
        $resultSender = $connection->query($senderQuery);
        $resultRecipient = $connection->query($recipientQuery);
        
        if (!$resultSender)
        { 
               return "INSERT Sender failed: $senderQuery<br>";
        }
        if (!$resultRecipient)
        {
               return "INSERT resp failed: $recipientQuery<br>";
        }
        
        return "done";
        
    }
    
    function populate()
    {   
         $connection = new mysqli('localhost','root','unlock319','cmrs');
 
        if($connection->connect_error) 
            die($connection->connect_error);
        
        if($this->type !== "" && $this->decrpiton!=="" && $this->roll !== "")  //19-may-16
        {
            $id = $this->roll;
            if($id[0] === "f" || $id[0]==="s")
            {
                $query="SELECT * FROM `c/rs` WHERE `Type` = '$this->type' AND `Description` = '$this->decrpiton' AND `stdt_fk` = '$this->roll'";
            }
            else
            {
                $query="SELECT * FROM `c/rs` WHERE `Type` = '$this->type' AND `Description` = '$this->decrpiton' AND `fclty_fk` = '$this->roll'";
            }
        }
        
        $result = $connection->query($query);
        
        if($result->num_rows ===0)
        {   
            return $query;            
        }   
        else
        {
            $result->data_seek(0);
        
            $data = $result->fetch_array(MYSQLI_ASSOC);

            $this->type=$data['Type'];
            $this->decrpiton=$data['Description'];
            $this->id=$data['ID'];
            $this->att=['Attatchment'];
            $this->cat=$data['Category'];
            $this->date=$data['Date'];
            $this->recpt=$data['recipient'];
            
            $rspQuery= 'SELECT * FROM `response` WHERE `C/R_fk` = '.$this->id;
            $result = $connection->query($rspQuery);
           
            if($result)
            {
            $result->data_seek(0);
            $dataR = $result->fetch_array(MYSQLI_ASSOC);
            $this->response=$dataR['Description'];
            }
            
            $stdnt = $data['stdt_fk'];
            $fclty = $data['fclty_fk'];
            
            if($stdnt != "")
            {
                $this->roll=$stdnt;
            }
            else
            {
                $this->roll=$fclty;
            }
        
        }
       
    }
    
    public function getType() {
        return $this->type;
    }

    public function getDecrpiton() {
        return $this->decrpiton;
    }

    public function getCat() {
        return $this->cat;
    }

    public function getRoll() {
        return $this->roll;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getResponse() {
        return $this->response;
    }

    public function getAtt() {
        return $this->att;
    }

    public function getDate() {
        return $this->date;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setDecrpiton($decrpiton) {
        $this->decrpiton = $decrpiton;
    }

    public function setCat($cat) {
        $this->cat = $cat;
    }

    public function setRoll($roll) {
        $this->roll = $roll;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function setResponse($response) {
        $this->response = $response;
    }

    public function setAtt($att) {
        $this->att = $att;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function addReply()
    {
        $connection = new mysqli('localhost','root','unlock319','cmrs');
 
        if($connection->connect_error) 
            die($connection->connect_error);
        
        $query = "INSERT INTO `response` (`Description`, `C/R_fk`) VALUES ('$this->response', '$this->id');";
        
        $result = $connection->query($query);
        
        if (!$result)
        {
            return "INSERT failed: $query<br>";
        }
           else 
        {   
            $id = $this->roll;
            if($id[0] === "f" || $id[0]==="s") 
            {
                $SenderQuery= "INSERT INTO `mailbox` (`type_flag`, `Student_fk`, `Faculty_fk`, `C/R_fk`) VALUES ('3', '$this->roll', NULL, '$this->id');";
                //$senderQuery= "INSERT INTO `mailbox` (`type_flag`, `Student_fk`, `Faculty_fk`, `C/R_fk`) VALUES ('1', '$this->roll', NULL, '$this->id');"; for sentResponse
                //INSERT INTO `mailbox` (`type_flag`, `Student_fk`, `Faculty_fk`, `C/R_fk`) VALUES ('3', 'f2013-069', NULL, '24');
            }
            else 
            {   
                $SenderQuery= "INSERT INTO `mailbox` (`type_flag`, `Student_fk`, `Faculty_fk`, `C/R_fk`) VALUES ('3', NULL,'$this->roll', '$this->id');";
                //$recipientQuery= "INSERT INTO `mailbox` (`type_flag`, `Student_fk`, `Faculty_fk`, `C/R_fk`) VALUES ('2', NULL, '$this->recpt', '$this->id');"; for sent response
            }
            
            $Mailresult = $connection->query($SenderQuery);
            
            if(!$Mailresult)
            {
                return "Mailbox fail  ".$SenderQuery;
            }
            else
            {
                return "done";
            }
            
        }
    }
    
    
    }
