<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="proj3.css">
    <style>
        .orders-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .order-item {
            margin-bottom: 10px;
        }
        header, h2, h3 {
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <a href="products.php">
                <img src="images/logo.png" alt="Your Logo">
            </a>
        </div>
        <nav>
            <a href="products.php">Products</a>
            <a href="orders.php">Orders</a>
            <a href="cart.php" class="cart-button">Cart</a>
        </nav>
    </header>
    <!-- Orders List -->
    <div class="orders-container">
        <h2>List of Orders</h2>
        <?php
        // Establish database connection
        $myHost = "localhost";
        $myUserName = "ujsrwwbgswjcp";
        $myPassword = "84%u1oh^(%&U";
        $myDatabase = "dbafff4anjxrsg";
        $db = mysqli_connect($myHost, $myUserName, $myPassword, $myDatabase);
        //check connection
        if (mysqli_connect_errno()) {
            die('I cannot connect to the database because: ' . mysqli_connect_error());
        }
        //query all orders
        $sql1 = "SELECT * FROM Orders";
        $myResultOrders = mysqli_query($db, $sql1);

        if ($myResultOrders) {
            echo '<div class="order-items">';

            while ($order = mysqli_fetch_assoc($myResultOrders)) {
                echo '<div class="order-item">'; // displays date and ID
                echo '<h3> Order ' . $order['id'] . '</h3>';
                echo '<p>Date: ' . $order['date'] . '</p>';

                $totalCost = 0;
                $orderDetails = '';

                foreach($order as $columnName => $columnVal) {
                    if ($columnName != "id" && $columnName != 'date' && $columnVal > 0) { // only will check when orders contain quanity for item greater than 0
                        $queryItems = "SELECT price FROM Items WHERE name = '$columnName'"; // retrieves data needed to display orders with costs
                        $resultItems = mysqli_query($db, $queryItems);
                        $rowItems = mysqli_fetch_assoc($resultItems);
                        //calculate totalCost
                        if ($rowItems) {
                            $itemPrice = $rowItems['price'];
                            $itemQuantity = $columnVal;

                            $productCost = $itemPrice * $itemQuantity;
                            $totalCost += $productCost;

                            $orderDetails .= "$columnName: $itemPrice x $itemQuantity, ";
                        } else {
                            echo "Error fetching item details for ID " . $order['id'] . "The columnName is ". $columnName. "The columnVal is " .$columnVal."<br>"; // used to debug
                        }
                    }
                }

                if (!empty($orderDetails)) {
                    echo rtrim($orderDetails, ', ') . "<br>"; //removes white space 
                } else {
                    echo "No items in this order.<br>";
                }

                echo 'Total Cost: $' . $totalCost;
                echo '</div>';
            }

            echo '</div>';
        } else {
            echo "Error executing the query: " . mysqli_error($db);
        }

        // Close database connection
        mysqli_close($db);
        ?>
    </div>
</body>
</html>
