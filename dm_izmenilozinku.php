<?php
    require_once "dm_header.php";

    $staraErr=$novaErr=$pnovaErr="*";
    $poruka="";

    if($_SERVER ['REQUEST_METHOD']=="POST")
    {
        if(empty($_POST['stara']))
        {
            $staraErr="Polje ne sme biti prazno!";
        }
        if(empty($_POST['nova']))
        {
            $novaErr="Polje ne sme biti prazno!";
        }
        if(empty($_POST['pnova']))
        {
            $pnovaErr="Polje ne sme biti prazno!";
        }
        if($staraErr=="*" && $novaErr=="*" && $pnovaErr=="*")
        {
            //polja nisu prazna
            $stara=$conn->real_escape_string($_POST['stara']);
            $nova=$conn->real_escape_string($_POST['nova']);
            $pnova=$conn->real_escape_string($_POST['pnova']);

            if($nova!=$pnova)
            {
                //nove sifre se ne poklapaju, greska
                $novaErr="Sifre moraju da se poklapaju.";
                $pnovaErr="Sifre moraju da se poklapaju.";
            }
            else
            {
                $sql="SELECT password FROM users WHERE id=".$_SESSION['id'];
                $result=$conn->query($sql);
                $row=$result->fetch_assoc();
                $sifra=$row['password'];
                //$sifra --kodirana sifra korisnika iz baze
                if(md5($stara)!=$sifra)
                {
                    $staraErr="pogresna lozinka";
                }
                else
                {
                    $sql="UPDATE users SET password=md5('$nova') WHERE id =".$_SESSION['id'];
                    $conn->query($sql);
                    $poruka="Lozinka uspesno promenjena!
                    <a href='dm_prijatelji2.php'>Vrati se na pocetak</a>";
                }
            }
        }
    }
?>

<div class='success'>
    <?php echo $poruka;?>
</div>

<form action="dm_izmenilozinku.php" method="POST">

    Stara lozinka:
    <input type="password" name="stara" value="">
    <span class='error'><?php echo $staraErr;?></span>
    <br>
    Nova lozinka:
    <input type="password" name="nova" value="">   
    <span class='error'><?php echo $novaErr;?></span>
    <br>
    Ponovite novu lozinku:
    <input type="password" name="pnova" value="">
    <span class='error'><?php echo $pnovaErr;?></span>
    <br>
    <input type="submit" value="Posalji">

</form>


</body>
</html>