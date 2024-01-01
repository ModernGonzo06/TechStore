<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="proj3.css">
    <title>Cart</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
        header,
        h1,
        h2,
        h3 {
            font-style: italic;
        }

        h1 {
            padding-left: 20px;
        }

        .order-item {
            padding: 10px 50px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .lightsteelblue-bg {
            background-color: lightsteelblue;
        }

        .lightgrey-bg {
            background-color: lightgrey;
        }

        .order-item:nth-child(even) {
            background-color: lightsteelblue;
        }

        .order-item:nth-child(odd) {
            background-color: lightgrey;
        }

        #cartQuantities {
            font-style: italic;
            padding: 10px 40px;
            margin: 20px;
            border-radius: 10px;
            align-items: center;
            justify-content: center;
        }

        #Cost {
            font-style: italic;
            padding: 10px 40px;
        }

        .clear-button {
            padding: 8px 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 20px;
            font-style: italic;
        }

        .clear-button:hover {
            background-color: red;
            color: white;
        }

        .checkOut {
            padding: 8px 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 20px;
        }

        .checkOut:hover {
            background-color: green;
            color: white;
        }

        .continueShopping {
            padding: 8px 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 20px;
        }

        .continueShopping:hover {
            background-color: lightsteelblue;
            color: white;
        }
    </style>
</head>

<body>
<!-- Nav Bar header that is reflected across all pages-->
    <header>
        <div class="logo">
            <a href="products.php">
                <img src="images/logo.png" alt="Your Logo">
            </a>
        </div>
        <nav>
            <a href="products.php">Products</a>
            <a href="orders.php">Orders</a>
            <a href="cart.php" class="cart-button">
                Cart
            </a>
        </nav>
    </header>
    <h1>Your Cart</h1>

    <!-- Container to display cart -->
    <div id="cartQuantities"></div>
    <div id="Cost"></div>
    <!-- Buttons -->
    <button class="clear-button" onclick="clearCart()">Clear Cart</button>
    <button class="checkOut" onclick="checkOut()">Check Out</button>
    <button class="continueShopping" onclick="products()">Continue Shopping</button>

    <script>
        // function to display the cart items. Retrieves items from localStorage to display to user. 
        function displayCartQuantities() {
            let cart = JSON.parse(localStorage.getItem('cart')) || {};
            let quantitiesContainer = document.getElementById('cartQuantities');
            quantitiesContainer.innerHTML = '';

            if (Object.keys(cart).length == 0) { // checks to see if cart is empty 
                quantitiesContainer.textContent = 'Your Cart is Empty';
                let costContainer = document.getElementById("Cost");
                costContainer.innerHTML = '';
            } else {
                let cost = 0;
                for (let productID in cart) { // iteratres through cart items, updating cost
                    if (cart.hasOwnProperty(productID)) {
                        let quantityElement = document.createElement('div');
                        quantityElement.classList.add('order-item');

                        let productInfo = document.createElement('span');
                        let productName = cart[productID].name;
                        let quantity = cart[productID].quantity;
                        let price = cart[productID]._price;
                        let itemTotalCost = price * quantity;
                        productInfo.innerHTML = `Product: ${productName}<br>Quantity: ${quantity} x Price: $${price} <br> Total Cost: $${itemTotalCost}`; // adds item using stored variables

                        let removeButton = document.createElement('button'); // creates remove from cart button for each item
                        removeButton.textContent = 'Remove from Cart';
                        removeButton.classList.add('clear-button');
                        removeButton.onclick = function () {
                            removeItem(productID);
                        };
                        //adds items 
                        quantityElement.appendChild(productInfo);
                        quantityElement.appendChild(removeButton);
                        quantitiesContainer.appendChild(quantityElement);
                        cost += itemTotalCost;
                    }
                }
                let costContainer = document.getElementById('Cost');
                costContainer.innerHTML = `Order Cost: $${cost}`; // updates total cost
            }
            

        }


        // Call the function to display cart quantities when the page loads
        window.onload = function () {
            displayCartQuantities();
        };
        function removeItem(productID) {
            let cart = JSON.parse(localStorage.getItem('cart')) || {};
            delete cart[productID];
            localStorage.setItem('cart', JSON.stringify(cart));
            displayCartQuantities(); // Update the displayed cart quantities after removing an item
        }
        // Function to clear the cart and local storage
        function clearCart() {
            localStorage.removeItem('cart');
            // Update the displayed cart quantities after clearing
            displayCartQuantities();
        }
        // Redirects to product page again
        function products() {
            window.location.href = "products.php"
        }
        // function to check out all items in cart
        function checkOut() {
            // Retrieve data from local storage
            let cartData = JSON.parse(localStorage.getItem('cart'));
            let itemsToSend = [];

            if (!Object.keys(cartData).length == 0) { // only work if cart is not empty

                for (let productId in cartData) {
                    if (cartData.hasOwnProperty(productId)) {
                        let itemName = cartData[productId].name;
                        let modifiedName = itemName.replace(/ /g, '_'); // Replace spaces with underscores
                        let item = {
                            name: modifiedName,
                            quantity: cartData[productId].quantity
                        };
                        itemsToSend.push(item);
                    }
                }
                // Send an AJAX request to the PHP script to process the data using JQuery
                $.ajax({
                    type: 'POST',
                    url: 'process.php',
                    contentType: 'application/json',
                    data: JSON.stringify(itemsToSend),
                    success: function (response) {
                        //console.log(response);
                        sessionStorage.setItem('num', response);
                        localStorage.removeItem('cart');
                        window.location.href = "thank-you.php";
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }

    </script>
</body>

</html>