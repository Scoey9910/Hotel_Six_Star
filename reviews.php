<?php require_once('Connections/sixstar.php'); ?><?php
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

<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Hotel Six Star</title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="text/css" http-equiv="Content-Style-Type" />
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link href="layout.css" rel="stylesheet" type="text/css" />
    <script src="js/maxheight.js" type="text/javascript"></script>
</head>

<body id="page5" onload="new ElementMaxHeight();">
    <div id="main">
        <!-- header -->

        <div class="small" id="header">
            <div class="row-1">
                <div class="wrapper">
                    <img alt="Hotel Six Star Logo" src="images/LOGO.png" />

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

                                <li><a href=
                                "restaurant.html">Restaurant</a></li>

                                <li><a class="current" href=
                                "Reviews.html">Reviews</a></li>

                                <li><a href="booking.php">Booking</a></li>
                            </ul>
                        </div>
                    </div><!-- header-box-small end -->
                </div>
            </div>
        </div><!-- modal -->

        <div class="modalDialog" id="openModal">
            <div>
                <a class="close" href="#close" title="Close">X</a>

                <h3>Customer reviews</h3>

                <form action="%3C?php%20echo%20$editFormAction;%20?%3E" id=
                "form1" method="post"></form>

                <table id="tb2">
                    <tr>
                        <td></td>
                    </tr>

                    <tr>
                        <td width="117">Name</td>

                        <td width="14">:</td>

                        <td width="357"><input id="name" name="name" size="40"
                        type="text" /></td>
                    </tr>

                    <tr>
                        <td>Email</td>

                        <td>:</td>

                        <td><input id="email" name="email" size="40" type=
                        "text" /></td>
                    </tr>

                    <tr>
                        <td valign="top">Comment</td>

                        <td valign="top">:</td>

                        <td>
                        <textarea cols="40" id="comment" name="comment" rows=
                        "3">
</textarea></td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>

                        <td>&nbsp;</td>

                        <td><input name="Submit" type="submit" value=
                        "Submit" /> <input name="Submit2" type="reset" value=
                        "Reset" /></td>
                    </tr>
                </table><input name="MM_insert" type="hidden" value="form1" />
            </div>
        </div><!-- content -->

        <div id="content">
            <div class="gallery">
                <ul>
                    <li><a href="#"><img alt="" src=
                    "images/2page-img1.jpg" /></a></li>

                    <li><a href="#"><img alt="" src=
                    "images/2page-img2.jpg" /></a></li>

                    <li><a href="#"><img alt="" src=
                    "images/2page-img3.jpg" /></a></li>

                    <li><a href="#"><img alt="" src=
                    "images/2page-img4.jpg" /></a></li>

                    <li><a href="#"><img alt="" src=
                    "images/2page-img5.jpg" /></a></li>

                    <li><a href="#"><img alt="" src=
                    "images/2page-img6.jpg" /></a></li>
                </ul>
            </div>

            <div class="indent">
                <h2>Customers’ Reviews</h2>

                <ul class="list4">
                    <li>
                        <table class="reviews" width="673">
                            <?php do { ?>

                            <tr>
                                <td height="16" width="160">
                                <?php echo $row_Recordset1['name']; ?></td>

                                <td width="501">
                                <?php echo $row_Recordset1['comment']; ?></td>
                            </tr><?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                        </table>
                    </li>
                </ul>

                <div class="button1">
                    <span><a href="#openModal">SUBMIT YOUR OWN
                    REVIEW</a></span>
                </div>
            </div>
        </div>
    </div><!-- footer -->

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
            <div class="fleft">
                Copyright 2014 Six Star Hotel
            </div>
        </div>
    </footer><?php
    mysql_free_result($Recordset1);
    ?>
</body>
</html>