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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="reviewsfailed.html";
  $loginUsername = $_POST['email'];
  $LoginRS__query = sprintf("SELECT email FROM guestbook WHERE email=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_sixstar, $sixstar);
  $LoginRS=mysql_query($LoginRS__query, $sixstar) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO guestbook (name, email, `comment`) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['comment'], "text"));

  mysql_select_db($database_sixstar, $sixstar);
  $Result1 = mysql_query($insertSQL, $sixstar) or die(mysql_error());

  $insertGoTo = "reviews.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_sixstar, $sixstar);
$query_Recordset1 = "SELECT name, `comment` FROM guestbook ORDER BY id ASC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $sixstar) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Hotel Six Star</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="layout.css" rel="stylesheet" type="text/css" />
<script src="js/maxheight.js" type="text/javascript"></script>

</head>
<body id="page5" onload="new ElementMaxHeight();">
<div id="main">
<!-- header -->
	<div id="header" class="small">
		<div class="row-1">
			<div class="wrapper">
				<img src="images/LOGO.png" alt="Hotel Six Star Logo"/>
				<div class="phones">
					<p>Contact Us</p>
					<p>1-800-263-1905</p>
				</div>
			</div>
		</div>
		<div class="row-2 alt">
	 		<div class="indent">
<!-- header-box-small begin -->
				<div class="header-box-small">
					<div class="inner">
						<ul class="nav">
					 		<li><a href="index.html">Home page</a></li>
							<li><a href="services.html">Services</a></li>
							<li><a href="gallery.html">Gallery</a></li>
							<li><a href="restaurant.html">Restaurant</a></li>
							<li><a href="Reviews.html" class="current">Reviews</a></li>
							<li><a href="booking.php">Booking</a></li>
						</ul>
					</div>
				</div>
<!-- header-box-small end -->
			</div>
		</div>
       </div> 
<!-- modal -->
  <div id="openModal" class="modalDialog">
				<div>
					<a href="#close" title="Close" class="close">X</a>
					<h3>Customer reviews</h3>
		
                  <table id="tb2">
                        <form action="<?php echo $editFormAction; ?>" id="form1" method="post"/>
                        <table id="tb3">
                        <tr>
                        <td width="117">Name</td>
                        <td width="14">:</td>
                        <td width="357"><input name="name" type="text" id="name" size="40" /></td>
                        </tr>
                        <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><input name="email" type="text" id="email" size="40" /></td>
                        </tr>
                        <tr>
                        <td valign="top">Comment</td>
                        <td valign="top">:</td>
                        <td><textarea name="comment" cols="40" rows="3" id="comment"></textarea></td>
                        </tr>
                        <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="Submit" value="Submit" /> <input type="reset" name="Submit2" value="Reset" /></td>
                        </tr>
                        </table>
                        <input type="hidden" name="MM_insert" value="form1" />
                        
                  
				</div>
  </div>
<!-- content -->
	<div id="content">
		<div class="gallery">
			<ul>
				<li><a href="#"><img alt="" src="images/2page-img1.jpg" /></a></li>
				<li><a href="#"><img alt="" src="images/2page-img2.jpg" /></a></li>
				<li><a href="#"><img alt="" src="images/2page-img3.jpg" /></a></li>
				<li><a href="#"><img alt="" src="images/2page-img4.jpg" /></a></li>
				<li><a href="#"><img alt="" src="images/2page-img5.jpg" /></a></li>
				<li><a href="#"><img alt="" src="images/2page-img6.jpg" /></a></li>
			</ul>
		</div>
        
		<div class="indent">
			<h2>Customers’ Reviews</h2>
			<ul class="list4">
            	<li>
				<table width="673" height="32" class="reviews">
                	<?php do { ?>
               	    <tr>
                	    <td width="160" height="16"><?php echo $row_Recordset1['name']; ?></td> 
                	    <td width="501"><?php echo $row_Recordset1['comment']; ?></td>
              	    </tr>
                	  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                	
                </table>
				</li>
			</ul>
			<div class="button1"><span><span><a href="#openModal">SUBMIT YOUR OWN REVIEW</a></span></span></div>
		</div>
	</div>
</div>
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
mysql_free_result($Recordset1);
?>
