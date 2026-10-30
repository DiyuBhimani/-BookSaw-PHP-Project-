<?php
include("connected.php");

/* FETCH CATEGORIES */
$categories_query = "SELECT c_id, name FROM categories ORDER BY name ASC";
$categories_result = mysqli_query($conn, $categories_query);

if (!$categories_result) {
    die("Category Query Error: " . mysqli_error($conn));
}

/* FILTER */
$filter_category = isset($_GET['c_id']) ? intval($_GET['c_id']) : 0;

/* BOOK QUERY */
$sql = "SELECT
            b.b_id,
            b.book_name,
            b.description,
            b.price,
            b.image,
            c.name AS category_name
        FROM book AS b
        INNER JOIN categories AS c
            ON b.c_id = c.c_id";

if ($filter_category > 0) {
    $sql .= " WHERE b.c_id = $filter_category";
}

$sql .= " ORDER BY b.b_id DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Book Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>BookSaw - Books</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Existing stylesheets -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="icomoon/icomoon.css">
    <link rel="stylesheet" href="css/vendor.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- HEADER -->
<header id="header">
    <div class="container-fluid">
        <div class="row align-items-center">

            <div class="col-md-2">
                <div class="main-logo">
                    <a href="index.html">
                        <img src="images/main-logo.png" alt="logo">
                    </a>
                </div>
            </div>

            <div class="col-md-10">
                <nav id="navbar">
                    <div class="main-menu stellarnav">

                        <ul class="menu-list">
                            <li class="menu-item"><a href="index.php">HOME</a></li>
                            <li class="menu-item"><a href="user.php">USER</a></li>
                            <li class="menu-item"><a href="category.php">CATEGORY</a></li>
                            <li class="menu-item"><a href="book.php">BOOKS</a></li>
                            <li class="menu-item"><a href="shipping.php">ORDERS</a></li>
                            <li class="menu-item"><a href="feedback.php">FEEDBACK</a></li>
                            <li class="menu-item"><a href="logout.php">LOGOUT</a></li>
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

<!-- MAIN CONTENT -->
<div class="container-fluid px-3 px-md-5 py-5">

    <!-- PAGE TITLE -->
    <h2 class="text-center mb-5">Books</h2>

    <!-- ADD BOOK BUTTON: CENTERED -->
    <div class="d-flex justify-content-center mb-4">

        <a href="add_books.php"
           class="btn btn-dark rounded-0 d-inline-flex align-items-center justify-content-center"
           style="width:130px; height:45px;">
            Add Book
        </a>

    </div>

    <!-- CATEGORY FILTER -->
    <form method="GET"
          action="book.php"
          class="row justify-content-center g-3 mb-5">

        <!-- CATEGORY DROPDOWN -->
        <div class="col-12 col-md-8 col-lg-6">

            <select name="c_id" class="form-select">

                <option value="">All Categories</option>

                <?php while ($cat = mysqli_fetch_assoc($categories_result)) { ?>

                    <option
                        value="<?= (int)$cat['c_id']; ?>"
                        <?= ($filter_category == $cat['c_id']) ? 'selected' : ''; ?>>

                        <?= htmlspecialchars($cat['name']); ?>

                    </option>

                <?php } ?>

            </select>

        </div>

        <!-- SEARCH AND CLEAR BUTTONS -->
        <div class="col-12 d-flex justify-content-center gap-2">

            <button type="submit"
                     class="btn btn-primary fw-bold d-flex align-items-center justify-content-center"
                    style="width:130px; height:45px;">
                Search
            </button>

            <a href="book.php"
               class="btn btn-danger rounded-0 d-inline-flex align-items-center justify-content-center"
               style="width:130px; height:45px;">
                Clear
            </a>

        </div>

    </form>

    <!-- CENTERED BOOK TABLE -->
    <div class="row justify-content-center">

        <div class="col-12">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Book Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (mysqli_num_rows($result) > 0) { ?>

                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                            <tr>

                                <!-- ID -->
                                <td>
                                    <?= (int)$row['b_id']; ?>
                                </td>

                                <!-- IMAGE -->
                                <td>
                                    <?php if (!empty($row['image'])) { ?>

                                        <img
                                            src="../images/<?= htmlspecialchars($row['image']); ?>"
                                            width="75"
                                            height="100"
                                            class="img-fluid"
                                            style="object-fit:contain;"
                                            alt="Book Image">

                                    <?php } else { ?>

                                        No Image

                                    <?php } ?>
                                </td>

                                <!-- CATEGORY -->
                                <td>
                                    <?= htmlspecialchars($row['category_name']); ?>
                                </td>

                                <!-- BOOK NAME -->
                                <td>
                                    <?= htmlspecialchars($row['book_name']); ?>
                                </td>

                                <!-- DESCRIPTION -->
                                <td>
                                    <?= htmlspecialchars($row['description']); ?>
                                </td>

                                <!-- PRICE -->
                                <td class="text-nowrap">
                                    ₹<?= number_format((float)$row['price'], 2); ?>
                                </td>

                                <!-- ACTION BUTTONS -->
                                <td>

                                    <div class="d-flex flex-column align-items-center gap-2">

                                        <a
                                            href="edit_book.php?b_id=<?= (int)$row['b_id']; ?>"
                                            class="btn btn-primary btn-sm rounded-0 d-inline-flex align-items-center justify-content-center"
                                            style="width:130px; height:45px;">
                                            Edit
                                        </a>

                                        <a
                                            href="delete_book.php?b_id=<?= (int)$row['b_id']; ?>"
                                            onclick="return confirm('Delete this book?');"
                                            class="btn btn-danger btn-sm rounded-0 d-inline-flex align-items-center justify-content-center"
                                            style="width:130px; height:45px;">
                                            Delete
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>
                            <td colspan="7" class="text-center py-4">
                                No books found.
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- FOOTER -->
<footer id="footer">
    <div class="container">
        <div class="row">

            <div class="col-12 footer-info text-center">
                <p>
                    Developed by <strong>Diya Bhimani</strong><br>

                    © <span id="displayYear"></span> BOOKSAW |
                    <a href="https://www.booksaw.com"
                       target="_blank"
                       rel="noopener noreferrer">
                        www.booksaw.com
                    </a>
                </p>
            </div>

        </div>
    </div>
</footer>

<!-- JAVASCRIPT -->
<script src="js/jquery-1.11.0.min.js"></script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js">
</script>

<script src="js/plugins.js"></script>
<script src="js/script.js"></script>

<script>
    document.getElementById("displayYear").textContent =
        new Date().getFullYear();
</script>

</body>
</html>