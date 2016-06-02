<?php

if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
    $filename  = basename($_FILES['file']['name']);
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $new       = md5($filename).'.'.$extension;

        move_uploaded_file($_FILES['file']['tmp_name'], "uploads/{$new}");
        echo $new;
        
    }