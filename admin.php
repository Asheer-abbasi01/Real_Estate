<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "demo";

$conn = mysqli_connect($host, $user, $pass, $db);

// Handle property deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_property'])) {
        $id = $_POST['property_id'];
        $sql = "DELETE FROM properties WHERE id='$id'";
        mysqli_query($conn, $sql);

    }


    if (isset($_POST['delete_user'])) {
        $id = $_POST['user_id'];
        $sql = "DELETE FROM register_page WHERE id='$id'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['delete_feedback'])) {
        $id = $_POST['feedback_id'];
        $sql = "DELETE FROM feedback WHERE id='$id'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['delete_purchased_property'])) {
        $id = $_POST['purchased_property_id'];
        $sql = "DELETE FROM purchasing_form WHERE id='$id'";
        mysqli_query($conn, $sql);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $propertyName = $_POST['propertyName'];
    $price = $_POST['price'];
    $area = $_POST['area'];
    $beds = $_POST['beds'];
    $baths = $_POST['baths'];
    $garages = $_POST['garages'];
    $image = $_FILES['image']['name']; // Get the name of the uploaded image file
    $target_dir = "assets/img/"; // Directory where images will be stored

    // Move uploaded file to the specified directory
    $target_file = $target_dir . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert property details into the database
        $sql = "INSERT INTO properties (propertyName, price, area, beds, baths, garages, image) 
                VALUES ('$propertyName', '$price', '$area', '$beds', '$baths', '$garages', '$image')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Property added successfully";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
        .img-thumbnail {
            width: 100px;
            height: auto;
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
            <div class="container">
                <h2 class="mt-4">Dashboard</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-dark mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Properties</h5>
                                <p class="card-text">10k</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <p class="card-text">50k</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-body">
                                <h5 class="card-title">New Messages</h5>
                                <p class="card-text">25</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h3>Properties</h3>
<table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Property Name</th>
            <th>Images</th>
            <th>Price</th>
            <th>Area</th>
            <th>Beds</th>
            <th>Baths</th>
            <th>Garages</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM properties";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["propertyName"] . "</td>";
                echo "<td><img src='assets/img/" . htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8') . "' class='img-thumbnail' alt='Property Image' style='width: 100px; height: auto;'></td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "<td>" . $row["area"] . "</td>";
                echo "<td>" . $row["beds"] . "</td>";
                echo "<td>" . $row["baths"] . "</td>";
                echo "<td>" . $row["garages"] . "</td>";
                echo "<td>
                        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>
                            <input type='hidden' name='property_id' value='" . $row["id"] . "'>
                            <button type='submit' name='edit_property' class='btn btn-primary btn-sm'>Edit</button>
                            <button type='submit' name='delete_property' class='btn btn-danger btn-sm'>Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No properties found</td></tr>";
        }
        ?>
    </tbody>
</table>
<div class="text-center mt-4">
    <a href="add_property.php" class="btn btn-green">Add New Property</a>
</div>

                <h3>Users</h3>
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM register_page";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>
                                        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>
                                            <input type='hidden' name='user_id' value='" . $row["id"] . "'>
                                            <button type='submit' name='delete_user' class='btn btn-danger btn-sm'>Delete</button>
                                        </form>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No users found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <h3>Feedback</h3>
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM feedback";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["message"] . "</td>";
                                echo "<td>
                                        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>
                                            <input type='hidden' name='feedback_id' value='" . $row["id"] . "'>
                                            <button type='submit' name='delete_feedback' class='btn btn-danger btn-sm'>Delete</button>
                                        </form>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No feedback found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <h3>Purchased Properties</h3>
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Property Name</th>
                            <th>Price</th>
                            <th>Contact Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM purchasing_form";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["propertyName"] . "</td>";
                                echo "<td>" . $row["price"] . "</td>";
                                echo "<td>" . $row["contact"] . "</td>";
                                echo "<td>
                                        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>
                                            <input type='hidden' name='purchased_property_id' value='" . $row["id"] . "'>
                                            <button type='submit' name='delete_purchased_property' class='btn btn-danger btn-sm'>Delete</button>
                                        </form>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No purchased properties found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>



<!-- <a href='update_user.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a> -->



