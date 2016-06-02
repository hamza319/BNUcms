<?php

abstract class User{
 
    
    protected $name;
    protected $password;
    protected $question;
    protected $state;
    protected $ans;
            
    function __construct()
    {
        $this->name = "";
        $this->password="";
        $this->question="";
        $this->state= 1;
    }
    
    function setName($n)
    {
        $this->name=$n;
    }
    
    public function  getName()
    {
        return $this->name;
    }
    
    function  setPass($pass)
    {
        $this->password=$pass;
    }
        
    function getPass()
    {
        return $this->password;
    }
    
    function setQuestion($q)
    {
        $this->question=$q;
    }
    
    function getQuestion()
    {
        return $this->question;
    }
    
    function setAnswer($a)
    {
        $this->ans=$a;
    }
    
    function getAnswer()
    {
        return $this->ans;
    }
    
    function setState($st)
    {
        $this->state=$st;
    }
    
    function getState()
    {
        return $this->state;
    }
    
    abstract function addUser();
    abstract function loadUser($roll);
}