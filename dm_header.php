<?php

session_start();
require_once "dm_konekcija.php";

//provera da li je logovan
if(empty($_SESSION['id']))
{
    header('Location: dm_login.php'); //vrsi redirekciju ako nisi logovan da se prvo ulogujes
}


?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Document</title>
</head>
<body>
<p>Zdravo, <?php echo $_SESSION['name']; ?>!</p>
    <ul class='menu'>
        <li>
            <a href='dm_prijatelji2.php'>Prijatelji</a>
        </li>
        <li>
            <a href='dm_izmeniprofil.php'>Moj profil</a>
        </li>
        <li>
            <a href='dm_izmenilozinku.php'>Promeni lozinku</a>
        </li>
        <li>
            <a href='dm_logout.php'>Logout</a>
        </li>
 