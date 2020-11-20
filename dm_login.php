<?php
//otvaranje sesije na pocetku skripta
session_start();
require_once "dm_konekcija.php";

$usernameErr=$passwordErr="*";

//da li smo dosli post metodom
if($_SERVER['REQUEST_METHOD']=="POST")
{
    //korisnik je posalo username i password i pokusava logovanje
    $username=$conn->real_escape_string($_POST['username']);
    $password=$conn->real_escape_string($_POST['password']);

    //validacija da li je korisnik popunio polja
    if(empty($username))
    {
        $usernameErr="Korisnicko ime ne sme biti prazno";
    }
    if(empty($password))
    {
        $passwordErr="Lozinka ne sme biti prazna";
    }

    if(!empty($username)&& !empty($password))
    {
        $sql="SELECT * FROM users WHERE username='$username'";
        $result=$conn->query($sql);
        if($result->num_rows==0)
        {
            $usernameErr="Ne postoji korisnik sa unetim korisnickim imenom";
        }
        else
        {
            //postoji i korisnicko ime, ali treba i sifra da se poklopi
            $row=$result->fetch_assoc();
            $sifra=$row['password']; //polje passowd iz baze
            //nama je sad sifra kodirana
            if($sifra!=md5($password))
            {
                $passwordErr="Pogresna lozinka";
            }
            else
            {
                //ovde vrsimo logovanje
                $_SESSION['id']=$row['id'];
                $id=$_SESSION['id'];
                $sql1="SELECT name FROM profiles WHERE user_id=$id";
                $result1=$conn->query($sql1);
                $row1=$result1->fetch_assoc();
                $_SESSION['name']=$row1['name'];
                header('Location: dm_prijatelji2.php');
            }
        }
    }

}

?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Login</title>
</head>
<body>
    
    <form action="" method="post">
    Korisnicko ime:
        <input type="text" name="username">
        <span class='error'><?php echo $usernameErr;?></span>
        <br><br>
        Lozinka:
        <input type="password" name="password">
        <span class='error'><?php echo $passwordErr;?></span>
        <br><br>
        <input type="submit" name="prijavi se" value="prijavi se">
    </form>




</body>

</html>