<?php
// Database connection
$dbHost = $_ENV['DB_HOST'] ?? 'localhost';
$dbUser = $_ENV['DB_USER'] ?? 'root';
$dbPass = $_ENV['DB_PASS'] ?? '';
$dbName = $_ENV['DB_NAME'] ?? 'php_row';

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and trim spaces
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    

    // Check if file was uploaded
    if (isset($_FILES['file'])) {
        $file_name = $_FILES['file']['name'];
        $temp_name = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
    } else {
        $file_name = '';
        $temp_name = '';
        $file_size = 0;
    }

    // ====== Validation ======
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $errors[] = "Valid phone number is required (10-15 digits).";
    }

    if (empty($address)) {
        $errors[] = "Address is required.";
    }

    // Image validation
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
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password, phone, address, image) 
        VALUES ('$name', '$email', '$hashed_password', '$phone', '$address', '$new_file_name')";

            if (mysqli_query($conn, $sql)) {
                echo "<p style='color:green;'> User registered successfully!</p>";
            } else {
                echo "<p style='color:red;'> Error: " . mysqli_error($conn) . "</p>";
            }
        }
    }

    // Display errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}

mysqli_close($conn);