<?php

require_once 'C-R.php';

class Recieved
{
    private $thing; 
    private $size;
    
    function __construct() {
        $this->thing = array();
        $this->size = 0;
    }
    
    public function getThing($num) {
        return $this->thing[$num];
    }

    public function getSize() {
        return $this->size;
    }
    
    function getThingByID($id)
    {
        foreach ($this->thing as $item)
        {
            if($item->getID() === $id)
            {
                return $item;
            }
        }
        
        return "not found";
            
    }

    function display()
    {
        var_dump($this->thing);
    }

    function add($thing)
    {
        $this->thing[]=$thing;
        $this->calSize();
    }
    
    function calSize()
    {
        $this->size= count($this->thing);
    }    
    
    function search($string)
    {
        $result = array();
        
        foreach ($this->thing as $item)
        {
            $sub = $item->getSubject();
            $token = stripos($sub,$string);
            
            if($token !== FALSE)
            {
                $result[]=$item->getID();
            }
        }
        
        return $result;
    }
}