<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "book");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: /freshshop/login.php");
    exit();
}

$result = $conn->query("SELECT id, username, email_id, mobile_no, city, pincode, address FROM user");
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>BookSaw - Free Book Store HTML CSS Template</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="author" content="">
	<meta name="keywords" content="">
	<meta name="description" content="">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="icomoon/icomoon.css">
	<link rel="stylesheet" type="text/css" href="css/vendor.css">
	<link rel="stylesheet" type="text/css" href="style.css">

</head>

					
					
		<header id="header">
			<div class="container-fluid">
				<div class="row">

					<div class="col-md-2">
						<div class="main-logo">
							<a href="index.html"><img src="images/main-logo.png" alt="logo"></a>
						</div>

					</div>

					<div class="col-md-10">

						<nav id="navbar">
							<div class="main-menu stellarnav">
								<ul class="menu-list">
									<li class="menu-item active"><a href="index.php">Home</a></li>
									<li class="menu-item active"><a href="user.php">USER</a></li>
									<li class="menu-item active"><a href="category.php">CATEGORY</a></li>
									<li class="menu-item active"><a href="book.php">BOOKS</a></li>
									<li class="menu-item active"><a href="shipping.php">ORDERS</a></li>
									<li class="menu-item active"><a href="feedback.php">FEEDBACK</a></li>
									<li class="menu-item active"><a href="logout.php">LOGOUT</a></li>
								</ul>

								<div class="hamburger">
									<span class="bar"></span>
									<span class="bar"></span>
									<span class="bar"></span>
								</div>

							</div>
						</nav>

					</div>

				</div>
			</div>
		</header>

	</div><!--header-wrap-->
<div class="container py-5" style="min-height: 70vh;">

    <div class="d-flex justify-content-between align-items-center mb-4 position-relative">
        <div style="flex: 1; text-align: center;">
            <h2 class="mb-0">Registered Users</h2>
        </div>

           </div>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Mobile No.</th>
                <th>City</th>
                <th>Pincode</th>
                <th>Address</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['email_id']) ?></td>
                        <td><?= htmlspecialchars($row['mobile_no']) ?></td>
                        <td><?= htmlspecialchars($row['city']) ?></td>
                        <td><?= htmlspecialchars($row['pincode']) ?></td>
                        <td><?= htmlspecialchars($row['address']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<footer id="footer">
    <div class="container">
        <div class="row">

            <!-- Admin Panel -->
             <!-- Admin Panel -->
      <div class="footer-info text-center">
      <p>
        Developed by <strong>Diya Bhimani</strong><br>
        © <span id="displayYear"></span> BOOKSAW |
        <a href="https://www.booksaw.com" target="_blank">
          www.booksaw.com
        </a>
      </p>
      </div>


        </div>
    </div>
</footer>

	<script src="js/jquery-1.11.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
		crossorigin="anonymous"></script>
	<script src="js/plugins.js"></script>
	<script src="js/script.js"></script>

</body>

</html>	