<?php
    
// This is a legitimate page
// But the code is vulnerable to CSRF

session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header( "Location: index.php" );
}

// Check if the transfer request is from a POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
     $amount = $_POST['amount'];
    $toAccount = $_POST['toAccount'];
    
    // Code to do bank transfer ....
}
?>

<!-- The HTML form for making a transfer -->
<form action="transfer.php" method="POST">
    <p>Transfer Money</p>
    To Account Number: <input type="text" name="toAccount" required>
    Amount: <input type="text" name="amount" required>
    <button type="submit">Transfer</button>
</form>
