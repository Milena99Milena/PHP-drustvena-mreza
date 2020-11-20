<?php
//Formiranje tabela u bazi

require_once "dm_konekcija.php";

$sql="CREATE TABLE IF NOT EXISTS users(
    id INT UNSIGNED AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
    )ENGINE=InnoDB;";

$sql=$sql."CREATE TABLE IF NOT EXISTS profiles(
    id INT UNSIGNED AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDB;";

$sql=$sql."CREATE TABLE IF NOT EXISTS follow(
    id INT UNSIGNED AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    friend_id INT UNSIGNED NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(friend_id) REFERENCES users(id)
)ENGINE=InnoDB;";

if($conn->multi_query($sql))
{
    echo "Uspesno izvrseni upiti";
}
else
{
    echo "Greska: ".$conn->error;
}














?>