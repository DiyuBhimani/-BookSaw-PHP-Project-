<?php
include("connected.php");

/* FETCH CATEGORIES */
$categories_query = "SELECT * FROM categories ORDER BY name ASC";
$categories_result = mysqli_query($conn, $categories_query);

if (!$categories_result) {
    die("Category Error: " . mysqli_error($conn));
}

/* ADD BOOK */
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $c_id = intval($_POST['c_id']);
    $book_name = mysqli_real_escape_string($conn, $_POST['book_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);

    $image_name = "";

    /* IMAGE UPLOAD */
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        $image_name = time() . "_" . basename($_FILES['image']['name']);

        // Image folder
        $upload_path = "../images/";

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $target = $upload_path . $image_name;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            die("Image Upload Failed");
        }
    }

    /* INSERT BOOK DATA */
    $query = "INSERT INTO book
                (c_id, book_name, description, price, image)
              VALUES
                ('$c_id',
                 '$book_name',
                 '$description',
                 '$price',
                 '$image_name')";

    $result = mysqli_query($conn, $query);

    if ($result) {

        echo "<script>
                alert('Book Added Successfully');
                window.location.href='books.php';
              </script>";
        exit();

    } else {

        die("Database Insert Error: " . mysqli_error($conn));

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

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <!-- Form Heading -->
            <h2 class="text-center mb-4">Add Books</h2>

            <!-- Centered Form -->
            <div class="card bg-white border-0 shadow-sm">
                <div class="card-body p-4">

                    <form action="" method="POST" enctype="multipart/form-data">

                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Category:</label>

                            <select name="c_id" class="form-select" required>
                                <option value="" selected disabled>
                                    Select category
                                </option>

                                <?php while ($cat = mysqli_fetch_assoc($categories_result)) { ?>
                                    <option value="<?= $cat['c_id']; ?>">
                                        <?= htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Book Name -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Book Name:</label>

                            <input type="text"
                                   name="book_name"
                                   class="form-control"
                                   placeholder="Enter book name"
                                   autocomplete="off"
                                   required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description:</label>

                            <textarea name="description"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Enter book description"
                                      required></textarea>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Price (₹):</label>

                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   name="price"
                                   class="form-control"
                                   placeholder="Enter book price"
                                   required>
                        </div>

                        <!-- Book Image -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Book Image:</label>

                            <input type="file"
                                   name="image"
                                   class="form-control"
                                   accept="image/*"
                                   required>
                        </div>

                        <!-- Buttons: same color, size and line -->
                        
<div class="d-flex flex-row justify-content-start align-items-center gap-2 mt-4"
     style="display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            flex-wrap: nowrap !important;">

    <button type="submit"
            class="btn text-white fw-bold"
            style="background-color: #c5a990 !important;
                   border: none !important;
                   width: 150px !important;
                   min-width: 150px;
                   height: 46px !important;
                   margin: 0 !important;
                   padding: 0 !important;
                   display: inline-flex !important;
                   align-items: center;
                   justify-content: center;
                   white-space: nowrap;">
        ADD BOOK 
    </button>

    <a href="books.php"
       class="btn text-white fw-bold"
       style="background-color: #c5a990 !important;
              border: none !important;
              width: 150px !important;
              min-width: 150px;
              height: 46px !important;
              margin: 0 !important;
              padding: 0 !important;
              display: inline-flex !important;
              align-items: center;
              justify-content: center;
              white-space: nowrap;
              text-decoration: none;">
        CANCEL 
    </a>

</div>

                    </form>

                </div>
            </div>

        </div>
    </div>

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