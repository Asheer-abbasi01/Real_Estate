<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property</title>
    <link rel="stylesheet" href="styles.css"> <!-- Ensure you link to your CSS file -->
    <!-- Add Bootstrap CSS if you are using Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Property details you want to buy</h2>

        <?php
        // Define variables and initialize with empty values
        $propertyname = $area = $flat = $price = $additional = $contact = "";
        $showPopup = false;

        // Processing form data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $propertyname = $_POST["propertyname"];
            $area = $_POST["area"];
            $flat = $_POST["flat"];
            $price = $_POST["price"];
            $additional = $_POST["additional"];
            $contact = $_POST["contact"];

            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "demo";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO purchasing_form (propertyname, area, flat, price, additional, contact) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("siisis", $propertyname, $area, $flat, $price, $additional, $contact);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>informtion store successfully, we will contact you soon. Thank you!</div>";
                $showPopup = true;
            } else {
                echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }

            // Close connection
            $stmt->close();
            $conn->close();
        }
        ?>

        <?php if ($showPopup): ?>
            <script>
                alert("Your information is submitted.Thank you!");
            </script>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="propertyname">Property Name</label>
                <input type="text" class="form-control" id="propertyname" name="propertyname" required>
            </div>
            <div class="form-group">
                <label for="area">Area (sq ft)</label>
                <input type="number" class="form-control" id="area" name="area" required>
            </div>
            <div class="form-group">
                <label for="flat">Number of Flats</label>
                <input type="number" class="form-control" id="flat" name="flat" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="additional">Additional Property</label>
                <input type="number" class="form-control" id="additional" name="additional" required>
            </div>
            <div class="form-group">
                <label for="contact">Your Contact Number</label>
                <input type="text" class="form-control" id="contact" name="contact" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            
        </form>
        
    </div>
    <div  class="container mt-5">
    <a href="index.php">
            <button type="submit" class="btn btn-primary">Back</button>
        </a>

    </div>
            <!-- Add Bootstrap JS and dependencies if you are using Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
