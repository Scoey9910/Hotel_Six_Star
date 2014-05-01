<?php require_once('Connections/sixstar.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "reservation-form")) {
  $insertSQL = sprintf("INSERT INTO booking (first_name, last_name, email, phone_number, checkin, checkout, type_room, checkinDate, checkinDateYear, checkouDate, checkouYear) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['text1'], "text"),
                       GetSQLValueString($_POST['text2'], "text"),
                       GetSQLValueString($_POST['text3'], "text"),
                       GetSQLValueString($_POST['text4'], "int"),
                       GetSQLValueString($_POST['month_start'], "text"),
                       GetSQLValueString($_POST['month_start'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['day_start'], "text"),
                       GetSQLValueString($_POST['year_start'], "text"),
                       GetSQLValueString($_POST['day_start'], "text"),
                       GetSQLValueString($_POST['year_start'], "text"));

  mysql_select_db($database_sixstar, $sixstar);
  $Result1 = mysql_query($insertSQL, $sixstar) or die(mysql_error());

  $insertGoTo = "index.html";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_sixstar, $sixstar);
$query_Recordset2 = "SELECT * FROM booking ORDER BY id ASC";
$Recordset2 = mysql_query($query_Recordset2, $sixstar) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Hotel Six Star</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="layout.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="js/maxheight.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
</head>

<body id="page5" onload="new ElementMaxHeight();">
<div id="main">
<!-- header -->
	<div id="header">
		<div class="row-1">
	 		<div class="wrapper">
				<img src="images/LOGO.png" alt="Hotel Six Star Logo"/>
				<div class="phones">
					<p>Contact Us</p>
					<p>1-800-263-1905</p>
			  </div>
			</div>
		</div>
		<div class="row-2">
	 		<div class="indent">
<!-- header-box begin -->
				<div class="header-box">
					<div class="inner">
						<ul class="nav">
					 		<li><a href="index.html">Home page</a></li>
							<li><a href="services.html">Services</a></li>
							<li><a href="gallery.html">Gallery</a></li>
							<li><a href="restaurant.html">Restaurant</a></li>
							<li><a href="reviews.php">Reviews</a></li>
							<li><a href="booking.html" class="current">Booking</a></li>
						</ul>
					</div>
				</div>
<!-- header-box end -->
			</div>
		</div>
	</div>
<!-- content -->
	<div id="content">
		<div class="wrapper">
			<div class="aside maxheight">
<!-- box begin -->
				<div class="box maxheight">
				  <div class="inner">
						<h3>Reservation:</h3>
					<form action="<?php echo $editFormAction; ?>" method="post" id="reservation-form">
		 			  <fieldset>
                           	  <fieldset class="date"> 
  <legend>Check In</legend> 
  <label for="month_start">Month</label> 
  <select id="month_start" 
          name="month_start"> 
    <option>January</option>       
    <option>February</option>       
    <option>March</option>       
    <option>April</option>       
    <option>May</option>       
    <option>June</option>       
    <option>July</option>       
    <option>August</option>       
    <option>September</option>       
    <option>October</option>       
    <option>November</option>       
    <option>December</option>       
  </select>
  <label for="day_start">Day</label> 
  <select 
          name="day_start" id="day_start" title="<?php echo $row_Recordset2['checkinDate']; ?>"> 
    <option>1</option>       
    <option>2</option>       
    <option>3</option>       
    <option>4</option>       
    <option>5</option>       
    <option>6</option>       
    <option>7</option>       
    <option>8</option>       
    <option>9</option>       
    <option>10</option>       
    <option>11</option>       
    <option>12</option>       
    <option>13</option>       
    <option>14</option>       
    <option>15</option>       
    <option>16</option>       
    <option>17</option>       
    <option>18</option>       
    <option>19</option>       
    <option>20</option>       
    <option>21</option>       
    <option>22</option>       
    <option>23</option>       
    <option>24</option>       
    <option>25</option>       
    <option>26</option>       
    <option>27</option>       
    <option>28</option>       
    <option>29</option>       
    <option>30</option>       
    <option>31</option>       
  </select> - 
  <label for="year_start">Year</label> 
  <select 
         name="year_start" id="year_start" title="<?php echo $row_Recordset2['checkinDateYear']; ?>"> 
    <option>2009</option>       
    <option>2010</option>       
    <option>2011</option>       
    <option>2012</option>       
    <option>2013</option>       
    <option>2014</option>       
    <option>2015</option>       
    <option>2016</option>       
    <option>2017</option>       
    <option>2018</option>       
  </select> 
  <span class="inst">(Month-Day-Year)</span> 
  </fieldset>
  <fieldset class="date"> 
  <legend>Check Out </legend> 
  <label for="month_start">Month</label> 
  <select id="month_start2" 
          name="month_start"> 
    <option>January</option>       
    <option>February</option>       
    <option>March</option>       
    <option>April</option>       
    <option>May</option>       
    <option>June</option>       
    <option>July</option>       
    <option>August</option>       
    <option>September</option>       
    <option>October</option>       
    <option>November</option>       
    <option>December</option>       
  </select> - 
  <label for="day_start">Day</label> 
  <select 
          name="day_start" id="day_start2" title="<?php echo $row_Recordset2['checkouDate']; ?>"> 
    <option>1</option>       
    <option>2</option>       
    <option>3</option>       
    <option>4</option>       
    <option>5</option>       
    <option>6</option>       
    <option>7</option>       
    <option>8</option>       
    <option>9</option>       
    <option>10</option>       
    <option>11</option>       
    <option>12</option>       
    <option>13</option>       
    <option>14</option>       
    <option>15</option>       
    <option>16</option>       
    <option>17</option>       
    <option>18</option>       
    <option>19</option>       
    <option>20</option>       
    <option>21</option>       
    <option>22</option>       
    <option>23</option>       
    <option>24</option>       
    <option>25</option>       
    <option>26</option>       
    <option>27</option>       
    <option>28</option>       
    <option>29</option>       
    <option>30</option>       
    <option>31</option>       
  </select> - 
  <label for="year_start">Year</label> 
  <select 
         name="year_start" id="year_start2" title="<?php echo $row_Recordset2['checkouYear']; ?>"> 
    <option>2009</option>       <?php echo $row_Recordset2['checkouYear']; ?>
    <option>2010</option>       
    <option>2011</option>       
    <option>2012</option>       
    <option>2013</option>       
    <option>2014</option>       
    <option>2015</option>       
    <option>2016</option>       
    <option>2017</option>       
    <option>2018</option>       
  </select> 
  <span class="inst">(Month-Day-Year)</span>
  
</fieldset>
<label for="type">Type of Room</label> 
  <select id="type" 
         name="type"> 
    <option>Single Room</option>       
    <option>Double Room</option>       
    <option>Deluxe Room</option>             
  </select> 
<div class="per">Persons: &nbsp;<input type="text" value="<?php echo $row_Recordset2['persons']; ?>"/>&nbsp; &nbsp; &nbsp; &nbsp; Rooms:&nbsp; <input type="text" value="<?php echo $row_Recordset2['rooms']; ?>"/>
  
</div>

                           	  <span class="selectRequiredMsg">Please select an item.</span>

                              <div class="fieldright">
                                <span id="sprytextfield1">
                                      <label for="text1">First Name</label>
                                      <input type="text" name="text1" id="text1" value="<?php echo $row_Recordset2['first_name']; ?>"/>
                                    <span class="textfieldRequiredMsg">*</span></span>
                                	<span id="sprytextfield2">
                                	<label for="text2">Last Name</label>
                                	<input type="text" name="text2" id="text2" value="<?php echo $row_Recordset2['last_name']; ?>"/>
                                	<span class="textfieldRequiredMsg">*</span></span>
                                    <span id="sprytextfield3">
                                    <label for="text3">Email</label>
                                    <input type="email" name="text3" id="text3" value="<?php echo $row_Recordset2['email']; ?>"/>
                                    <span class="textfieldRequiredMsg">*</span></span> 
                                    <span id="sprytextfield4">
                                    <label for="text4">Phone Number</label> 
                                    <input type="tel" name="text4" id="text4" value="<?php echo $row_Recordset2['phone_number']; ?>"/>
                                    <span class="textfieldRequiredMsg">*</span></span>
                                    <p>&nbsp;
                                </p>
                                    <p>
                                      <input type="submit" name="button" id="button10" style="width: 100px; background-color:#ffaa00; color: #f2f2f2f; " value="Book a Room" />
                                    </p>
                                    
							  </div>
                               
		 			  </fieldset>
		 			  <input type="hidden" name="MM_insert" value="reservation-form" />
					</form>
			  </div>
		  </div>
<!-- box end -->
	  </div>
			<div class="content">
				<div class="indent">
					<h2>Our location</h2>
					<img class="img-indent png" alt="" src="images/5page-img1.png" />
					<div class="extra-wrap">
						<p class="alt-top">Our hotel is located in Calhoun, Ga at the foothills of Smokey Mountains.</p>
						<p>Please feel free to come visit us at the following address:</p>
						<dl class="contacts-list">
							<dt>420 Baxter Rd SE</dt>
							<dt>Calhoun, Ga 30701</dt>
							<dd>1-800-263-1905</dd>
						</dl>
					</div>
					<div class="clear"></div>
				</div>
			</div>
  </div>
</div>

</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</body>
<!-- footer -->
	<footer>
  		<ul class="nav">
	 		<li><a href="index.html">Home</a></li>
			<li><a href="services.html">Services</a></li>
			<li><a href="gallery.html">Gallery</a></li>
			<li><a href="restaurant.html">Restaurant</a></li>
			<li><a href="reviews.php">Reviews</a></li>
			<li><a href="booking.php">Booking</a></li>
		</ul>
		<div class="wrapper">
			<div class="fleft">Copyright 2014 Six Star Hotel</div>
		</div>
	</footer>
</html>
<?php
mysql_free_result($Recordset2);
?>
