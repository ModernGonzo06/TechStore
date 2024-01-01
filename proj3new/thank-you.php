<!DOCTYPE html>
<html>
<head>
    <title>Thank You!</title>
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
        header, h1, h2, h3, .gracias {
            font-style: italic;
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
        .gracias{
            white-space: nowrap;
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
            <a href="cart.php" class="cart-button">Cart</a>
        </nav>
    </header>
    
    <div class="orders-container">
        <h1>Thank you!</h1>
        <div id="thankYouMessage" class="gracias"></div>
         <button class="continueShopping" onclick = "products()">Return to Product Page</button>

       
       <script>
        // Function to display thank you message and clear sessionStorage
        const num = sessionStorage.getItem('num');
        let dt = new Date();
        dt.setDate(dt.getDate() + 2);
        dtString = dt.toLocaleDateString()
        const message = `Nicely done. Your order ID is: ${num}Your order will be shipped on ${dtString}`;
        if (num) {
            document.getElementById('thankYouMessage').innerText = message;
        }
        // function to clear the sessionStorage which stores the order number and redirects back to the product page. 
        function products() {
            sessionStorage.removeItem('num');
            window.location.href = "products.php"
        }
       </script>
    </div>
</body>
</html>
