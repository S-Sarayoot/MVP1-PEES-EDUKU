<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex, nofollow">
        <title>Logout</title>
    </head>
</html>

<?php
    if (isset($_COOKIE["EquityLearnKU"])){
        setcookie("EquityLearnKU", "", time()-60, "/");
    }
    
    header( "location: login" );
    exit();
?>