<!DOCTYPE html>

<?php 

$con =mysqli_connect("localhost","root","","webster") or die ("could not connet to mysqli");

session_start();

if(isset($_GET['pro_id']))
{
  echo $_SESSION['pro_id']=$_GET['pro_id'];
}
cart();
wish(); 

function get_user_id()
{
    global $con;
    $user=$_SESSION['username'];
    $select_user="select * from user where username='$user'";
    $run_user=mysqli_query($con,$select_user);
    if($rr=mysqli_fetch_array($run_user))
    {
        $user_id=$rr['user_id'];
        return $user_id;
    }
    
}

// adding product  to cart
function cart() 
{ 
    global $con;
    if(isset($_GET['add_cart'])){
    
        if(isset($_SESSION['username']))
        {
        $user=$_SESSION['username'];
        $user_id=get_user_id();
       $pro_id=$_GET['add_cart'];
        $check_pro="select * from cart where username='$user' AND pro_id='$pro_id'";
        $run_check=mysqli_query($con,$check_pro);        
        if(mysqli_num_rows($run_check)>0)
        {
            echo"<script>alert(already added!!)</script>";
            echo"<script>window.open('mnnit_Ekart.php','_self')<script>";
        }
        else{
                $insert_pro="insert into cart (user_id,username,pro_id) values ('$user_id','$user','$pro_id')";
                $run_pro=mysqli_query($con,$insert_pro);
                echo"<script>window.open('mnnit_Ekart.php','_self')<script>";
            }
        }
        else
        {
            echo"<script>alert(login first!!)</script>";
            echo"<script>window.open('mnnit_Ekart.php','_self')<script>";
        }
    }
 }

function wish()
{    global $con;
    if(isset($_GET['add_wish'])){
        if(isset($_SESSION['username']))
        {
        $user=$_SESSION['username'];
            $user_id=get_user_id();
           $pro_id=$_GET['add_wish'];
        $check_pro="select * from wishlist where username='$user' AND pro_id='$pro_id'";
        $run_check=mysqli_query($con,$check_pro);
            
        if(mysqli_num_rows($run_check)>0){
            echo"<script>alert(already added)</script>";
            echo"<script>window.open('mnnit_Ekart.php','_self')<script>";
        }
            else{
                $insert_pro="insert into wishlist (user_id,username,pro_id) values ('$user_id','$user','$pro_id')";
                $run_pro=mysqli_query($con,$insert_pro);
                echo"<script>window.open('mnnit_Ekart.php','_self')<script>";
            }
        }
        else
        {
            echo"<script>alert(login first)</script>";
            echo"<script>window.open('mnnit_Ekart.php','_self')<script>";
        }
        
    }
}

// counting numbers of product from cart

function total_items_cart()
{
    global $con;
if(isset($_SESSION['username']))
{
    $user=$_SESSION['username'];
    $count_cart="select * from cart where username='$user'";
    $run_count=mysqli_query($con,$count_cart);
    $count_item=mysqli_num_rows($run_count);
    echo $count_item;
    
}
}

// counting numbers of product from wishlist

function total_items_wishlist()
{
    global $con;
if(isset($_SESSION['username']))
{
    $user=$_SESSION['username'];
    $count_wish="select * from wishlist where username='$user'";
    $run_count=mysqli_query($con,$count_wish);
    $count_item=mysqli_num_rows($run_count);
    echo $count_item;
    
}
}


function get_pro_detail(){
    
    if((isset($_GET['pro_id']))){
 global $con;
        $pro_id=$_GET['pro_id'];
    $get_pro="select * from products where pro_id='$pro_id'";  //order by RAND() LIMIT 0,8;
    $run_pro= mysqli_query($con,$get_pro);
    while($row_pro=mysqli_fetch_array($run_pro))
    {
        $pro_id=$row_pro['pro_id'];
        $pro_cat=$row_pro['pro_cat'];
        $pro_brand=$row_pro['pro_brand'];
        $pro_title=$row_pro['pro_title'];
        $pro_price=$row_pro['pro_price'];
        $pro_image=$row_pro['pro_img'];
        $pro_desc=$row_pro['pro_desc'];
        $pro_likes=$row_pro['pro_likes'];
        $pro_rate=$row_pro['pro_rate'];
        echo"
<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
        <div class='card pick'>
    <a href='detail.php?pro_id=$pro_id' ><img class='card-img-top' src='images/$pro_image' alt='Card image cap'></a>
  <div class='card-body'>
    <h4 class='card-title'>$pro_title</h4>
    <p class='card-text'>$pro_cat</p>
    <p class='card-text'>$pro_brand</p>
    <p class='card-text'>$pro_desc</p>
    <p class='card-text'>Rs.$pro_price</p>
    <p class='card-text'>likes:$pro_likes   rating:$pro_rate</p>
    <a href='mnnit_Ekart.php?add_cart=$pro_id' class='btn btn-default'><i class='fa fa-shopping-cart' aria-hidden='true'></i></a>
    <a href='mnnit_Ekart.php?add_wish=$pro_id' class='btn btn-default'><i class='fa fa-heart' aria-hidden='true'></i></a>
  </div></div>
</div>";
    }
    }
}


