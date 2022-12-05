<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="mystyle.css">
<meta charset="UTF-8">
<meta name = "viewport" content="width=device-width, initial-scale=1.0">

	<title> Customer Odrer </title>
	<center><h1> Welcome to Lunch-Truck Online </h1><center>
<style>
body {
  padding: 25px;
  background-color: beige;
  color: black;
}

.dark-mode {
  background-color: black;
  color: white;
}
</style>
</head>
<body>

<button onclick="myFunction()">Toggle Light/Dark Mode</button>

<script>
function myFunction() {
   var element = document.body;
   element.classList.toggle("dark-mode");
}
</script>

	<a name="top"></a>
	<a href="#top">Home</a>

	<center><h1> Our Menu </h1>
	
	<table>
  <tr>
    <th><a href="Chicken.html">Chicken</a></th>
    <th><a href="Beef.html">Beef</a></th>
    <th><a href="Turkey.html">Turkey</a></th>
	<th>Quantity</th>
  </tr>
  <tr>
    <td>Chicken Sandwich - $2.99</td>
    <td>Beef Stew - $3.99</td>
    <td>Turkey Salad - $1.99</td>
	<td>100 of each in stock</td>
  </tr>
  <tr>
    <td>Chicken Bone Broth - $1.99</td>
    <td>Beef Marrow - $2.49</td>
    <td>Fried Turkey with Rice - $3.49</td>
	<td>150 of each in stock</td>
  </tr>
  <tr>
  	<td>Chicken Drumstick - $0.99</td>
    <td>Beef Liver - $2.99</td>
    <td>Turkey Combo - $3.49</td>
	<td>150 of each in stock</td>
  </tr>	
</table>

	<p><h2> Enter in the information below </h2></p>
	<form method="POST" action="inventory.php">
			<td width="100"></td>
			<tr>
				<td width="100">Food Name:</td>
				<td><input name="itdesc" type="text" ></td><br>
			</tr>
			<tr>
				<td width="100">Item Cost:</td>
				<td><input name="itcost" type="quantity" ></td><br>
			</tr>
			<tr>
				<td width="100">Item Price:</td>
				<td><input name="itprice" type="quantity" ></td><br>
			</tr>
			<tr>
				<td width="100">Quantity:</td>
				<td><input name="quty" type="quantity" ></td><br>
			</tr>
			
			<tr>
				<td width="100"> </td>
				<td> </td>
			</tr>
			<tr>
				<td width="100"> </td>
				<td>
					<input name="update" type="submit" id="update" value="Submit">
					<input type="Reset">
				</td>
			</tr>
		</table>
	</form>
	</center>
<?php

	$servername = "localhost";
	$username = "hcifall22";
	$password = "hcifall22";
	$dbname = "hcifall22";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error($conn));
	}
	
	mysqli_select_db($conn, $dbname);

?>

<?php
	if(isset($_POST['update'])){

		$itemdesc = $_POST['itdesc'];
		$itemcost = $_POST['itcost'];
		$itemprice = $_POST['itprice'];
		$quty = $_POST['quty'];
		
		$query = "select item_num from module5 where item_desc = '$itemdesc'";
		
		$retval = mysqli_query( $conn, $query );
		if(! $retval ) {
			die('Could not find item: ' . mysqli_error($conn));
		}
		//echo "Updated data successfully\n";
		
		if ($retval->num_rows > 0) {
		$row = $retval->fetch_assoc();
		if (!$row) {
			die('Item is not in table: ' . mysqli_error($conn));
		}
		$itnum = $row['item_num'];
		
		$sql = "UPDATE module5 SET item_cost = $itemcost, item_price = $itemprice, qty = '$quty' WHERE item_num= $itnum";
		
		$retval = mysqli_query( $conn, $sql );
		if(! $retval ) {
			die('Could not update data: ' . mysqli_error($conn));
		}
		//echo "Updated data successfully\n";
		}
		else {
			$query = "INSERT INTO module5(item_desc, item_cost, item_price, qty) " .
            "values('$itemdesc', '$itemcost', '$itemprice', '$quty')";
			
			$retcontents = mysqli_query( $conn, $query );
				if(! $retcontents ) {
				die('Could not update data: ' . mysqli_error($conn));
				}
		}
		
		$rowchange = "select * from module5";
		$return = mysqli_query( $conn, $rowchange );
		if(! $return ) {
			die('Could not find item: ' . mysqli_error($conn));
		}

		echo"<h2><center>Seller View of Previously Placed Orders </center></h2>";
		
		$total = 0;
		$y = 1;
  		if ($return->num_rows > 0) {
			while($row = $return->fetch_assoc()) {
				$total = $total + $row['qty'] * $row['item_price'];

				/*
				echo "<center><br><b>Item Description:</b> " . $row["item_desc"]. "<br/> <b>Item Cost:</b> " . 
				$row["item_cost"] . "<br/> <b>Item Price:</b> " . 
				$row["item_price"] . "<br/> <b>Quantity:</b> " . 
				$row["qty"] . "<br/> <b>Created:" . $row["add_time"]. "<br/></b><br/></center>";
			}
				*/
				
				echo "<center><br><b>Item Description:</b> " . $row["item_desc"]. "<br/> <b>Quantity:</b> " . 
				$row["qty"] . "<br/> <b>Previous Buyer Order:" . $row["add_time"]. "<br/></b><br/></center>";

				if($row['qty'] < 999) {
					echo "<font color=green>";
					echo $row['qty'];
					echo " of " . $row["item_desc"] . " ordered";
					echo "</font>";
			  
				  }else{
					echo $row['qty'];
					echo " of " . $row["item_desc"] . " ordered";
				  }
			}

				echo"<center><h2>Total Day Sales </h2>";
				echo "<br/>If sold all, I will get:$ " . $total  * $y . "<br/></center>";
			} else {
				echo "0 results";
			}
		}

		echo "<center>Connected successfully</center>";
		$conn->close();
?>
	<a href="#top">Home</a>
	</body>
</html>