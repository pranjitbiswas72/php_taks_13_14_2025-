<?php
$folder = "images/"; 

if (isset($_POST['submit'])) {
    $filename = $_FILES['UploadFile']['name'];
    $tmp_loc = $_FILES['UploadFile']['tmp_name']; 

    if (!empty($filename)) {
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        if (move_uploaded_file($tmp_loc, $folder . $filename)) {
            echo " File uploaded successfully!";
        } else {
            echo " File upload failed! Error: " . $_FILES['UploadFile']['error'];
        }
    } else {
        echo " Please select a file!";
    }
}
?>

<html>
<head>
    <title>File Upload</title>
</head>
<body>
    <h2>File Upload Form</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="UploadFile"><br><br>
        <input type="submit" name="submit" value="Upload File">
    </form>
</body>
</html>
