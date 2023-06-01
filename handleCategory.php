<?php 
require_once 'login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

// start add
if( isset($_POST['addNewCategory']) && isset($_POST['CategoryName']) ){
$CategoryName = $_POST['CategoryName'];

$query = "INSERT INTO categories VALUES (NULL, '$CategoryName')";
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
header("Location: categories.php");
}
// End add 

// start edit
if( isset($_POST['editID']) && isset($_POST['CategoryName']) ){
    $id = $_POST['editID'];
    $CategoryName = $_POST['CategoryName'];
    
  $query = "UPDATE categories SET name = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $CategoryName, $id);

if ($stmt->execute()) {
    // Success, redirect to categories.php
    header("Location: categories.php");
    exit();
} else {
    // Error handling
    die("Database access failed: " . $stmt->error);
}
// End edit

// start Delete
}
if (isset($_REQUEST['ac'])) {
    $id = $_REQUEST['row_id'];
    $query = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: categories.php");
        exit();
    } else {
        die("Database access failed: " . $stmt->error);
    }
    $stmt->close();
}
?>