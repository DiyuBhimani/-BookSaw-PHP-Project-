<?php
include("connected.php");

/* ===== VALIDATE CATEGORY ID ===== */
if (!isset($_GET['c_id']) || !is_numeric($_GET['c_id'])) {
    die("Invalid Category ID!");
}

$c_id = (int) $_GET['c_id'];

/* ===== FETCH CATEGORY ===== */
$result = mysqli_query($conn, "SELECT * FROM categories WHERE c_id=$c_id");

if (!$row = mysqli_fetch_assoc($result)) {
    die("Category not found!");
}

/* ===== UPDATE CATEGORY ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    if (mysqli_query($conn, "UPDATE categories SET name='$name' WHERE c_id=$c_id")) {
        header("Location: category.php?msg=Category Updated Successfully");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
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
            <h2 class="mb-0">Edit Category</h2>
        </div>

           </div>


    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name"
                       value="<?= htmlspecialchars($row['name']) ?>"
                       class="form-control"
                       required>
            </div>

            


<div class="d-flex flex-row align-items-center justify-content-start gap-2 mt-4">

    <button type="submit"
            class="btn fw-bold text-white p-0 flex-shrink-0"
            style="background-color: #c5a990; width: 120px !important; height: 45px !important; margin: 0 !important;">
        UPDATE
    </button>

    <a href="category.php"
       class="btn fw-bold text-white d-inline-flex align-items-center justify-content-center flex-shrink-0 p-0"
       style="background-color: #c5a990; width: 120px !important; height: 45px !important; margin: 0 !important;">
        CANCEL
    </a>

</div>

        </form>
    </div>
</div>

<footer id="footer">
		<div class="container">
			<div class="row">

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
			<!-- / row -->

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