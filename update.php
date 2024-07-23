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

$id = $_GET['id'];
$select = "SELECT * FROM properties WHERE id = '$id'";
$data = mysqli_query($conn, $select);
$row = mysqli_fetch_array($data);

// Handle form submission
if (isset($_POST['update_btn'])) {
    $pname = $_POST['propertyName'];
    $price = $_POST['price'];
    $area = $_POST['area'];
    $beds = $_POST['beds'];
    $baths = $_POST['baths'];
    $garages = $_POST['garages'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $img = $_FILES['image']['name'];
        $img_tmp = $_FILES['image']['tmp_name'];
        $img_extension = pathinfo($img, PATHINFO_EXTENSION);
        $unique_img_name = uniqid('property-', true) . '.' . $img_extension;
        $img_folder = "asset/img/" . $unique_img_name;

        // Move the uploaded file to the specified folder
        if (move_uploaded_file($img_tmp, $img_folder)) {
            echo "File is valid and was successfully uploaded.";
        } else {
            echo "File upload failed.";
            $unique_img_name = $row['image']; // Keep the existing image if upload fails
        }
    } else {
        $unique_img_name = $row['image']; // Keep the existing image if no new image is uploaded
    }

    // Update query
    $update = "UPDATE properties SET propertyName='$pname', price='$price', area='$area', image='$unique_img_name', beds='$beds', baths='$baths', garages='$garages' WHERE id='$id'";
    $data = mysqli_query($conn, $update) or die("Query unsuccessful: " . mysqli_error($conn));

    if ($data) {
        echo "<script type='text/javascript'>
                alert('Data updated successfully.');
                window.open('admin.php', '_self');
              </script>";
    } else {
        echo "<script type='text/javascript'>
                alert('Please try again.');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Property</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ffffff;
            color: #000000;
        }
        .container {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #28a745;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
        .btn-secondary {
            background-color: #343a40;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #23272b;
        }
        .form-control {
            border: 1px solid #343a40;
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: none;
        }
        label {
            color: #343a40;
        }
        .current-image {
            max-width: 100px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Update Property</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="propertyName">Property Name</label>
                    <input value="<?php echo htmlspecialchars($row['propertyName']); ?>" type="text" class="form-control" id="propertyName" name="propertyName" placeholder="Enter Property Name" required>
                </div>
                <div class="form-group">
                    <label for="image">Current Image</label><br>
                    <img src="asset/img/<?php echo htmlspecialchars($row['image']); ?>" alt="Current Image" class="current-image"><br>
                    <label for="image">Upload New Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input value="<?php echo htmlspecialchars($row['price']); ?>" type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Enter Price" required>
                </div>
                <div class="form-group">
                    <label for="area">Area</label>
                    <input value="<?php echo htmlspecialchars($row['area']); ?>" type="number" class="form-control" id="area" name="area" placeholder="Enter Area" required>
                </div>
                <div class="form-group">
                    <label for="beds">Beds</label>
                    <input value="<?php echo htmlspecialchars($row['beds']); ?>" type="number" class="form-control" id="beds" name="beds" placeholder="Enter Number of Beds" required>
                </div>
                <div class="form-group">
                    <label for="baths">Baths</label>
                    <input value="<?php echo htmlspecialchars($row['baths']); ?>" type="number" class="form-control" id="baths" name="baths" placeholder="Enter Number of Baths" required>
                </div>
                <div class="form-group">
                    <label for="garages">Garages</label>
                    <input value="<?php echo htmlspecialchars($row['garages']); ?>" type="number" class="form-control" id="garages" name="garages" placeholder="Enter Number of Garages" required>
                </div>
                <button type="submit" name="update_btn" class="btn btn-primary">Update</button>
                <a href="admin.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
