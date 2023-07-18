<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['checkout-btn'])) {
    // Get the order data from the POST request
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $cart_data = json_decode($_POST['cart-data'], true); // Convert the JSON string back to an array

    // Database connection details (replace with your own credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "urulaiorders";

    // Create a new MySQLi object to connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement to insert the order details into the table
    $stmt = $conn->prepare("INSERT INTO orders (name, phone, address, items_ordered) VALUES (?, ?, ?, ?)");
    $items_ordered = implode(", ", $cart_data);
    $stmt->bind_param("ssss", $name, $phone, $address, $items_ordered);

    if ($stmt->execute()) {
        // Order data successfully inserted into the table
        echo "Thank you for ordering!";
    } else {
        // Error occurred while inserting the order data
        echo "Error: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
