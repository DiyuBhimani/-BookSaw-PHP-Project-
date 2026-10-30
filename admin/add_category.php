<?php
include("connected.php");

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);

    if ($name !== '') {
        $stmt = mysqli_prepare($conn, "INSERT INTO categories (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $name);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: category.php?msg=Category%20Added");
            exit();
        } else {
            echo "Error: " . htmlspecialchars(mysqli_error($conn));
        }

        mysqli_stmt_close($stmt);
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


<main class="container mt-5" style="min-height: 70vh;">

        <h2 class="text-center mb-4">Add Category</h2>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                <div class="card shadow">
                    <div class="card-header bg-dark text-white py-3">
                        Add New Category
                    </div>

                    <div class="card-body p-4">

                        <form method="POST" action="">

                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <strong>Category Name</strong>
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control"
                                    placeholder="Enter category name"
                                    maxlength="255"
                                    required>
                            </div>

                            <!-- Equal-size Bootstrap buttons -->
      
<div class="d-flex justify-content-center gap-3 mt-4">
    <button type="submit" name="submit"
             class="btn btn-primary fw-bold d-flex align-items-center justify-content-center"
            style="width: 200px; height: 55px;">
        SAVE
    </button>

    <a href="category.php"
       class="btn btn-danger d-flex align-items-center justify-content-center text-decoration-none"
       style="width: 200px; height: 55px;">
        CANCEL
    </a>
</div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </main>
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