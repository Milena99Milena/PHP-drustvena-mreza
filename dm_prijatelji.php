<?php
require_once "dm_header.php";

$id=$_SESSION['id']; // id logovanog korisnika, citamo iz sesije


$sql="SELECT u.id, u.username,p.user_id, p.name
        FROM users AS u
        INNER JOIN profiles AS p
        ON u.id=p.user_id
        WHERE u.id !=$id   -- svi korisnici osim logovanog
        ORDER BY p.name";

$result=$conn->query($sql);
if($result->num_rows==0)
{
    echo "<div class='error'>Vasa mreza nema nijednog korisnika :( </div>";
}
else 
{
    echo "<ul>";
    while($row=$result->fetch_assoc())
    {
        $friend_id=$row['id'];
        echo "<li>";
        echo $row['name'];
        echo " (".$row['username'].")";
        echo "<a href='dm_prati.php?friend_id=$friend_id'>Zaprati</a>&nbsp"; //za space
        echo "<a href='dm_otprati.php?friend_id=$friend_id'>Otkazi pracenje</a>";
        echo "</li>";
    }
    echo "</ul>";
}

























?>
</body>
</html>