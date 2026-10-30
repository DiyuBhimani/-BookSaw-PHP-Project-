
<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "book");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM contact WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: feedback.php");
        exit();
    }

    $stmt->close();
}

// Fetch feedback records
$result = $conn->query("SELECT * FROM contact ORDER BY id DESC");

if (!$result) {
    die("Error fetching feedback: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>BookSaw - User Feedback</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="icomoon/icomoon.css">
    <link rel="stylesheet" href="css/vendor.css">
    <link rel="stylesheet" href="style.css">

    <style>
        .feedback-container {
            min-height: 70vh;
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .feedback-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .feedback-table th,
        .feedback-table td {
            vertical-align: middle;
        }

        .feedback-table td.message-cell {
            min-width: 250px;
            white-space: normal;
            overflow-wrap: anywhere;
        }

        .delete-btn {
            white-space: nowrap;
        }
    </style>
</head>

<body>

<header id="header">
    <div class="container-fluid">
        <div class="row align-items-center">

            <div class="col-md-2">
                <div class="main-logo">
                    <a href="index.php">
                        <img src="images/main-logo.png" alt="BookSaw logo">
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
                            <li class="menu-item active"><a href="feedback.php">FEEDBACK</a></li>
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

<div class="container feedback-container">

    <h2 class="feedback-title">User Feedbacks</h2>

    <?php if ($result->num_rows > 0): ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover feedback-table">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars((string) $row['id']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['name'] ?? ''); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['email'] ?? ''); ?>
                            </td>

                            <td class="message-cell">
                                <?= nl2br(htmlspecialchars($row['message'] ?? '')); ?>
                            </td>

                            <td>
                                <a
                                    href="feedback.php?delete_id=<?= (int) $row['id']; ?>"
                                    class="btn btn-danger btn-sm delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this feedback?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>
        </div>

    <?php else: ?>

        <div class="alert alert-info text-center">
            No feedback found.
        </div>

    <?php endif; ?>

</div>

<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 footer-info text-center">
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

<script>
    document.getElementById("displayYear").textContent =
        new Date().getFullYear();
</script>

<script src="js/jquery-1.11.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/script.js"></script>

</body>
</html>
<?php
$conn->close();
?>
