<?php
include("connected.php");

// Get book id
$b_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($b_id <= 0){
    echo "Invalid book item.";
    exit();
}

// Fetch book details
$query = "SELECT * FROM book WHERE b_id=$b_id LIMIT 1";

$result = mysqli_query($conn, $query);

if(!$result || mysqli_num_rows($result)==0){
    echo "Book not found.";
    exit();
}

$book = mysqli_fetch_assoc($result);

// Prepare values
$safeName = htmlspecialchars($book['book_name']);

$imgFile = !empty($book['image']) 
        ? "images/".$book['image'] 
        : "images/no-image.png";

$price = number_format($book['price'], 2);

$description = !empty($book['description']) 
        ? nl2br(htmlspecialchars($book['description']))
        : "<em>No description available.</em>";

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
									<li class="menu-item active"><a href="about.php">ABOUT US</a></li>
									<li class="menu-item active"><a href="books.php">BOOKS</a></li>
									<li class="menu-item active"><a href="contactus.php">CONTACT US</a></li>
									<li class="menu-item active"><a href="login.php">LOGOUT</a></li>
										
									
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

<!-- BOOK DETAIL SECTION -->
<div class="container my-5">
    <div class="row g-4 align-items-start detail-card">

        <!-- IMAGE SIDE -->
        <div class="col-md-5 text-center">
            <img src="<?= htmlspecialchars($imgFile); ?>"
                 alt="<?= $safeName; ?>"
                 class="img-fluid rounded shadow"
                 style="width:320px; height:500px; object-fit:contain;"
                 onerror="this.src='images/no-image.png';">
        </div>

        <!-- INFORMATION SIDE -->
        <div class="col-md-7">
            <h2><?= $safeName; ?></h2>

            <h4 class="price">
                Price: ₹<?= $price; ?>
            </h4>

            <div class="description mt-4">
                <h5>Description</h5>
                <p><?= $description; ?></p>
            </div>

            <!-- BUTTONS -->
            <div class="d-flex flex-row align-items-center gap-3 flex-wrap mt-4">

                <form action="addtocart.php" method="GET"
      class="d-flex flex-row align-items-center gap-2 flex-wrap">

    <input type="hidden" name="id" value="<?= $book['b_id']; ?>">

    <button type="submit"
            class="btn btn-primary m-0 fw-bold"
            style="width: 130px; height: 44px; padding: 0;">
        Add to Cart
    </button>

   <a href="order_now.php?b_id=<?= $book['b_id']; ?>"
   class="btn m-0 d-inline-flex align-items-center justify-content-center fw-bold text-white"
   style="width:130px; height:44px; padding:0; background-color:#C5A990; border-color:#C5A990;">
    Buy Now
</a>
</form>

            </div>
        </div>

    </div>
</div>



<footer id="footer">
    <div class="container">
        <div class="row">

            <!-- Logo and Description -->
            <div class="col-md-4">
                <div class="company-brand">
                    <img src="images/main-logo.png" alt="logo" class="footer-logo">
                    <p>Discover your next favorite book at <strong>BOOKSAW</strong>.
                       From timeless classics to the latest bestsellers,
                       we offer books for every reader. Read, learn, and grow with us.</p>
                </div>
            </div>

            <!-- About Us -->
            <div class="col-md-2">
                <div class="footer-menu">
                    <h5>About Us</h5>
                    <ul class="menu-list">
                        <li><a href="#">Vision</a></li>
                        <li><a href="#">Articles</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
            </div>

            <!-- Discover -->
            <div class="col-md-2">
                <div class="footer-menu">
                    <h5>Discover</h5>
                    <ul class="menu-list">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="books.php">Books</a></li>
                        <li><a href="#">Authors</a></li>
                     </ul>
                </div>
            </div>

            <!-- My Account -->
            <div class="col-md-2">
                <div class="footer-menu">
                    <h5>My Account</h5>
                    <ul class="menu-list">
                        <li><a href="login.php">Sign In</a></li>
                        <li><a href="addtocart.php">View Cart</a></li>
                        
                    </ul>
                </div>
            </div>

            <!-- Help -->
            <div class="col-md-2">
                <div class="footer-menu">
                    <h5>Help</h5>
                    <ul class="menu-list">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Report a Problem</a></li>
                        <li><a href="contactus.php">Contact Us</a></li>
                    </ul>
                </div>
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