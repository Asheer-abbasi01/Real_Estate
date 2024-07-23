<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "demo";

$conn = mysqli_connect($host, $user, $pass, $db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keyword = $_POST['keyword'];
    $type = $_POST['type'];
    $city = $_POST['city'];
    $bedrooms = $_POST['bedrooms'];
    $garages = $_POST['garages'];
    $bathrooms = $_POST['bathrooms'];
    $price = $_POST['price'];

    $sql = "SELECT * FROM properties WHERE 1=1";
    
    if (!empty($keyword)) {
        $sql .= " AND propertyName LIKE '%$keyword%'";
    }
    if ($type != 'All Type') {
        $sql .= " AND type='$type'";
    }
    if ($city != 'All City') {
        $sql .= " AND city='$city'";
    }
    if ($bedrooms != 'Any') {
        $sql .= " AND beds='$bedrooms'";
    }
    if ($garages != 'Any') {
        $sql .= " AND garages='$garages'";
    }
    if ($bathrooms != 'Any') {
        $sql .= " AND baths='$bathrooms'";
    }
    if ($price != 'Unlimited') {
        $sql .= " AND price <= " . str_replace(['$', ','], '', $price);
    }

    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Property</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Search Property</h2>
    <div class="box-collapse-wrap form">
      <form class="form-a" method="POST">
        <div class="row">
          <div class="col-md-12 mb-2">
            <div class="form-group">
              <label class="pb-2" for="keyword">Keyword</label>
              <input type="text" class="form-control form-control-lg form-control-a" id="keyword" name="keyword" placeholder="Keyword">
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group mt-3">
              <label class="pb-2" for="type">Type</label>
              <select class="form-control form-select form-control-a" id="type" name="type">
                <option>All Type</option>
                <option>For Rent</option>
                <option>For Sale</option>
                <option>Open House</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group mt-3">
              <label class="pb-2" for="city">City</label>
              <select class="form-control form-select form-control-a" id="city" name="city">
                <option>All City</option>
                <option>Alabama</option>
                <option>Arizona</option>
                <option>California</option>
                <option>Colorado</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group mt-3">
              <label class="pb-2" for="bedrooms">Bedrooms</label>
              <select class="form-control form-select form-control-a" id="bedrooms" name="bedrooms">
                <option>Any</option>
                <option>01</option>
                <option>02</option>
                <option>03</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group mt-3">
              <label class="pb-2" for="garages">Garages</label>
              <select class="form-control form-select form-control-a" id="garages" name="garages">
                <option>Any</option>
                <option>01</option>
                <option>02</option>
                <option>03</option>
                <option>04</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group mt-3">
              <label class="pb-2" for="bathrooms">Bathrooms</label>
              <select class="form-control form-select form-control-a" id="bathrooms" name="bathrooms">
                <option>Any</option>
                <option>01</option>
                <option>02</option>
                <option>03</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group mt-3">
              <label class="pb-2" for="price">Min Price</label>
              <select class="form-control form-select form-control-a" id="price" name="price">
                <option>Unlimited</option>
                <option>$50,000</option>
                <option>$100,000</option>
                <option>$150,000</option>
                <option>$200,000</option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-b">Search Property</button>
          </div>
        </div>
      </form>
    </div>
</div>

<div class="container mt-5">
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <h2 class="text-center">Search Results</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Property Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Area</th>
                        <th>Beds</th>
                        <th>Baths</th>
                        <th>Garages</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['propertyName']; ?></td>
                            <td><img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['propertyName']; ?>" width="100"></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['area']; ?></td>
                            <td><?php echo $row['beds']; ?></td>
                            <td><?php echo $row['baths']; ?></td>
                            <td><?php echo $row['garages']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h2 class="text-center">No properties found matching your criteria.</h2>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
