<?php
session_start();

$conn = new mysqli("localhost", "root", "", "book");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Admin Login
    if ($username === "admin" && $password === "admin") {

        $_SESSION['admin'] = true;
        $_SESSION['username'] = "admin";
        $_SESSION['role'] = "admin";

        header("Location: admin/index.php");
        exit();
    }

    // User Login
    $username = $conn->real_escape_string($username);

    $result = $conn->query("SELECT * FROM user WHERE username='$username'");

    if ($result && $result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password']) || $password === $row['password']) {

            // Store user session
            $_SESSION['user_id'] = $row['id'];      // Correct column name
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = "user";

            header("Location: index.php");
            exit();

        } else {
            $message = "❌ Incorrect password!";
        }

    } else {
        $message = "❌ Username not found!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>BookStore Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}


body{

    height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;


    background:

    linear-gradient(
        rgba(255,248,235,.75),
        rgba(245,230,205,.85)
    ),

    url("images/b2.jpeg");


    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;


    overflow:hidden;

}



/* Cream Glass Card */

.form-container{


    width:390px;


    padding:40px;


    border-radius:22px;


    background:

    rgba(255,250,240,.65);



    border:

    1px solid rgba(180,140,90,.35);



    backdrop-filter:blur(20px);

    -webkit-backdrop-filter:blur(20px);



    box-shadow:


    0 15px 40px rgba(120,80,40,.25),

    inset 0 0 25px rgba(255,255,255,.5);



    color:#5D4037;


}



/* Heading */


h2{


    text-align:center;


    font-size:32px;


    margin-bottom:35px;


    font-weight:600;


    color:#6D4C41;


}



/* Inputs */


.input-box{


    margin-bottom:22px;


}



.input-box input{


    width:100%;


    padding:12px 0;



    background:transparent;



    border:none;


    border-bottom:


    1px solid #BCA58A;



    outline:none;



    color:#5D4037;



    font-size:15px;


}



.input-box input::placeholder{


    color:#8D6E63;


}



.input-box input:focus{


    border-bottom:


    2px solid #B7793E;


}



/* Remember Options */


.options{


    display:flex;


    justify-content:space-between;


    align-items:center;



    margin:25px 0;



    font-size:13px;


    color:#6D4C41;


}



.options label{


    display:flex;


    align-items:center;


    gap:6px;


}



.options input{


    accent-color:#B7793E;


}



.options a{


    color:#8D5A2B;


    text-decoration:none;


}



.options a:hover{


    text-decoration:underline;


}



/* Cream Gold Button */


button{


    width:100%;



    padding:14px;



    border:none;



    border-radius:50px;



    background:


    linear-gradient(

        90deg,

        #D4A574,

        #B7793E

    );



    color:white;



    font-size:15px;



    letter-spacing:4px;



    font-weight:600;



    cursor:pointer;



    transition:.3s;



}



button:hover{


    background:


    linear-gradient(

        90deg,

        #B7793E,

        #8D5A2B

    );



    transform:translateY(-2px);



    box-shadow:


    0 8px 25px rgba(183,121,62,.45);



}



/* Register */


.register{


    margin-top:22px;


    text-align:center;


    color:#6D4C41;


    font-size:14px;


}



.register a{


    color:#B7793E;


    text-decoration:none;


    font-weight:600;


}



.register a:hover{


    text-decoration:underline;


}



/* Error Message */


.message{


    margin-top:20px;


    padding:12px;


    border-radius:10px;


    background:#FCE8E6;


    border:1px solid #E6B8AF;


    color:#A94442;


    text-align:center;


}



/* Responsive */


@media(max-width:450px){


.form-container{


    width:90%;


    padding:30px;


}


}


</style>

</head>

<body>

<div class="form-container">


<h2>Bookstore Login</h2>

<form method="POST">

<div class="input-box">
<input
type="text"
name="username"
placeholder="Enter Username"
required
autocomplete="off">
</div>

<div class="input-box">
<input
type="password"
name="password"
placeholder="Enter Password"
required
autocomplete="off">
</div>

<div class="options">

<label>
<input type="checkbox">
Remember Me
</label>

<a href="forgetpassword.php">Forgot Password?</a>

</div>

<button type="submit">
SUBMIT
</button>

</form>

<div class="register">
Don't have an account?
<a href="register.php">Register</a>
</div>

<?php if(!empty($message)){ ?>
<div class="message">
<?php echo htmlspecialchars($message); ?>
</div>
<?php } ?>

</div>

</body>
</html>