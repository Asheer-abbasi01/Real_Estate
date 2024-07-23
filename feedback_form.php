<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="title-single">Send Your Feedback:</h1>
    <div class="col-sm-12 section-t8">
        <div class="row">
            <div class="col-md-7">
                <?php
                $host = "localhost";
                $user = "root";
                $pass = "";
                $db = "demo";

                $conn = mysqli_connect($host, $user, $pass, $db);

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $subject = $_POST['subject'];
                    $message = $_POST['message'];

                    $sql = "INSERT INTO feedback (name, email, subject, message) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $subject, $message);

                    if (mysqli_stmt_execute($stmt)) {
                        echo "<script>alert('Your message has been sent. Thank you!');</script>";
                    } else {
                        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                    }
                    mysqli_stmt_close($stmt);
                }
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form" class="php-email-form">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control form-control-lg form-control-a" placeholder="Your Name" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <input name="email" type="email" class="form-control form-control-lg form-control-a" placeholder="Your Email" required>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control form-control-lg form-control-a" placeholder="Subject" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="message" class="form-control" cols="45" rows="8" placeholder="Message" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-a">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

