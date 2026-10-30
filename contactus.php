<?php
$success = "";
$error = "";

$conn = mysqli_connect("localhost", "root", "", "book");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['send'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO contact (name, email, message)
              VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conn, $query)) {
        $success = "Your message has been sent successfully!";
    } else {
        $error = "Message not sent: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
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
<!-- Contact Us Section -->
<section id="contact-us" class="padding-large">
    <div class="container">

        <!-- Heading -->
        <div class="text-center mb-5">
            <h5 class="text-uppercase text-primary">Get In Touch</h5>
            <h2>Contact Us</h2>
            <p class="text-muted">
                Have a question or need assistance? Fill out the form below and we'll get back to you as soon as possible.
            </p>
        </div>

        <div class="row justify-content-center">

            <div class="col-lg-8">
                <div class="card shadow border-0">
                    <div class="card-body p-5">

                        <h4 class="mb-4 text-center">Send us a Message</h4>

                        <form method="POST" action="">

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <input type="text"
                                           name="name"
                                           class="form-control form-control-lg"
                                           placeholder="Your Name"
                                           required>
                                </div>

                                <div class="col-md-6">
                                    <input type="email"
                                           name="email"
                                           class="form-control form-control-lg"
                                           placeholder="Your Email"
                                           required>
                                </div>

                                <div class="col-12">
                                    <textarea
                                        name="message"
                                        class="form-control"
                                        rows="6"
                                        placeholder="Write your message..."
                                        required></textarea>
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit"
                                            name="send"
                                            class="btn btn-primary btn-lg px-5">
                                        Send Message
                                    </button>
                                </div>

                            </div>

                        </form>

                        <?php if (!empty($success)) { ?>
                            <div class="alert alert-success mt-3">
                                <?php echo $success; ?>
                            </div>
                        <?php } ?>

                        <?php if (!empty($error)) { ?>
                            <div class="alert alert-danger mt-3">
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

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