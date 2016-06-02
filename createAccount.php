<?php
include_once './classes/student.php';

$fname = isset($_POST["fname"])? $_POST["fname"] : NULL;
$lname = isset($_POST["lname"])? $_POST["lname"] : NULL;
$pass = isset($_POST["pass"])? $_POST["pass"] : NULL;
$ans = isset($_POST["ans"])? $_POST["ans"] : NULL;
$question = isset($_POST["question"])? $_POST["question"] : NULL;
$id = isset($_POST["id"])? $_POST["id"] : NULL;
$dept = isset($_POST["dept"])? $_POST["dept"] : NULL;

$student = new Student();

$student->setName($fname." ".$lname);
$student->setAnswer($ans);
$student->setQuestion($question);
$student->setPass($pass);
$student->setRoll($id);
$student->setDept($dept);

echo $student->addUser();
