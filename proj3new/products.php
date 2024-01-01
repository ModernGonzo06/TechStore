<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel = "stylesheet" href="proj3.css">
    <link rel="stylesheet" href="proj3.css">
    <style>
        header, .product-name, .product-price{
            font-style: italic;
        }
        .products {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; 
            padding-left: 40px;
            padding-top: 40px;
            background-color: lightsteelblue;
            padding-right: 40px;
            justify-content: center;
        }

        .product-items {
            width: calc(45% - 20px);
            margin-bottom: 20px; 
            background-color: lightgrey;
            display: flex;
            flex-direction: column;
            border-radius: 3%;
        }
        
        .product-image{
            width: 90%;
            border-radius: 20%;
            padding: 5%;
        }
        .product-price, .product-name, .quantity-label, .more-details{
            padding-left: 5%;
            padding-right: 5%;

        }
        .product-name {
            font-size: 30px;
            margin-top: 10px;
        }

        .product-price {
            font-size: 18px;
            margin-top: 5px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .more-button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        @media (max-width: 800px){
            .product-items {
            width: 500px;
            margin-bottom: 20px; 
            background-color: lightgrey;
            display: flex;
            flex-direction: column;
            border-radius: 3%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="products.php">
                <img src="images/logo.png" alt="Your Logo">
            </a>
        </div>
        <nav>
            <a href="products.php">Products</a>
            <a href="orders.php">Orders</a>
            <a href="cart.php" class = "cart-button">
                Cart
            </a>
        </nav>
    </header>

    <div class="products">
        <?php
        $myHost = "localhost";
        $myUserName = "ujsrwwbgswjcp";
        $myPassword = "84%u1oh^(%&U";
        $myDatabase = "dbafff4anjxrsg";
        //connects to db
        $db = mysqli_connect($myHost, $myUserName, $myPassword, $myDatabase);
        //checks connection
        if (mysqli_connect_errno()) {
            die('I cannot connect to the database because: ' . mysqli_connect_error());
        }

        $sql = "SELECT * FROM Items";
        $myResult = mysqli_query($db, $sql);
        // retrives data from Items DB
        if ($myResult) {
            while ($row = mysqli_fetch_assoc($myResult)) {
                echo '<div class="product-items">';
                echo '<img src="' . $row['image_url'] . '" alt="' . $row['image_url'] . '" class="product-image">'; // adds Item image to div
                if (strpos($row['name'], '_') !== false){ // checks if name contains "_" and replaces with a space
                    $productName = str_replace('_',' ', $row['name']);
                }
                else{
                    $productName = $row['name'];
                }
                echo '<h3 class = "product-name">' . $productName . '</h3>';//adds name
                echo '<p class = "product-price">Price: $' . $row['price'] . '</p>';// adds price
                echo '<form method="post">';
                echo '<label for="quantity" class="quantity-label">Quantity:</label>';
                echo '<select name="quantity" id="quantity_' . $row['id'] . '">';// adds select element and links ID to product ID. 
                for ($i = 1; $i <= 10; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                echo '</select>';
                echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                echo '<button type="button" onclick="addToCart(' . $row['id'] . ', \'' . $productName . '\', ' . $row['price'] . ')">Add to Cart</button>'; // adds add to cart button
                echo '<button type="button" class="more-button" onclick="toggleMore(this,' . $row['id'] . ')">More</button>'; // adds more button
                echo '</form>';

                echo '<div class="more-details" id="moreDetails_' . $row['id'] . '"style="display:none;">';//hidden more detal div
                echo '<p class = "product-decription">' . $row['description'] . '</p>';
                echo '</div>';

                echo '</div>';
            }
        } else {
            echo "No products available.";
        }

        mysqli_close($db);
        ?>
    </div>
    <script>
        function toggleMore(button, productID) { // uses product ID to display more Info
            var moreDetails = document.getElementById('moreDetails_' + productID);

            if (moreDetails.style.display == 'none' || moreDetails.style.display == '') {
                moreDetails.style.display = 'block';
                button.innerText = 'Hide'; // Change button text to 'Hide'
            } else {
                moreDetails.style.display = 'none';
                button.innerText = 'More'; // Change button text back to 'More'
            }
        }
        //adds products to cart through localStorage
        function addToCart(productId, name, price) {
            event.preventDefault(); // prevents the default form method
            let cart = JSON.parse(localStorage.getItem('cart')) || {};
            let selectedQuantity = parseInt(document.getElementById('quantity_' + productId).value);

            
            if (!cart[productId]) { // adds new item instance to cart
                cart[productId] = {
                    name: name,
                    _price: price,
                    quantity: 0
                };
            }
            cart[productId].quantity += selectedQuantity;//adds the quantity

           
            localStorage.setItem('cart', JSON.stringify(cart));
            // configures alert that displays after adding items
            let confirmationMessage = '';
            if (selectedQuantity == 1) {
                confirmationMessage = 'Added ' + selectedQuantity + " " + name + ' to cart.';
            } else {
                confirmationMessage = 'Added ' + selectedQuantity + " " + name + 's to cart.';
            }

            let confirmation = confirm(confirmationMessage + ' Do you want to view your cart?');

            // Redirect to cart.php if the user confirms
            if (confirmation) {
                window.location.href = 'cart.php';
            }

        }

    </script>

</body>
</html>
