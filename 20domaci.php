<!DOCTYPE html>
<html>
<head>
    <style>
    *{ font-size:24px; font-weight:bold;}
    .error
    {
    color: red;
    font-size: 24px;
    font-weight: bold;
    }
    .blue:hover{background-color:blue; color:white}
    .blackhover{background-color:black; color:yellow}
    </style>
    <title>Document</title>
</head>
<body>
<?php

//1) povezivanje na bazu // prikazati sve korisnike koji nisu ja
require_once "dm_konekcija.php";
//once-najvise jedan objekat konekcije a to je $conn
//require- ne sme da se izvrsava na dalje ako nema konekcije

//2) prikazati sve korisnike osim logovanog 
$id=2; //id logovanog korisnika
// id mora da bude naka vrednos iz kolone  id tabele users

if(!empty($_GET['dodaj'])) //if(isset($_GET['dodaj']))
{
    $fid=$conn->real_escape_string($_GET['dodaj']);
    $sql1= "SELECT * FROM follow
            WHERE user_id=$id
            AND friend_id=$fid";
    $result1=$conn->query($sql1);
    if($result1->num_rows==0)
    {
        $sql2="INSERT INTO follow(user_id,friend_id)
        VALUES ($id,$fid);";
        $result2=$conn->query($sql2);
        if(!$result2)
        {
            echo "<span class='error'> Neuspesno dodavanje: ".$conn->error."</span>";
        }
    }
}
if(!empty($_GET['brisi']))
{
    $fid=$conn->real_escape_string($_GET['brisi']);
    $sql1= "DELETE FROM follow
            WHERE user_id=$id
            AND friend_id=$fid";
    $result1=$conn->query($sql1);
    if(!$result1)
        {
            echo "<span class='error'> Neuspesno brisanje: ".$conn->error."</span>";
        }
}


$sql="SELECT u.username,p.name,p.dob, u.id 
        FROM users AS u
        INNER JOIN profiles AS p
        ON u.id=p.user_id
        WHERE u.id!=$id
        ORDER BY p.name;";

$result=$conn->query($sql);
if(!$result)
{
    die("<span class='error'> Greska u upitu: ".$conn->error."</span></body></html>"); //mora da se zatvori jer ako nije tacno sve umire i program se prekida, jer sve osle die se ignorise
}
else {
    if($result->num_rows==0)
    {
        echo "<span class='error'>Drustvena mreza nema nijendog korisnika</span>";
    }
    else 
    {
        //ima korisnika i treba ih prikazati
        $br=1;
        echo "<ul>";
    
            while($row=$result->fetch_assoc())
            {

                $sql3="SELECT YEAR(dob) FROM profiles
                WHERE user_id!=$id";
                $result3=$conn->query($sql3);
     
                    echo "<li>".($br++);
                    echo "&nbsp";
                    echo "<span>".$row['name']."</span>";
                    echo "&nbsp";
                    if($result3%2==0)
                    {
                        echo "<span class='blue'>(".$row['username'].")</span>";
                    }
                    else
                    {
                        echo "<span class='black'>(".$row['username'].")</span>";
                    }
                    $friend_id=$row['id'];

                    //ispitujemo da li pratim korisnika
                    $sql1="SELECT * FROM follow
                            WHERE user_id=$id
                            AND friend_id=$friend_id";
                    $result1=$conn->query($sql1);
                    $jatebe=$result1->num_rows; // 0 ili 1 // 0 ne pratimo se, 1 jedan prati

                    //ispitujemo da li korisnik prati mene
                    $sql2="SELECT * FROM follow
                            WHERE user_id=$friend_id
                            AND friend_id=$id";
                    $result2=$conn->query($sql2);
                    $timene=$result2->num_rows; // 0 ili 1
                    
                    echo "&nbsp";
                    echo "<span>";
                        if($jatebe==0)
                        {
                            if($timene==0)
                            {
                                echo "<a href='dm_prijatelji2.php?dodaj=$friend_id'>Zaprati korisnika</a>";
                            }
                            else
                            {
                                echo "<a href='dm_prijatelji2.php?dodaj=$friend_id'>Uzvrati pracenje</a>";
                            }
                        }
                        else
                        {
                            echo "<a href='dm_prijatelji2.php?brisi=$friend_id'>Otkazi pracenje</a>";
                        }
                        
                    echo "</span>";
            echo "</li>";
            }
        echo "</ul>";
    }
}





?>

</body>
</html>