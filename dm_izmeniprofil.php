<?php

require_once "dm_header.php";

$id=$_SESSION['id']; //logovani korisnik
$sql="SELECT profiles.name, profiles.dob, users.username
        FROM profiles 
        INNER JOIN users
        ON users.id=profiles.user_id
        WHERE user_id=$id";

    $result=$conn->query($sql);
    $pom=$result->fetch_assoc();
    $imeValue=$pom['name'];
    $dobValue=$pom['dob'];
    $usernameValue=$pom['username'];
    
    
    if($result)
    {
        echo "Dobar upit";
    }
    else
    {
        echo "greska: ".$conn->error;
    }

$imeErr=$datumErr=$usernameErr="*";

if(isset($_POST['potvrdi'])) //moze i if(!empty($_POST['potvrdi']))
{
    $ime=$conn->real_escape_string($_POST['ime']);
    $datum=$conn->real_escape_string($_POST['datum']);
    $username=$conn->real_escape_string($_POST['username']);
    
    if(empty($ime))
    {
        $imeErr="Niste uneli ime i prezime";
    }
    if(empty($datum))
    {
        $datumErr="Niste uneli datum";
    }
    if(empty($username))
    {echo "greska";

        $usernameErr="Niste uneli korisnicko ime";
    }
    else
    {
        //dohvatamo sva korisnicka imena drugih korisnika i provaravamo da nije doslo do preklapanja
        $sql="SELECT username FROM users WHERE id!=$id AND username='$username'";
        $result=$conn->query($sql);
        if($result->num_rows>0)
        {
            $usernameErr="Korisnicko ime je zauzeto";
        }
    }
    

    if($imeErr=="*" && $datumErr=="*" && $usernameErr=="*")
    {
        
        $sql="UPDATE profiles SET name='$ime', dob='$datum'
                WHERE user_id=$id";
        $conn->query($sql);

        //nakon update aziriramo i promenljive cije vrednosti upisujemo u inpute
        $sql="UPDATE users SET username='$username'
                WHERE id=$id";
                $conn->query($sql);

            $imeValue=$pom['name'];
            $dobValue=$pom['dob'];
            $usernameValue=$pom['username'];
    }
}


?>

    
    <form action="dm_izmeniprofil.php" method="post">
        Ime i prezime: 
        <input type="text" name="ime" value="<?php echo$imeValue;?>" >
        <span class='error'><?php echo $imeErr;?></span>
        <br><br>
        Datum rodjenja:
        <input type="date" name="datum" value="<?php echo $dobValue;?>" >
        <span class='error'><?php echo $datumErr;?></span>
        <br><br>
        Korisnicko ime:
        <input type="text" name="username" value="<?php echo $usernameValue;?>">
        <span class='error'><?php echo $usernameErr;?></span>
        <br><br>
        
        <input type="submit" name="potvrdi" value="potvrdi">
    </form>




</body>

</html>