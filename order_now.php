
<?php
session_start();

$conn = new mysqli("localhost", "root", "", "book");

if ($conn->connect_error) {
    die("Database connection failed.");
}

$conn->set_charset("utf8mb4");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];

$items = [];
$grand_total = 0;
$error_message = "";

$is_cart_checkout = isset($_GET['cart']);

// --------------------------------------------------
// DIRECT PURCHASE
// --------------------------------------------------
if (!$is_cart_checkout && isset($_GET['b_id'])) {

    $b_id = (int) $_GET['b_id'];

    $stmt = $conn->prepare(
        "SELECT b_id, book_name, price, image
         FROM book
         WHERE b_id = ?"
    );

    $stmt->bind_param("i", $b_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($book = $result->fetch_assoc()) {
        $items[] = [
            'b_id'       => (int) $book['b_id'],
            'book_name'  => $book['book_name'],
            'book_price' => (float) $book['price'],
            'book_image' => $book['image'],
            'quantity'   => 1
        ];
    }

    $stmt->close();

// --------------------------------------------------
// CART CHECKOUT
// --------------------------------------------------
} elseif ($is_cart_checkout) {

    $stmt = $conn->prepare(
        "SELECT b_id, book_name, book_price, book_image, quality
         FROM cart
         WHERE user_id = ?"
    );

    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $items[] = [
            'b_id'       => (int) $row['b_id'],
            'book_name'  => $row['book_name'],
            'book_price' => (float) $row['book_price'],
            'book_image' => $row['book_image'],
            'quantity'   => max(1, (int) $row['quality'])
        ];
    }

    $stmt->close();
}

// --------------------------------------------------
// CALCULATE TOTAL
// --------------------------------------------------
foreach ($items as $item) {
    $grand_total += $item['book_price'] * $item['quantity'];
}

// --------------------------------------------------
// BOOK IMAGE PATH
// --------------------------------------------------
function getBookImagePath($image)
{
    $image = trim((string) $image);

    if ($image === '') {
        return '';
    }

    if (preg_match('/^https?:\/\//i', $image)) {
        return $image;
    }

    $image = str_replace('\\', '/', $image);
    $image = ltrim($image, '/');

    if (strpos($image, '/') === false) {
        $image = 'images/' . $image;
    }

    $segments = explode('/', $image);
    $segments = array_map('rawurlencode', $segments);

    return implode('/', $segments);
}

// --------------------------------------------------
// HTML ESCAPING
// --------------------------------------------------
function e($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}

