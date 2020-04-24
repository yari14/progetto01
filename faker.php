<?php
require_once 'vendor/autoload.php';
include_once 'db.php';
$faker = Faker\Factory::create();
//Libreria Faker, genera dati fittizi per l'app
for($i=0; $i <20; $i++){
    $query = "INSERT INTO clienti (cognome, nome, email) VALUES ( ";
    $query .= "'" . $faker->lastName . "', '" . $faker->firstName . "', '" . $faker->email ."' )";
    echo $query;
    if(mysqli_query($conn, $query)){
        echo 'Record inserito<br>';
    }else{
        echo mysqli_error($conn);
    }
}