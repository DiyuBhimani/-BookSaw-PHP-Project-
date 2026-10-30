
<?php
include("connected.php");
$result = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>BookSaw - Category List</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Existing CSS files -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="icomoon/icomoon.css">
    <link rel="stylesheet" href="css/vendor.css">
    <link rel="stylesheet" href="style.css">

    <style>
        /* Equal size for Edit and Delete buttons */
        .action-btn {
            width: 110px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Action column alignment */
        .action-buttons {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        /* Category heading */
        .category-title {
            text-align: center;
            margin-bottom: 30px;
        }

        /* Add category link */
        .add-btn {
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header id="header">
        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-md-2">
                    <div class="main-logo">
                        <a href="index.php">
                            <img src="images/main-logo.png" alt="BookSaw Logo">
                        </a>
                    </div>
                </div>

                <div class="col-md-10">
                    <nav id="navbar">
                        <div class="main-menu stellarnav">
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <a href="index.php">Home</a>
                                </li>
                                <li class="menu-item">
                                    <a href="user.php">USER</a>
                                </li>
                                <li class="menu-item active">
                                    <a href="category.php">CATEGORY</a>
                                </li>
                                <li class="menu-item">
                                    <a href="book.php">BOOKS</a>
                                </li>
                                <li class="menu-item">
                                    <a href="shipping.php">ORDERS</a>
                                </li>
                                <li class="menu-item">
                                    <a href="feedback.php">FEEDBACK</a>
                                </li>
                                <li class="menu-item">
                                    <a href="logout.php">LOGOUT</a>
                                </li>
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

    <!-- Category List -->
    <div class="container mt-5" style="min-height: 70vh;">

        <h2 class="category-title">Category List</h2>

        <!-- Add New Category -->
        <div class="d-flex justify-content-center mb-4">
            <a href="add_category.php" class="add-btn">
                Add New Category
            </a>
        </div>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">

                <thead class="table-dark">
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Category Name</th>
                        <th style="width: 180px;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>

                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <?= (int) $row['c_id']; ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>
                                </td>

                                <!-- Action Buttons -->
                                <td>
                                    <div class="action-buttons">

                                        <a
                                            href="edit_category.php?c_id=<?= (int) $row['c_id']; ?>"
                                            class="btn btn-warning btn-sm action-btn">
                                            Edit
                                        </a>

                                        <a
                                            href="delete_category.php?c_id=<?= (int) $row['c_id']; ?>"
                                            class="btn btn-danger btn-sm action-btn"
                                            onclick="return confirm('Delete this category?');">
                                            Delete
                                        </a>

                                    </div>
                                </td>
                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                No categories found.
                            </td>
                        </tr>

                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>

    <!-- Footer -->
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="footer-info text-center">
                    <p>
                        Developed by <strong>Diya Bhimani</strong><br>
                        &copy; <span id="displayYear"></span> BOOKSAW |
                        <a href="https://www.booksaw.com" target="_blank"
                           rel="noopener noreferrer">
                            www.booksaw.com
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="js/jquery-1.11.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>

    <script>
        document.getElementById("displayYear").textContent =
            new Date().getFullYear();
    </script>

</body>
</html>
