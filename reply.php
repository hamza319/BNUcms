<?php

require_once './classes/C-R.php';

$id = isset($_POST['id'])? $_POST['id'] : NULL;
$response = isset($_POST['des'])? $_POST['des'] : NULL;
$sender= isset($_POST['sender'])? $_POST['sender'] : NULL;


if($id !== NULL && $response !== NULL && $sender!== NULL)
{
    $cr = new cr("", "", "", "");
    $cr->setID($id);
    $cr->setRoll($sender);
    $cr->setResponse($response);
    echo $cr->addReply();
}
else
{
    echo "error";
}