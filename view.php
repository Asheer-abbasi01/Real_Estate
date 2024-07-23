<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "demo";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Management</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #343a40;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        td {
            background-color: #f8f9fa;
        }
        .img-box-a img {
            width: 100px;
            height: auto;
        }
        .action-links a {
            color: #28a745;
            text-decoration: none;
            margin: 0 5px;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
        <h2 class="text-center mt-5">Properties List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Property Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Area</th>
                    <th>Beds</th>
                    <th>Baths</th>
                    <th>Garages</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query = "SELECT * FROM properties";
                $data = mysqli_query($conn, $query);
                $result = mysqli_num_rows($data);
                if ($result) {
                    while($row = mysqli_fetch_array($data)){
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['propertyName']); ?></td>
                    <td>
                        <div class="img-box-a">
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Property Image" class="img-a img-fluid">
                        </div>
                    </td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['area']); ?></td>
                    <td><?php echo htmlspecialchars($row['beds']); ?></td>
                    <td><?php echo htmlspecialchars($row['baths']); ?></td>
                    <td><?php echo htmlspecialchars($row['garages']); ?></td>
                    <td class="action-links"><a href="update.php?id=<?php echo $row['id']; ?>">Edit</a></td>
                    <td class="action-links"><a onclick="return confirm('Are you sure you want to delete?')" href="delete.php?id=<?php echo $row['id']; ?>">Delete</a></td>
                </tr>
                <?php  
                    }
                } else {
                ?>
                <tr>
                    <td colspan="9">No record found</td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="admin.php" class="btn btn-primary">Move to Admin</a>
        </div>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>