// --------------------------------------------------
// PLACE ORDER
// --------------------------------------------------
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['place_order'])
) {
    $customer_name = trim($_POST['name'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $address       = trim($_POST['address'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $payment       = trim($_POST['payment_method'] ?? '');

    if (empty($items)) {
        $error_message =
            "Your order is empty. Please select books first.";

    } elseif (
        $customer_name === ''
        || !filter_var($email, FILTER_VALIDATE_EMAIL)
        || $address === ''
        || !preg_match('/^[0-9]{10}$/', $phone)
    ) {
        $error_message =
            "Please enter valid customer and delivery details.";

    } elseif ($payment !== 'Cash on Delivery') {
        $error_message = "Please select a valid payment method.";

    } else {
        try {
            $conn->begin_transaction();

            $order_stmt = $conn->prepare(
                "INSERT INTO orders
                (
                    user_id,
                    b_id,
                    quantity,
                    book_price,
                    payment_method,
                    book_name,
                    book_image,
                    order_date
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
            );

            $shipping_stmt = $conn->prepare(
                "INSERT INTO shipping
                (user_id, order_id, name, email, address, phone)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            foreach ($items as $item) {

                $b_id       = (int) $item['b_id'];
                $quantity   = (int) $item['quantity'];
                $book_price = (float) $item['book_price'];
                $book_name  = $item['book_name'];
                $book_image = $item['book_image'];

                $order_stmt->bind_param(
                    "iiidsss",
                    $user_id,
                    $b_id,
                    $quantity,
                    $book_price,
                    $payment,
                    $book_name,
                    $book_image
                );

                $order_stmt->execute();

                $order_id = $conn->insert_id;

                $shipping_stmt->bind_param(
                    "iissss",
                    $user_id,
                    $order_id,
                    $customer_name,
                    $email,
                    $address,
                    $phone
                );

                $shipping_stmt->execute();
            }

            $order_stmt->close();
            $shipping_stmt->close();

            // Clear cart after successful checkout
            if ($is_cart_checkout) {
                $delete_stmt = $conn->prepare(
                    "DELETE FROM cart WHERE user_id = ?"
                );

                $delete_stmt->bind_param("i", $user_id);
                $delete_stmt->execute();
                $delete_stmt->close();
            }

            $conn->commit();

            header("Location: thankyou.php");
            exit();

        } catch (Throwable $ex) {
            $conn->rollback();

            error_log("Order error: " . $ex->getMessage());

            $error_message =
                "Unable to place your order. Please check your database structure and try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Place Order - BookSaw</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Original BookSaw CSS -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="icomoon/icomoon.css">
    <link rel="stylesheet" href="css/vendor.css">
    <link rel="stylesheet" href="style.css">

    <style>
        /* ==========================================
           PAGE DESIGN
        ========================================== */

        body {
            background: #f4f2ed;
        }

        .checkout-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 15px 50px;
            min-height: 65vh;
        }

        .checkout-title {
            color: #493b32;
            font-family: Georgia, serif;
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .checkout-subtitle {
            color: #777;
            margin-bottom: 30px;
        }

        /* ==========================================
           ORIGINAL ORANGE NAVIGATION
        ========================================== */

        #header #navbar .menu-list .menu-item > a {
            color: #F28C38 !important;
            transition: color 0.3s ease;
        }

        #header #navbar .menu-list .menu-item > a:hover {
            color: #D97827 !important;
        }

        #header #navbar .menu-list .menu-item.active > a {
            color: #F28C38 !important;
        }

        #header .hamburger .bar {
            background-color: #F28C38;
        }

        /* Keep original header background */
        #header {
            background-color: #f4f2ed;
        }

        /* ==========================================
           CHECKOUT CARDS
        ========================================== */

        .checkout-card {
            background: #fff;
            border: 1px solid #e3dfdb;
            border-radius: 6px;
            margin-bottom: 24px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04);
        }

        .checkout-card-header {
            background: #493b32;
            color: #fff;
            padding: 15px 20px;
            font-size: 18px;
            font-family: Georgia, serif;
            font-weight: 600;
        }

        .checkout-card-body {
            padding: 24px 20px;
        }

        /* ==========================================
           ORDER SUMMARY
        ========================================== */

        .order-table {
            width: 100%;
            margin-bottom: 0;
        }

        .order-table th {
            background: #f8f6f3;
            color: #493b32;
            font-weight: 600;
            padding: 14px 12px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .order-table td {
            padding: 15px 12px;
            vertical-align: middle;
        }

        .order-table th:first-child,
        .order-table td:first-child {
            padding-left: 22px;
        }

        .book-name {
            min-width: 180px;
            color: #302b28;
            font-weight: 600;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .book-cover {
            width: 55px;
            height: 72px;
            object-fit: contain;
            padding: 3px;
            border: 1px solid #e2ded9;
            border-radius: 4px;
            background: #fff;
        }

        .image-unavailable {
            display: none;
            color: #888;
            font-size: 12px;
        }

        .grand-total {
            color: #b0784d;
            font-weight: 700;
            white-space: nowrap;
        }

        .grand-total-row td {
            padding-top: 18px;
            padding-bottom: 18px;
        }

        /* ==========================================
           CUSTOMER FORM
        ========================================== */

        .checkout-form-label {
            display: block;
            color: #493b32;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .checkout-form-control {
            display: block;
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d8d2cc;
            border-radius: 5px;
            background: #fff;
            color: #302b28;
            font-size: 14px;
        }

        .checkout-form-control:focus {
            border-color: #b88b68;
            outline: none;
            box-shadow: 0 0 0 3px rgba(184, 139, 104, 0.15);
        }

        textarea.checkout-form-control {
            resize: vertical;
            min-height: 80px;
        }

        /* ==========================================
           SEPARATE PAYMENT METHOD CONTAINER
        ========================================== */

        .payment-box {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            background: #faf8f5;
            border: 1px solid #e5ded6;
            border-radius: 6px;
            padding: 20px;
            transition: 0.2s ease;
        }

        .payment-box:hover {
            border-color: #b88b68;
            background: #f8f5f1;
        }

        .payment-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eee4da;
            color: #493b32;
            border-radius: 8px;
            font-size: 23px;
        }

        .payment-box .form-check {
            margin: 0;
            padding-left: 1.7em;
        }

        .payment-box .form-check-input {
            cursor: pointer;
        }

        .payment-box .form-check-input:checked {
            background-color: #b88b68;
            border-color: #b88b68;
        }

        .payment-box .form-check-label {
            color: #493b32;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .payment-description {
            color: #777;
            font-size: 14px;
            margin: 8px 0 0;
        }

        /* ==========================================
           AMOUNT AND PLACE ORDER
        ========================================== */

        .amount-label {
            display: block;
            color: #777;
            font-size: 15px;
            margin-bottom: 5px;
        }

        .amount-value {
            color: #b0784d;
            font-size: 25px;
            font-weight: 700;
            margin: 0 0 5px;
        }

        .btn-place-order {
            display: inline-block;
            padding: 14px 30px;
            border: 1px solid #b88b68;
            border-radius: 4px;
            background: #b88b68;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn-place-order:hover {
            background: #493b32;
            border-color: #493b32;
            color: #fff;
        }

        .continue-shopping {
            color: #493b32;
            text-decoration: none;
            font-size: 14px;
        }

        .continue-shopping:hover {
            color: #b88b68;
            text-decoration: underline;
        }

        /* ==========================================
           FOOTER
        ========================================== */

        .footer-logo {
            max-width: 180px;
            height: auto;
            margin-bottom: 15px;
        }

        /* ==========================================
           RESPONSIVE DESIGN
        ========================================== */

        @media (max-width: 768px) {
            .checkout-container {
                padding: 30px 12px 40px;
            }

            .checkout-title {
                font-size: 27px;
            }

            .checkout-card-body {
                padding: 18px 15px;
            }

            .checkout-card-header {
                font-size: 16px;
                padding: 13px 15px;
            }

            .btn-place-order {
                padding: 12px 20px;
            }
        }

        @media (max-width: 576px) {
            .checkout-title {
                font-size: 24px;
            }

            .order-table {
                font-size: 13px;
            }

            .order-table th,
            .order-table td {
                padding: 10px 8px;
            }

            .order-table th:first-child,
            .order-table td:first-child {
                padding-left: 12px;
            }

            .book-cover {
                width: 43px;
                height: 58px;
            }

            .payment-icon {
                width: 40px;
                height: 40px;
                font-size: 19px;
            }
        }
    </style>
</head>

<body>

<!-- ================================================
     HEADER
================================================ -->

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

                            <li class="menu-item">
                                <a href="index.php">Home</a>
                            </li>

                            <li class="menu-item">
                                <a href="about.php">ABOUT US</a>
                            </li>

                            <li class="menu-item">
                                <a href="books.php">BOOKS</a>
                            </li>

                            <li class="menu-item">
                                <a href="contactus.php">CONTACT US</a>
                            </li>

                            <li class="menu-item">
                                <a href="login.php">LOGOUT</a>
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

<!-- ================================================
     CHECKOUT CONTENT
================================================ -->

<main class="checkout-container">

    <div class="text-center">

        <h1 class="checkout-title">
            Your Book Orders
        </h1>

        <p class="checkout-subtitle">
            Review your books and enter your delivery details.
        </p>

    </div>

    <?php if ($error_message !== ''): ?>

        <div class="alert alert-danger" role="alert">
            <?php echo e($error_message); ?>
        </div>

    <?php endif; ?>

    <?php if (empty($items)): ?>

        <section class="checkout-card">

            <div class="checkout-card-body text-center py-5">

                <h4>No books found</h4>

                <p class="text-muted">
                    Your order is empty. Please select a book before checkout.
                </p>

                <a href="books.php" class="btn-place-order">
                    Browse Books
                </a>

            </div>

        </section>

    <?php else: ?>

        <!-- ORDER SUMMARY -->

        <section class="checkout-card">

            <div class="checkout-card-header">
                Order Summary
            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-striped align-middle order-table">

                    <thead>
                        <tr>
                            <th>Book</th>
                            <th class="text-center">Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($items as $item): ?>

                            <?php
                            $line_total =
                                $item['book_price'] * $item['quantity'];

                            $imagePath = getBookImagePath(
                                $item['book_image']
                            );
                            ?>

                            <tr>

                                <td class="book-name">
                                    <?php echo e($item['book_name']); ?>
                                </td>

                                <td class="text-center">

                                    <?php if ($imagePath !== ''): ?>

                                        <img
                                            src="<?php echo e($imagePath); ?>"
                                            alt="<?php echo e($item['book_name']); ?>"
                                            class="book-cover"
                                            loading="lazy"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';"
                                        >

                                        <span class="image-unavailable">
                                            Image unavailable
                                        </span>

                                    <?php else: ?>

                                        <span class="text-muted">
                                            No image
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>
                                    ₹<?php echo number_format(
                                        $item['book_price'], 2
                                    ); ?>
                                </td>

                                <td>
                                    <?php echo (int) $item['quantity']; ?>
                                </td>

                                <td class="fw-bold">
                                    ₹<?php echo number_format(
                                        $line_total, 2
                                    ); ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                    <tfoot>

                        <tr class="grand-total-row">

                            <td colspan="4" class="text-end fw-bold">
                                Grand Total
                            </td>

                            <td class="grand-total">
                                ₹<?php echo number_format(
                                    $grand_total, 2
                                ); ?>
                            </td>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </section>

        <!-- CHECKOUT FORM -->

        <form method="POST" action="">

            <!-- CUSTOMER AND DELIVERY DETAILS -->

            <section class="checkout-card">

                <div class="checkout-card-header">
                    Customer &amp; Delivery Details
                </div>

                <div class="checkout-card-body">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <label for="name" class="checkout-form-label">
                                Full Name
                            </label>

                            <input
                                type="text"
                                class="checkout-form-control"
                                id="name"
                                name="name"
                                placeholder="Enter your full name"
                                maxlength="100"
                                required
                            >

                        </div>

                        <div class="col-md-6">

                            <label for="email" class="checkout-form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                class="checkout-form-control"
                                id="email"
                                name="email"
                                placeholder="Enter your email"
                                maxlength="150"
                                required
                            >

                        </div>

                        <div class="col-md-6">

                            <label for="phone" class="checkout-form-label">
                                Mobile Number
                            </label>

                            <input
                                type="tel"
                                class="checkout-form-control"
                                id="phone"
                                name="phone"
                                placeholder="10-digit mobile number"
                                pattern="[0-9]{10}"
                                maxlength="10"
                                inputmode="numeric"
                                required
                            >

                        </div>

                        <div class="col-md-6">

                            <label for="address" class="checkout-form-label">
                                Delivery Address
                            </label>

                            <textarea
                                class="checkout-form-control"
                                id="address"
                                name="address"
                                rows="3"
                                placeholder="Enter your complete delivery address"
                                maxlength="1000"
                                required
                            ></textarea>

                        </div>

                    </div>

                </div>

            </section>

            <!-- SEPARATE PAYMENT METHOD -->

            <section class="checkout-card">

                <div class="checkout-card-header">
                    Payment Method
                </div>

                <div class="checkout-card-body">

                    <div class="payment-box">

                        <div class="payment-icon">
                            &#8377;
                        </div>

                        <div class="flex-grow-1">

                            <div class="form-check">

                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="payment_method"
                                    id="cod"
                                    value="Cash on Delivery"
                                    checked
                                    required
                                >

                                <label
                                    class="form-check-label"
                                    for="cod"
                                >
                                    Cash on Delivery
                                </label>

                            </div>

                            <p class="payment-description">
                                Pay when your books are delivered to your address.
                            </p>

                        </div>

                    </div>

                </div>

            </section>

            <!-- AMOUNT AND PLACE ORDER -->

            <section class="checkout-card">

                <div class="checkout-card-body">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div>

                            <span class="amount-label">
                                Amount to Pay
                            </span>

                            <h4 class="amount-value">
                                ₹<?php echo number_format(
                                    $grand_total, 2
                                ); ?>
                            </h4>

                            <small class="text-muted">
                                Payment method: Cash on Delivery
                            </small>

                        </div>

                        <button
                            type="submit"
                            name="place_order"
                            value="1"
                            class="btn-place-order"
                            onclick="return confirm('Are you sure you want to place this order?');"
                        >
                            PLACE ORDER
                        </button>

                    </div>

                    <div class="mt-4">

                        <a href="books.php" class="continue-shopping">
                            &larr; Continue Shopping
                        </a>

                    </div>

                </div>

            </section>

        </form>

    <?php endif; ?>

</main>

<!-- ================================================
     FOOTER
================================================ -->

<footer id="footer">

    <div class="container">

        <div class="row">

            <div class="col-md-4">

                <div class="company-brand">

                    <img
                        src="images/main-logo.png"
                        alt="BookSaw logo"
                        class="footer-logo"
                    >

                    <p>
                        Discover your next favorite book at
                        <strong>BOOKSAW</strong>.
                        From timeless classics to the latest bestsellers,
                        we offer books for every reader. Read, learn, and
                        grow with us.
                    </p>

                </div>

            </div>

            <div class="col-md-2">

                <div class="footer-menu">

                    <h5>About Us</h5>

                    <ul class="menu-list">
                        <li><a href="about.php">Vision</a></li>
                        <li><a href="about.php">Articles</a></li>
                        <li><a href="contactus.php">Careers</a></li>
                    </ul>

                </div>

            </div>

            <div class="col-md-2">

                <div class="footer-menu">

                    <h5>Discover</h5>

                    <ul class="menu-list">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="books.php">Books</a></li>
                        <li><a href="books.php">Authors</a></li>
                    </ul>

                </div>

            </div>

            <div class="col-md-2">

                <div class="footer-menu">

                    <h5>My Account</h5>

                    <ul class="menu-list">
                        <li><a href="login.php">Sign In</a></li>
                        <li><a href="addtocart.php">View Cart</a></li>
                    </ul>

                </div>

            </div>

            <div class="col-md-2">

                <div class="footer-menu">

                    <h5>Help</h5>

                    <ul class="menu-list">
                        <li><a href="contactus.php">Help Center</a></li>
                        <li><a href="contactus.php">Report a Problem</a></li>
                        <li><a href="contactus.php">Contact Us</a></li>
                    </ul>

                </div>

            </div>

        </div>

    </div>

</footer>

<!-- JAVASCRIPT -->

<script src="js/jquery-1.11.0.min.js"></script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
></script>

<script src="js/plugins.js"></script>
<script src="js/script.js"></script>

</body>
</html>
