
<?php
$conn = mysqli_connect("localhost","root","","book");

if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
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

<?php

$conn = mysqli_connect("localhost", "root", "", "book");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

/* FETCH CATEGORIES */
$category_query = "SELECT * FROM categories ORDER BY name ASC";
$category_result = mysqli_query($conn, $category_query);

if (!$category_result) {
    die("Category Error: " . mysqli_error($conn));
}

?>

<!-- CATEGORY TABS -->
<ul class="tabs">

    <li data-tab-target="#all-genre" class="active tab">
        All Genre
    </li>

    <?php while($cat = mysqli_fetch_assoc($category_result)) { ?>

        <li data-tab-target="#cat<?= $cat['c_id']; ?>" class="tab">
            <?= htmlspecialchars($cat['name']); ?>
        </li>

    <?php } ?>

</ul>

<!-- ALL BOOKS -->
<div id="all-genre" data-tab-content class="active">

    <div class="row">

        <?php

        $all_books = mysqli_query($conn, "SELECT * FROM book ORDER BY b_id DESC");

        while($book = mysqli_fetch_assoc($all_books)) {

            $image = !empty($book['image']) ? $book['image'] : 'no-image.png';
        ?>

        <div class="col-md-3">

            <div class="product-item">

                <figure class="product-style">

                    
<div class="mx-auto d-flex align-items-center justify-content-center overflow-hidden"
     style="width: 200px; height: 250px; flex-shrink: 0;">

    <img
        src="images/<?php echo htmlspecialchars(basename($image)); ?>"
        class="w-100 h-100"
        alt="<?php echo htmlspecialchars($book['book_name']); ?>"
        style="object-fit: fill; display: block;">
</div>

                    <a href="book_detail.php?id=<?= $book['b_id']; ?>">
                        <button type="button" class="add-to-cart">
                            View
                        </button>
                    </a>

                </figure>

                <figcaption>

                    <h3>
                        <?= htmlspecialchars($book['book_name']); ?>
                    </h3>

                    <div class="item-price">
                        ₹<?= number_format($book['price'], 2); ?>
                    </div>

                </figcaption>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

<!-- CATEGORY WISE BOOKS -->

<?php

$category_list = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");

while($category = mysqli_fetch_assoc($category_list)) {

?>

<div id="cat<?= $category['c_id']; ?>" data-tab-content>

    <div class="row">

        <?php

        $c_id = $category['c_id'];

        $category_books = mysqli_query(
            $conn,
            "SELECT * FROM book WHERE c_id='$c_id' ORDER BY b_id DESC"
        );

        while($book = mysqli_fetch_assoc($category_books)) {

            $image = !empty($book['image']) ? $book['image'] : 'no-image.png';
        ?>

        <div class="col-md-3">

            <div class="product-item">

                <figure class="product-style">

                    


<div class="mx-auto d-flex align-items-center justify-content-center overflow-hidden"
     style="width: 200px; height: 250px;">

    <img
        src="images/<?php echo htmlspecialchars(basename($image)); ?>"
        class="img-fluid w-100 h-100"
        alt="<?php echo htmlspecialchars($book['book_name']); ?>"
        style="object-fit: fill;">
        
</div>

                    <a href="book_detail.php?id=<?= $book['b_id']; ?>">
                        <button type="button" class="add-to-cart">
                            View
                        </button>
                    </a>

                </figure>

                <figcaption>

                    <h3>
                        <?= htmlspecialchars($book['book_name']); ?>
                    </h3>

                    <div class="item-price">
                        ₹<?= number_format($book['price'], 2); ?>
                    </div>

                </figcaption>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

<?php } ?>
	
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