
<?php
include 'db.php'; // database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo uploadFile($_FILES["file1"], "uploads/table1/", "table1", $conn);
    echo uploadFile($_FILES["file2"], "uploads/table2/", "table2", $conn);
}
?>