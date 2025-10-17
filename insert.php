<?php
require_once 'vendor/autoload.php';

// .env file uplode
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// .env data base 
$DB_HOST = $_ENV['DB_HOST'];
$DB_USER = $_ENV['DB_USER'];
$DB_PASS = $_ENV['DB_PASS'];
$DB_NAME = $_ENV['DB_NAME'];



$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS $DB_NAME";
if ($conn->query($sql)=== TRUE) {
    echo " database create successfully.<br>";
} else {
    die(" Error creating database: " . mysqli_error($conn));
}

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$conn) {
    die("Connection to '$DB_NAME' failed: " . mysqli_connect_error());
}



$table2 = "CREATE TABLE IF NOT EXISTS table2_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(100) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($table2)===TRUE) {
    echo " table create successfully .<br>";
} else {
    echo " Error creating table 'table2_files': " . mysqli_error($conn) . "<br>";
}



if($_SERVER["REQUEST_METHOD"] == "POST"){
     if (isset($_FILES['file'])) {
        $file_name = $_FILES['file']['name'];
        $temp_name = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
    } else {
        $file_name = '';
        $temp_name = '';
        $file_size = 0;
    }

}

 if (empty($file_name)) {
        $errors[] = "Image is required.";
    } else {
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = time() . '.' . $file_ext;
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        if (!in_array($file_ext, $allowed_ext)) {
            $errors[] = "Only JPG, JPEG, and PNG files are allowed.";
        }
        if ($file_size > 5 * 1024 * 1024) { // 5MB
            $errors[] = "File size must be less than 5MB.";
        }
    }

    // ====== If no errors, process form ======
    if (empty($errors)) {
        // Create uploads directory if it doesn't exist
        $target_dir = "images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
            echo "Directory created successfully. <br>";
        }

        // Move uploaded file
        $target_file = $target_dir . basename($new_file_name);
        if (!move_uploaded_file($temp_name, $target_file)) {
            $errors[] = "Failed to upload image.";
        }
    }

$insertQ = "INSERT INTO table2_files(filename) VALUES ('$new_file_name')";

if($conn->query($insertQ)===TRUE){
    echo "upload successfully <br>";

}else{

    echo "file upload error " .$conn->error;
}

mysqli_close($conn);
?>