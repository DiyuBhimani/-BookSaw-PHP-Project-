<?php

session_start();


// Check Login
if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();

}



$conn = new mysqli("localhost","root","","book");


if($conn->connect_error){

    die("Database Connection Failed : ".$conn->connect_error);

}



$user_id = $_SESSION['user_id'];




// =======================
// ADD TO CART
// =======================


if(isset($_GET['id'])){


    $b_id = intval($_GET['id']);



    if($b_id <= 0){

        echo "<script>
        alert('Invalid Book ID');
        window.location='books.php';
        </script>";

        exit();

    }




    // Fetch Book Details

    $stmt = $conn->prepare(

        "SELECT b_id, book_name, price, image
         FROM book
         WHERE b_id=?"

    );


    $stmt->bind_param("i",$b_id);


    $stmt->execute();


    $result = $stmt->get_result();




    if($result->num_rows == 0){


        echo "<script>
        alert('Book not found');
        window.location='books.php';
        </script>";

        exit();

    }




    $book = $result->fetch_assoc();



    $book_name  = $book['book_name'];

    $price      = $book['price'];

    $book_image = $book['image'];



    $quality = 1;

    $total_price = $price;




    // Check Existing Cart


    $check = $conn->prepare(

        "SELECT cart_id, quality
         FROM cart
         WHERE user_id=? AND b_id=?"

    );


    $check->bind_param(

        "ii",

        $user_id,

        $b_id

    );


    $check->execute();


    $exist = $check->get_result();





    if($exist->num_rows > 0){



        // Update Quantity


        $row = $exist->fetch_assoc();



        $new_quality = $row['quality'] + 1;


        $new_total = $price * $new_quality;



        $update = $conn->prepare(

            "UPDATE cart
             SET quality=?, total_price=?
             WHERE cart_id=? AND user_id=?"

        );



        $update->bind_param(

            "idii",

            $new_quality,

            $new_total,

            $row['cart_id'],

            $user_id

        );



        $update->execute();




    }else{



        // Insert New Cart Item


        $insert = $conn->prepare(

            "INSERT INTO cart
            (
                user_id,
                b_id,
                book_name,
                book_price,
                quality,
                total_price,
                book_image
            )
            VALUES(?,?,?,?,?,?,?)"

        );



        $insert->bind_param(

            "iisdiis",

            $user_id,

            $b_id,

            $book_name,

            $price,

            $quality,

            $total_price,

            $book_image

        );



        if(!$insert->execute()){

            die("Cart Insert Error : ".$insert->error);

        }


    }



    echo "

    <script>

    alert('Book added to cart successfully');

    window.location='addtocart.php';

    </script>

    ";


    exit();


}

?>
<?php


// =======================
// INCREASE QUANTITY
// =======================


if(isset($_GET['action']) && $_GET['action']=="inc"){


    $cart_id = intval($_GET['cart_id']);



    $get = $conn->prepare(

        "SELECT c.quality, b.price
         FROM cart c
         JOIN book b ON c.b_id=b.b_id
         WHERE c.cart_id=? AND c.user_id=?"

    );



    $get->bind_param(

        "ii",

        $cart_id,

        $user_id

    );



    $get->execute();



    $data = $get->get_result();




    if($data->num_rows > 0){



        $row = $data->fetch_assoc();



        $quality = $row['quality'] + 1;



        $total = $row['price'] * $quality;




        $update = $conn->prepare(

            "UPDATE cart
             SET quality=?, total_price=?
             WHERE cart_id=? AND user_id=?"

        );



        $update->bind_param(

            "idii",

            $quality,

            $total,

            $cart_id,

            $user_id

        );



        $update->execute();



    }



    header("Location:addtocart.php");

    exit();


}





// =======================
// DECREASE QUANTITY
// =======================


if(isset($_GET['action']) && $_GET['action']=="dec"){



    $cart_id = intval($_GET['cart_id']);




    $get = $conn->prepare(

        "SELECT c.quality, b.price
         FROM cart c
         JOIN book b ON c.b_id=b.b_id
         WHERE c.cart_id=? AND c.user_id=?"

    );



    $get->bind_param(

        "ii",

        $cart_id,

        $user_id

    );



    $get->execute();



    $data = $get->get_result();





    if($data->num_rows > 0){



        $row = $data->fetch_assoc();




        if($row['quality'] > 1){



            $quality = $row['quality'] - 1;



            $total = $row['price'] * $quality;





            $update = $conn->prepare(

                "UPDATE cart
                 SET quality=?, total_price=?
                 WHERE cart_id=? AND user_id=?"

            );



            $update->bind_param(

                "idii",

                $quality,

                $total,

                $cart_id,

                $user_id

            );



            $update->execute();




        }else{



            $delete = $conn->prepare(

                "DELETE FROM cart
                 WHERE cart_id=? AND user_id=?"

            );



            $delete->bind_param(

                "ii",

                $cart_id,

                $user_id

            );



            $delete->execute();



        }



    }



    header("Location:addtocart.php");

    exit();


}





