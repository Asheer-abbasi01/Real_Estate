<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "demo";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if (isset($_POST['submit'])) {
    $pname = $_POST['propertyName'];
    $price = $_POST['price'];
    $area = $_POST['area'];
    $beds = $_POST['beds'];
    $baths = $_POST['baths'];
    $garages = $_POST['garages'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $img = basename($_FILES['image']['name']);
        $img_tmp = $_FILES['image']['tmp_name'];
        $img_folder = "assets/img/" . $img;

        // Move the uploaded file to the specified folder
        if (move_uploaded_file($img_tmp, $img_folder)) {
            echo "File is valid and was successfully uploaded.";
        } else {
            echo "File upload failed.";
            $img_folder = ""; // Set default image if upload fails
        }
    } else {
        $img_folder = ""; // Set default image if no image is uploaded
    }

    // Insert query
    $insert = "INSERT INTO properties (propertyName, price, area, image, beds, baths, garages)
               VALUES ('$pname', '$price', '$area', '$img_folder', '$beds', '$baths', '$garages')";

    if (mysqli_query($conn, $insert)) {
        echo "<script type='text/javascript'>
                alert('Property added successfully.');
                window.location.href = 'view.php';
              </script>";
    } else {
        echo "Error: " . $insert . "<br>" . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>
