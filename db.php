<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$DB_HOST=$_ENV['DB_HOST'];
$DB_USER=$_ENV['DB_USER'];
$DB_PASS=$_ENV['DB_PASS'];
$DB_NAME=$_ENV['DB_NAME'];

$conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS);
$sql= "CREATE DATABASE IF NOT EXISTS $DB_NAME"; 

if($conn->connect_error){
die("connection failed:".$conn->connect_error);
}else{
    if ($conn->query($sql) === TRUE){
        echo "Database created successfully <br>";

        $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);
        $tbsql ="CREATE TABLE IF NOT EXISTS users(
         id INT(11) AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(50) NOT NULL,
            email VARCHAR(50) NOT NULL,
            phone VARCHAR(15) NOT NULL,
            address VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            
            image VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        if($conn->query($tbsql)===TRUE){
            echo"Tabel created successfully";

        }else{
            echo "Error creating table:".$conn->error;
        }
    }
}
$conn->close();

?>