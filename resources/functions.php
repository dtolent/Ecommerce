<?php
//******************************************HELPER FUNCTIONS***************************************//
function set_message($msg){
	if(!empty($msg)){
		$_SESSION['message'] = $msg;
	}
	else{
		$msg = "";
	}
}
function display_message(){
	if(isset($_SESSION['message'])){
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
}
function redirect($location){
	header("Location: $location");
}

function query($sql){
	global $conn;//use global to use a variable inside a function

	return mysqli_query($conn, $sql);
}

function confirm($result){
	global $conn;
	if(!$result){
		die("QUERY FAILED" . mysqli_error($conn));
	}
}
//function to remove unnecessary characters when storing something in a databsase
function escape_string($string){
	global $conn;

	return mysqli_real_escape_string($conn, $string);
}

function fetch_array($result){
	return mysqli_fetch_array($result);
}
/****************************************** FRONT END FUNCTIONS ************************************************/
//get products
function get_products(){
	$query = query("SELECT * FROM products");
	confirm($query);

	while($row=fetch_array($query)){

		$product_card = <<<DELIMITER

			<div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
							<a href="item.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt="" style="width:261px; height:125px;"></a>
							<div class="container-fluid">
								<div class="caption">
									<h4 class="pull-right">{$row['product_price']}</h4>
									<h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
									</h4>
									<p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
								</div>
								<div class="ratings">
									<p class="pull-right">15 reviews</p>
									<p>
										<span class="glyphicon glyphicon-star"></span>
										<span class="glyphicon glyphicon-star"></span>
										<span class="glyphicon glyphicon-star"></span>
										<span class="glyphicon glyphicon-star"></span>
										<span class="glyphicon glyphicon-star"></span>
									</p>
								</div>
								<div class="buy-btn pull-right">
								  <a class="btn btn-primary" target="_blank" href="cart.php?add={$row['product_id']}">Add to Cart</a>
								</div>
							</div>
                        </div>
                    </div>

DELIMITER;

		echo $product_card;
	}
}
function show_product_in_category(){
	$query = query("SELECT * FROM products WHERE product_categery_id = ".escape_string($_GET['id'])." ");
	confirm($query);
	while($row=fetch_array($query)){

		$category_product= <<<DELIMITER

		<div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
					<a href="item.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt="" style="width:261px; height:125px;"></a>
					<div class="container-fluid">
						<div class="caption">
							<h4 class="pull-right">{$row['product_price']}</h4>
							<h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
							</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
						</div>
						 <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
					</div>
                </div>
            </div>

DELIMITER;

	echo $category_product;

	}

}
function show_product_in_shop(){
	$query = query("SELECT * FROM products");
	confirm($query);
	while($row=fetch_array($query)){

		$category_product= <<<DELIMITER

		<div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
					<a href="item.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt="" style="width:261px; height:125px;"></a>
					<div class="container-fluid">
						<div class="caption">
							<h4 class="pull-right">{$row['product_price']}</h4>
							<h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
							</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
						</div>
						 <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
					</div>
                </div>
            </div>

DELIMITER;

	echo $category_product;

	}

}
function login_user(){
	if(isset($_POST['submit'])){
		$username=$_POST['username'];
		$password=$_POST['password'];

		$query=query("SELECT * FROM users WHERE username='{$username}' AND password='{$password}'");
		confirm($query);
		//if username and password is not found in the database then redirect to the login page
		if(mysqli_num_rows($query)== 0){
			set_message("Invalid password or username");
			redirect("login.php");
		}
		else{//if username and password is found in the database then redirect to the admin page
			//set_message("Welcome to Admin {username}"			);
			redirect("admin");
		}

	}
}
/*
function send_message(){
	if(isset($_POST['submit'])){
		$to = "donnamarie.tolentino@yahoo.com";
		$from_name = $_POST['name'];
		$email = $_POST['email'];
		$subject = $_POST['subject'];
		$message = $_POST['message'];

		$headers = "From: {$from_name} {$email}";

		ini_set("SMTP","ssl://smtp.gmail.com");
    ini_set("smtp_port","587");
		$result = mail($to, $subject, $message, $headers);


		if(!$result){
			set_message("Sorry we could not send your message");
		}
		else{
			set_message("Your message was successfully sent.");
		}
	}


}*/
function get_categories(){
	$query=query("SELECT * FROM categories");
	confirm($query);

	while($row=fetch_array($query)){

		$category_links = <<<DELIMITER

		<a href="category.php?id={$row['cat_id']}	" class="list-group-item">{$row['cat_title']}</a>

DELIMITER;
	echo $category_links;
	}
}

/****************************************** BACK END FUNCTIONS ************************************************/


?>
