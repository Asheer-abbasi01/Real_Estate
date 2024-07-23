
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit();
}

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "demo";

$conn = mysqli_connect($host, $user, $pass, $db);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $propertyName = $_POST['propertyName'];
    $price = $_POST['price'];
    $area = $_POST['area'];
    $beds = $_POST['beds'];
    $baths = $_POST['baths'];
    $garages = $_POST['garages'];

    // Image upload
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_error = $_FILES['image']['error'];
    $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));

    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($image_ext, $allowed_ext)) {
        if ($image_error === 0) {
            if ($image_size < 5000000) { // Limit to 5MB
                $image_new_name = uniqid('property-', true) . "." . $image_ext;
                $image_destination = 'assets/img/' . $image_new_name;

                if (move_uploaded_file($image_tmp_name, $image_destination)) {
                    $sql = "INSERT INTO properties (propertyName, image, price, area, beds, baths, garages) 
                            VALUES ('$propertyName', '$image_new_name', '$price', '$area', '$beds', '$baths', '$garages')";

                    if (mysqli_query($conn, $sql)) {
                        echo "Property added successfully!";
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                } else {
                    echo "Failed to move uploaded file.";
                }
            } else {
                echo "File size too large.";
            }
        } else {
            echo "Error uploading file: " . $image_error;
        }
    } else {
        echo "Invalid file type.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar a {
            color: white;
        }
        .content {
            padding: 20px;
        }
        .card {
            margin-top: 20px;
        }
        .btn-green {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        .btn-green:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .navbar {
            background-color: #343a40;
            color: white;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #28a745; /* Green color for headings */
            font-weight: bold;
        }
        .form-control, .form-control-file, .btn {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #28a745; /* Green button */
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar p-3">
            <h3>Admin Panel</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
        
        <div class="content flex-grow-1">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="admin.php">Admin Panel</a>
            </nav>

            <!-- Main Content -->
            <div class="container mt-5">
                <h2 class="text-center">Add Property</h2>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="propertyName">Property Name</label>
                                <input type="text" class="form-control" id="propertyName" name="propertyName" placeholder="Enter Property Name" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control-file" id="image" name="image" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Enter Price" required>
                            </div>
                            <div class="form-group">
                                <label for="area">Area</label>
                                <input type="number" class="form-control" id="area" name="area" placeholder="Enter Area" required>
                            </div>
                            <div class="form-group">
                                <label for="beds">Beds</label>
                                <input type="number" class="form-control" id="beds" name="beds" placeholder="Enter Number of Beds" required>
                            </div>
                            <div class="form-group">
                                <label for="baths">Baths</label>
                                <input type="number" class="form-control" id="baths" name="baths" placeholder="Enter Number of Baths" required>
                            </div>
                            <div class="form-group">
                                <label for="garages">Garages</label>
                                <input type="number" class="form-control" id="garages" name="garages" placeholder="Enter Number of Garages" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            <a href="admin.php" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>



