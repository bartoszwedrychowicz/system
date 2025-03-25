<?php
session_start();
print_r($_POST);
// Ensure the POST request contains the order ID
$klucz = isset($_POST['NumerZlecenia']) ? intval($_POST['NumerZlecenia']) : 0;

if ($klucz > 0) {
    require_once "../config.php";
    // Get the current date
    $data = date("Y-m-d");
    
    // Prepare the SQL statement to update the order's DataWydania field
    $sql = "UPDATE zlecenia SET DataWydania = ? WHERE NumerZlecenia = ?";
    $stmt = $link->prepare($sql);
    
    // Bind the parameters: 's' for string (date), 'i' for integer (order ID)
    $stmt->bind_param("si", $data, $klucz);
    $stmt->execute();
    // Execute the statement
    if ($stmt) {
        // Redirect to the same page after successful 
        $stmt->close();
        
    } else {
        // Handle error in case of failure
        $_SESSION['err'] = "Error updating record: " . $link->error;
    }

    // Close the statement and the database connection
    
    $link->close();
} else {
     $_SESSION['err'] = "Invalid order ID.";
}
header("location: .");
        exit;
?>
