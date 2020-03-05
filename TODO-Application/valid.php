<?php
    include 'database.php';
    
    $my_username = $_POST['username']; 
    $my_password = $_POST['password']; 
    $my_captcha = $_POST['captcha'];

    isvalid($my_username, $my_password, $my_captcha); 
?>