<?php

require_once './classes/mailbox.php';
session_start();

$mailbox = $_SESSION['mailbox'];

$query = isset($_POST['query'])?$_POST['query']:NULL;
$inbox = isset($_POST['inbox'])?$_POST['inbox']:NULL;

if($inbox === "sent")
{
    echo json_encode($mailbox->searchSent($query));
}

if($inbox === "received")
{
    echo json_encode($mailbox->searchReceived($query));    
}

if($inbox === "response")
{
    echo json_encode($mailbox->searchResponse($query));    
}