// =======================
// DELETE CART ITEM
// =======================


if(isset($_GET['delete_id'])){



    $cart_id = intval($_GET['delete_id']);




    $delete = $conn->prepare(

        "DELETE FROM cart
         WHERE cart_id=? AND user_id=?"

    );



    $delete->bind_param(

        "ii",

        $cart_id,

        $user_id

    );



    $delete->execute();




    header("Location:addtocart.php");

    exit();


}





// =======================
// CHECKOUT
// =======================


if(isset($_GET['checkout'])){


    $_SESSION['order_type']="cart";


    header("Location:order_now.php");


    exit();


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


<div class="container my-5">

    <h2 class="text-center mb-4 fw-bold">
        📚 Your Book Cart
    </h2>

    <?php
    $sql = "SELECT * FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $grand_total = 0;

    if ($result->num_rows > 0):
    ?>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">

            <div class="table-responsive shadow rounded">

                <table class="table table-bordered text-center align-middle mb-0">

                    <thead class="table-dark">
                        <tr>
                            <th>Image</th>
                            <th>Book Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php while ($row = $result->fetch_assoc()):
                        $total = (float) $row['total_price'];
                        $grand_total += $total;
                    ?>

                        <tr>
                            <!-- Book Image -->
                            <td class="p-3">
                                <img
                                    src="images/<?= htmlspecialchars(basename($row['book_image'])); ?>"
                                    width="80"
                                    height="100"
                                    class="rounded img-fluid"
                                    style="object-fit: contain;"
                                    alt="<?= htmlspecialchars($row['book_name']); ?>"
                                    onerror="this.onerror=null; this.src='images/no-image.png';">
                            </td>

                            <!-- Book Name -->
                            <td class="fw-bold px-3">
                                <?= htmlspecialchars($row['book_name']); ?>
                            </td>

                            <!-- Quantity Buttons -->
                            <td class="px-3">
                                <div class="d-inline-flex align-items-center justify-content-center gap-2">

                                    <a
                                        href="addtocart.php?action=dec&amp;cart_id=<?= (int) $row['cart_id']; ?>"
                                        class="btn btn-danger btn-sm px-2 py-0 lh-sm"
                                        aria-label="Decrease quantity">
                                        −
                                    </a>

                                    <span class="fw-bold">
                                        <?= (int) $row['quality']; ?>
                                    </span>

                                    <a
                                        href="addtocart.php?action=inc&amp;cart_id=<?= (int) $row['cart_id']; ?>"
                                        class="btn btn-success btn-sm px-2 py-0 lh-sm"
                                        aria-label="Increase quantity">
                                        +
                                    </a>

                                </div>
                            </td>

                            <!-- Total Price -->
                            <td class="px-3">
                                ₹<?= number_format($total, 2); ?>
                            </td>

                            <!-- Delete Button -->
                            <td class="p-3">
                                <a
                                    href="addtocart.php?delete_id=<?= (int) $row['cart_id']; ?>"
                                    class="btn btn-danger btn-sm text-nowrap"
                                    onclick="return confirm('Remove book?');">
                                    🗑 Delete
                                </a>
                            </td>
                        </tr>

                    <?php endwhile; ?>

                        <!-- Grand Total -->
                        <tr class="table-light">
                            <td colspan="3" class="text-end p-3">
                                <strong>Grand Total</strong>
                            </td>

                            <td colspan="2" class="text-start p-3">
                                <strong class="fs-5 fw-bold" style="color: #C5A990;">
                                    ₹<?= number_format($grand_total, 2); ?>
                                </strong>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Cart Actions -->
    <div class="text-center mt-4 d-flex justify-content-center gap-3 flex-wrap">

        <a href="books.php" class="btn btn-primary">
            ← Continue Shopping
        </a>

        <a href="order_now.php?cart=1" class="btn btn-success">
            Order Now
        </a>

    </div>

    <?php else: ?>

        <!-- Empty Cart -->
        <div class="text-center p-5">
            <h3>Your book cart is empty</h3>

            <a href="books.php" class="btn btn-primary mt-3">
                ← Back To Books
            </a>
        </div>

    <?php endif; ?>

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