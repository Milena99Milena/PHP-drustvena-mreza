<?php
 session_start();  
require_once "dm_konekcija.php";

$friend_id=
        $conn->real_escape_string($_GET['friend_id']); //korisnik kome brisemo pracenje
$id=$_SESSION['id']; //onaj koji brise, odn logovani korisnik

$sql="DELETE FROM follow WHERE user_id=$id
        AND friend_id=$friend_id";

$result= $conn->query($sql);
if(!$result)
{
    die("Neuseli upit: ".$conn->error);
}

header('Location: dm_prijatelji.php');














?>