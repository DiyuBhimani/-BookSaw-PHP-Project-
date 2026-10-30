<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Order Success - BookSaw</title>

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

}



/* Success Card */

.box{

    width:430px;

    padding:45px 35px;

    text-align:center;


    border-radius:25px;


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



/* Icon */

.box h1{


    font-size:42px;


    margin-bottom:20px;


    font-weight:600;


    color:#6D4C41;


}



/* Message */


.box p{


    font-size:17px;


    line-height:1.8;


    margin-bottom:30px;


    color:#795548;


}



/* Button */


.box a{


    display:inline-block;


    padding:14px 38px;


    border-radius:50px;


    background:


    linear-gradient(

        90deg,

        #D4A574,

        #B7793E

    );



    color:white;


    text-decoration:none;


    font-size:16px;


    font-weight:600;


    transition:.3s;


}



.box a:hover{


    background:


    linear-gradient(

        90deg,

        #B7793E,

        #8D5A2B

    );



    transform:translateY(-3px);


    box-shadow:

    0 8px 20px rgba(183,121,62,.45);


}




/* Book Icon Circle */

.icon{


    width:90px;

    height:90px;

    margin:0 auto 20px;


    display:flex;

    align-items:center;

    justify-content:center;


    border-radius:50%;


    background:#F3E5D0;


    font-size:45px;


    box-shadow:

    0 8px 20px rgba(120,80,40,.2);


}




/* Mobile */

@media(max-width:450px){


    .box{

        width:90%;

        padding:35px 25px;

    }



    .box h1{

        font-size:34px;

    }


}



</style>


</head>


<body>



<div class="box">


    <div class="icon">
        📚
    </div>


    <h1>
        Thank You!
    </h1>



    <p>

        Your book order has been placed successfully.

        <br><br>

        We will pack your books carefully and deliver them soon.

    </p>



    <a href="index.php">

        Continue Reading

    </a>



</div>



</body>
</html>

