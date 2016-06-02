<?php

require_once 'sent.php';
require_once 'recieved.php';
require_once 'responses.php';

class Mailbox{
    private $sent, $recieved, $responses, $id;
    
    function __construct($id) {
        $this->sent = new Sent();
        $this->recieved = new Recieved();
        $this->responses = new Responses();
        $this->id=$id;
        }
    
    function populate()
    {
        $connection = new mysqli('localhost','root','unlock319','cmrs');
 
        if($connection->connect_error) 
            die($connection->connect_error);
        
        if($this->id[0]=='f' || $this->id[0]=='s')
        {
            $query = "SELECT * FROM `mailbox` WHERE `Student_fk` = '$this->id'";
        }
        else
        {
            $query = "SELECT * FROM `mailbox` WHERE `Faculty_fk` = '$this->id'";
        }
        
        $resultMailbox = $connection->query($query);
        $rows=$resultMailbox->num_rows;
        
        if($resultMailbox->num_rows ===0)
        {
            return $resultMailbox;            
        }   
        else
        {
                      
            
            for ($i=0; $i<$rows; $i++)
            {
                $cr = new cr("","","",""); 
                
                $resultMailbox->data_seek($i);
                $dataMailbox = $resultMailbox->fetch_array(MYSQLI_ASSOC);
                
                $queryCR = "SELECT * FROM `c/rs` WHERE `ID` = ".$dataMailbox['C/R_fk'];
                
                $result = $connection->query($queryCR);
                
                $result->data_seek(0);
                $data = $result->fetch_array(MYSQLI_ASSOC);
                
                $cr->setType($data['Type']);
                $cr->setDate($data['Date']);
                $cr->setDecrpiton($data['Description']);
                //$cr->setResponse($data['Type']);
                $cr->setSubject($data['subject']);
                $cr->setID($data['ID']);
                $cr->setRecpt($data['recipient']);
                $cr->setAtt($data['Attatchment']);
                
                $SendId=$data['stdt_fk']; //sent by faculty or student?
                if($SendId===NULL)
                {
                    $cr->setRoll($data['fclty_fk']); 
                }
                else
                {
                    $cr->setRoll($data['stdt_fk']); 
                }
            
                if($dataMailbox['type_flag']==="1")
                {
                    $this->sent->add($cr);
                }
                else if ($dataMailbox['type_flag']==="2")
                {
                    $this->recieved->add($cr);
                }
                else if ($dataMailbox['type_flag']==="3")
                {
                    $rspQuery= 'SELECT * FROM `response` WHERE `C/R_fk` = '.$data['ID'];
                    $resultResp = $connection->query($rspQuery);

                    if($resultResp)
                    {                      
                        $resultResp->data_seek(0);
                        $dataR = $resultResp->fetch_array(MYSQLI_ASSOC);
                        $cr->setResponse($dataR['Description']);
                    }
                    
                    $this->responses->add($cr);
                }
            }   
        }
    
    }
    
    function dumpSent()
    {
        $this->sent->display();
    }
    
    function getSentSize()
    {
        return $this->sent->getSize();
    }
    
    function searchReceived($string)
    {
        return $this->recieved->search($string);
    }
    
    function searchSent($string)
    {
        return $this->sent->search($string);
    }
    
    function searchResponse($string)
    {
        return $this->responses->search($string);
    }
    
    function getSent($n)
    {
        return $this->sent->getThing($n);
    }
    
    function getSentById($id)
    {
        return $this->sent->getThingByID($id);
    }
 
    function dumpRecieved()
    {
        $this->recieved->display();
    }
    
    function getRecievedSize()
    {
        return $this->recieved->getSize();
    }
    
    function getRecieved($n)
    {
        return $this->recieved->getThing($n);
    }
    
    function getRecievedById($id)
    {
        return $this->recieved->getThingByID($id);
    }    
    
        function dumpResponses()
    {
        $this->responses->display();
    }
    
    function getResponsesSize()
    {
        return $this->responses->getSize();
    }
    
    function getResponse($n)
    {
        return $this->responses->getThing($n);
    }
    
    function getResponseById($id)
    {
        return $this->responses->getThingByID($id);
    }    
    
}
