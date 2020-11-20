<?php
require_once "dm_konekcija.php";
$id=2; //logovani korisnik
$sql="SELECT profiles.name, profiles.dob, users.username, users.password 
        FROM profiles 
        INNER JOIN users
        ON users.id=profiles.user_id
        WHERE user_id=$id";

    $result=$conn->query($sql);
    $pom=$result->fetch_assoc();
    $imeValue=$pom['name'];
    $dobValue=$pom['dob'];
    $usernameValue=$pom['username'];
    $passwordValue=$pom['password'];
    
    
    if($result)
    {
        echo "Dobar upit";
    }
    else
    {
        echo "greska: ".$conn->error;
    }
    ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Izmeni profil</title>
</head>
<body>
    
    <form action="dm_izmeniprofil.php" method="post">
        Ime i prezime: 
        <input type="text" name="ime" >
        <span class='error'></span>
        <br><br>
        Datum rodjenja:
        <input type="date" name="datum" >
        <span class='error'></span>
        <br><br>
        Korisnicko ime:
        <input type="text" name="username" >
        <span class='error'></span>
        <br><br>
        Lozinka:
        <input type="password" name="password">
        <span class='error'></span>
        <br><br>
        Potvrdite lozinku:
        <input type="password" name="repassword" >
        <span class='error'></span>
        <br><br>
        <input type="submit" name="potvrdi" value="potvrdi">
    </form>




</body>

</html>