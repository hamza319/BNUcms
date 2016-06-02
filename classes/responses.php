<?php

class Responses{
    private $thing; 
    private $size;
    
    function __construct() {
        $this->thing = array();
        $this->size = 0;
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
    
    function getSize()
    {
        return $this->size;
    }
    
    function display()
    {
        var_dump($this->thing);
    }
    
    function getThing($num)
    {
        return $this->thing[$num];
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
