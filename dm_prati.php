<?php
 session_start(); 
require_once "dm_konekcija.php";

$friend_id= //id korisnika koga hocu da pratim
$conn->real_escape_string($_GET['friend_id']); //za izbegavanje maniulacije upita od strane korisnika

$id=$_SESSION['id']; //id logovanog korisnika

$sql="SELECT * FROM follow WHERE user_id=$id
        AND friend_id=$friend_id";

$result= $conn->query($sql);
if($result->num_rows==0)
{
    $sql1= "INSERT INTO  follow(user_id, friend_id)
    VALUES($id,$friend_id)";
    $result1=$conn->query($sql1);
    if(!$result1)
    {
        die("Neuspesni upit: ".$conn->error );
    }
}

header('Location: dm_prijatelji.php'); //redirekcija na str dm_prijatelj.php















?>