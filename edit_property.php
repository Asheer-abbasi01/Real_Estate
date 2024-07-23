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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_property'])) {
    $id = $_POST['id'];
    $propertyName = $_POST['propertyName'];
    $price = $_POST['price'];
    $area = $_POST['area'];
    $beds = $_POST['beds'];
    $baths = $_POST['baths'];
    $garages = $_POST['garages'];

    $sql = "UPDATE properties SET propertyName='$propertyName', price='$price', area='$area', beds='$beds', baths='$baths', garages='$garages' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "Property updated successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$id = $_GET['id'];
$sql = "SELECT * FROM properties WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$property = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Property</h2>
        <form method="POST" action="edit_property.php">
            <input type="hidden" name="id" value="<?php echo $property['id']; ?>">
            <div class="form-group">
                <label>Property Name</label>
                <input type="text" name="propertyName" class="form-control" value="<?php echo $property['propertyName']; ?>" required>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" class="form-control" value="<?php echo $property['price']; ?>" required>
            </div>
            <div class="form-group">
                <label>Area</label>
                <input type="text" name="area" class="form-control" value="<?php echo $property['area']; ?>" required>
            </div>
            <div class="form-group">
                <label>Beds</label>
                <input type="number" name="beds" class="form-control" value="<?php echo $property['beds']; ?>" required>
            </div>
            <div class="form-group">
                <label>Baths</label>
                <input type="number" name="baths" class="form-control" value="<?php echo $property['baths']; ?>" required>
            </div>
            <div class="form-group">
                <label>Garages</label>
                <input type="number" name="garages" class="form-control" value="<?php echo $property['garages']; ?>" required>
            </div>
            <button type="submit" name="update_property" class="btn btn-primary">Update Property</button>
        </form>
    </div>
</body>
</html>
