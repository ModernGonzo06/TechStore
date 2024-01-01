<?php
// Retrieve the POST data sent from the AJAX request
$postData = file_get_contents("php://input");
$cartData = json_decode($postData, true);

$myHost = "localhost";
$myUserName = "ujsrwwbgswjcp";
$myPassword = "84%u1oh^(%&U";
$myDatabase = "dbafff4anjxrsg";
// Establish a database connection
$conn = new mysqli($myHost, $myUserName, $myPassword, $myDatabase);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the date for the order
$orderDate = date("Y-m-d");

// Initialize variables for the products
$computer = 0;
$smartPhone = 0;
$tablet = 0;
$gamingConsole = 0;
$smartWatch = 0;

// Loop through the received array and update quantities
foreach ($cartData as $item) {
    $productName = $item['name'];
    $quantity = $item['quantity'];

    // Match product name with the column names and update the respective variable
    switch ($productName) {
        case 'Computer':
            $computer += $quantity;
            break;
        case 'Smart_Phone':
            $smartPhone += $quantity;
            break;
        case 'Tablet':
            $tablet += $quantity;
            break;
        case 'Gaming_Console':
            $gamingConsole += $quantity;
            break;
        case 'Smart_Watch':
            $smartWatch += $quantity;
            break;
        default:
            break;
    }
}

// Prepare and execute the SQL query to insert the order into the Orders table
$sql = "INSERT INTO Orders (date, Computer, Smart_Phone, Tablet, Gaming_Console, Smart_Watch)
        VALUES ('$orderDate', $computer, $smartPhone, $tablet, $gamingConsole, $smartWatch)";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo $last_id; // returns order ID to then use in thank-you page 
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


// Close the database connection
$conn->close();

?>

