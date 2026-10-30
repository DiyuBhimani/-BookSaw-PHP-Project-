
<?php
session_start();

$conn = new mysqli("localhost", "root", "", "book");

if ($conn->connect_error) {
    die("Database connection failed.");
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($username) || empty($newPassword) || empty($confirmPassword)) {
        $message = "Please fill in all fields.";
        $messageType = "error";

    } elseif (strlen($newPassword) < 6) {
        $message = "Password must contain at least 6 characters.";
        $messageType = "error";

    } elseif ($newPassword !== $confirmPassword) {
        $message = "Passwords do not match.";
        $messageType = "error";

    } else {

        // Check whether the username exists
        $stmt = $conn->prepare(
            "SELECT id FROM user WHERE username = ?"
        );
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            // Hash the new password
            $hashedPassword = password_hash(
                $newPassword,
                PASSWORD_DEFAULT
            );

            // Update the password in the database
            $update = $conn->prepare(
                "UPDATE user SET password = ? WHERE username = ?"
            );

            $update->bind_param(
                "ss",
                $hashedPassword,
                $username
            );

            if ($update->execute()) {
                $message = "Password updated successfully! You can now log in.";
                $messageType = "success";
            } else {
                $message = "Unable to update password. Please try again.";
                $messageType = "error";
            }

            $update->close();

        } else {
            $message = "Username not found.";
            $messageType = "error";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Forgot Password | BookStore</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;

    background:
        linear-gradient(
            rgba(255,248,235,.75),
            rgba(245,230,205,.85)
        ),
        url("images/b2.jpeg");

    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.form-container {
    width: 420px;
    max-width: 100%;
    padding: 40px;

    border-radius: 22px;
    background: rgba(255,250,240,.78);
    border: 1px solid rgba(180,140,90,.35);
    backdrop-filter: blur(20px);

    box-shadow: 0 15px 40px rgba(120,80,40,.25);
    color: #5D4037;
}

h2 {
    text-align: center;
    font-size: 29px;
    margin-bottom: 12px;
    color: #6D4C41;
}

.description {
    text-align: center;
    font-size: 13px;
    color: #8D6E63;
    margin-bottom: 28px;
}

.input-box {
    margin-bottom: 22px;
}

.input-box label {
    display: block;
    font-size: 13px;
    margin-bottom: 8px;
}

.input-box input {
    width: 100%;
    padding: 12px;
    border: 1px solid #BCA58A;
    border-radius: 8px;
    outline: none;
    background: rgba(255,255,255,.55);
    color: #5D4037;
    font-size: 14px;
}

.input-box input:focus {
    border-color: #B7793E;
    box-shadow: 0 0 5px rgba(183,121,62,.25);
}

button {
    width: 100%;
    padding: 13px;
    border: none;
    border-radius: 50px;
    background: linear-gradient(90deg, #D4A574, #B7793E);
    color: white;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 1px;
    cursor: pointer;
    transition: .3s;
}

button:hover {
    background: linear-gradient(90deg, #B7793E, #8D5A2B);
    transform: translateY(-2px);
}

.message {
    margin-top: 18px;
    padding: 12px;
    border-radius: 8px;
    text-align: center;
    font-size: 13px;
    overflow-wrap: anywhere;
}

.error {
    background: #FCE8E6;
    border: 1px solid #E6B8AF;
    color: #A94442;
}

.success {
    background: #E6F4EA;
    border: 1px solid #A8D5B5;
    color: #276738;
}

.links {
    text-align: center;
    margin-top: 22px;
    font-size: 13px;
}

.links a {
    color: #B7793E;
    font-weight: 600;
    text-decoration: none;
}

.links a:hover {
    text-decoration: underline;
}

@media (max-width: 450px) {
    .form-container {
        padding: 28px 22px;
    }
}
</style>
</head>

<body>

<div class="form-container">

    <h2>Forgot Password?</h2>

    <p class="description">
        Enter your username and choose a new password.
    </p>

    <form method="POST" action="">

        <div class="input-box">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                placeholder="Enter your username"
                required
                autocomplete="username">
        </div>

        <div class="input-box">
            <label for="new_password">New Password</label>
            <input
                type="password"
                id="new_password"
                name="new_password"
                placeholder="Enter new password"
                minlength="6"
                required
                autocomplete="new-password">
        </div>

        <div class="input-box">
            <label for="confirm_password">Confirm Password</label>
            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                placeholder="Confirm new password"
                minlength="6"
                required
                autocomplete="new-password">
        </div>

        <button type="submit">RESET PASSWORD</button>

    </form>

    <?php if (!empty($message)) { ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>

            <?php if ($messageType === "success") { ?>
                <br><br>
                <a href="login.php">Go to Login</a>
            <?php } ?>
        </div>
    <?php } ?>

    <div class="links">
        Remember your password?
        <a href="login.php">Login Here</a>
    </div>

</div>

</body>
</html>