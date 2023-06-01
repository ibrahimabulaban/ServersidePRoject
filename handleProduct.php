<?php 
require_once 'login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

// start add
if(  isset($_POST['productName']) && isset($_POST['productCategory']) ){
$productName = $_POST['productName'];
$productCategory = $_POST['productCategory'];

$query = "INSERT INTO products VALUES (NULL, '$productName', '$productCategory')";
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
header("Location: products.php");
}
// End add 

// start edit
if( isset($_POST['editID']) && isset($_POST['editedProductName']) && isset($_POST['editedProductCategory'])){
    $id = $_POST['editID'];
    $editedProductName = $_POST['editedProductName'];
    $editedProductCategory = $_POST['editedProductCategory'];
  $query = "UPDATE products SET name = ? , categories_id = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sii", $editedProductName, $editedProductCategory,$id);

if ($stmt->execute()) {
    header("Location: products.php");
    exit();
} else {
    die("Database access failed: " . $stmt->error);
}
// End edit

// start Delete
}
if (isset($_REQUEST['ac'])) {
    $id = $_REQUEST['row_id'];
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: products.php");
        exit();
    } else {
        die("Database access failed: " . $stmt->error);
    }
    $stmt->close();
}
?>