if(isset($_POST['submit']))
    {
    if(isset($_SESSION['username']))
    {
       $pro_id=$_SESSION['pro_id'];
       $user_id=get_user_id();
       $username=$_SESSION['username'];
        $comment=$_POST['comment'];
        
        $insert_comment="insert into comments (pro_id,user_id,username,pro_comment) values ('$pro_id','$user_id','$username','$comment')";
        $run_comment=mysqli_query($con,$insert_comment);
        if($run_comment)
        echo "<script>window.open('detail.php?pro_id=$pro_id','_self')</script>";
        
    }
    else
    {
        echo "<script>alert(login first)</script>";
    }
}
function get_comments()
{
    global $con;
    $pro_id=$_SESSION['pro_id'];
    $get_comment="select * from comments where pro_id='$pro_id'";
    $run_comments=mysqli_query($con,$get_comment);
    while($r=mysqli_fetch_array($run_comments))
    {
       $username=$r['username'];
        $comment=$r['pro_comment'];
        echo "<div class='media'>
  <div class='media-left'>
    <img src='images/img_avatar1.png' class='media-object' style='width:60px;margin:10px;'>
  </div>
  <div class='media-body'>
    <h4 class='media-heading'>$username</h4>
    <p>$comment</p>
  </div>
</div>";
    }
}


?>

<html>
<head>
	<title>MNNIT E-CART</title>
	<link rel="stylesheet" type="text/css" href="design.css">
	<!--<link rel="stylesheet" type="text/css" href="bootstrap.css">-->
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


	<script
  src="http://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
	<style type=text/css>
	</style>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
  <a class="navbar-brand" href="#">MNNIT E-CART</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    	<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Products
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
<!--
      <li class="nav-item">
      	<form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search"  name="search" placeholder="Search" aria-label="Search" method="get">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit_search" method="post">Search</button>
    </form>
      </li>
-->
    </ul>
     <ul class="navbar-nav">
     	<li class="nav-item">
        <a class="nav-link active" href="mnnit_Ekart.php">Home <span class="sr-only">(current)</span></a>
      </li>
      
    
       <?php 
          if(isset($_SESSION['username'])!=null)
          {
          ?>
          
          <li class="nav-item inactive">
        <a class="nav-link" href=""><?php echo $_SESSION['username'] ;?></a>
         </li>
         <li class="nav-item inactive">
        <a class="nav-link" href="logout.php">logout</a>
         </li>
          
        <?php }
          
          else
          {
              ?>
              <li class="nav-item inactive">
        <a class="nav-link" href="login.php">Login</a>
      </li>
      <li class="nav-item inactive">
        <a class="nav-link" href="signup.php">Sign Up</a>
         </li>
          
    <?php } ?>
         
      <li class="nav-item inactive">
        <a class="nav-link" href="whislist.php"><i class="fa fa-heart" aria-hidden="true"></i><span class="sr-only">(current)</span><span class="badge badge-pill badge-light"><?php total_items_wishlist();?></span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
      	<li class="nav-item inactive">
        <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="sr-only">(current)</span><span class="badge badge-pill badge-light"><?php total_items_cart();?></span></a>
      </li>
    </ul>
  </div></nav>
  <!--	<nav class="navbar navbar-expand-lg navbar-primary bg-dark position-relative" style="padding-top:5%;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
    	<li class="nav-item active">
        <a class="nav-link" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Whislist<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
  </div>
</nav>-->

	<div style="margin-top:100px;" class="container">
       <div class="row">
   <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
<?php     
    get_pro_detail(); 
    ?>
  
</div>
       <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
       
  <form method="post">
     <div class='form-group'>
       <label for="comment">Comment:</label>
     <textarea class="form-control" rows="5" name="comment"></textarea>
    <button type="submit" name="submit" class="btn btn-success"  >comment</button>
    </div>
    </form> 
    
         
        <?php  get_comments();?>
<!--
          <div class="media">
  <div class="media-left">
    <img src="images/img_avatar1.png" class="media-object" style="width:60px">
  </div>
  <div class="media-body">
    <h4 class="media-heading">John Doe</h4>
    <p>Lorem ipsum...</p>
  </div>
</div>
-->

   
    
           </div>
        </div>
		</div>
	<div style="text-align:center;">
    MNNIT E-CART &copy 2018
</div>
</body>
</html>