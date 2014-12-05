     <?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Houses in India</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" media="screen" href="css/reset.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/grid_12.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/slider.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/jqtransform.css">
<script src="js/jquery-1.7.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/cufon-yui.js"></script>
<script src="js/vegur_400.font.js"></script>
<script src="js/Vegur_bold_700.font.js"></script>
<script src="js/cufon-replace.js"></script>
<script src="js/tms-0.4.x.js"></script>
<script src="js/jquery.jqtransform.js"></script>
<script src="js/FF-cash.js"></script>

<script language="Javascript">
		function verify_price(price){
			var reg=new RegExp(/^([1-9]{1}[0-9]{0,7})\.[0-9]{2}$/);
			return reg.test(price);
		}
		function verify_type(type){
			var reg=new RegExp(/^F{1}[1-9]$/);
			return reg.test(type);
		}
		function verify_form_house(){
			var formula=document.formB;
			var bool=true;
			var message='Errors, invalid or nonexistent fields : \n';
			if((formula.type.value.length!=2)||(!verify_type(formula.type.value))){
				message+='--> Type : greater then 0\n';
				bool=false;
			}
			if((formula.name.value.length<3)||(formula.name.value.length>30)){
				message+='--> Name : 4 characters min, 30 max\n';
				bool=false;
			}
			if((formula.detail.value.length<10)||(formula.detail.value.length>50)){
				message+='--> Details : 10 characters min, 50 max\n';
				bool=false;
			}
			if((formula.adr.value.length<5)||(formula.adr.value.length>30)){
				message+='--> Address : 5 characters min, 30 max\n';
				bool=false;
			}
			if(formula.file_photo.value.length<5){
				message+='--> File_photo : 5 characters min\n';
				bool=false;
			}
			if((!verify_price(formula.price.value))||(formula.price.value.length<4)){
				message+='--> Price : greater than 0, in format XXXXX.XX\n';
				bool=false;
			}
			if(bool==false){
				alert(message);
				return false;
			}else{
				return true;
			}
		}
</script>
<script>
$(document)
    .ready(function () {
    $('.form-1')
        .jqTransform();
    $('.slider')
        ._TMS({
        show: 0,
        pauseOnHover: true,
        prevBu: '.prev',
        nextBu: '.next',
        playBu: false,
        duration: 1000,
        preset: 'fade',
        pagination: true,
        pagNums: false,
        slideshow: 7000,
        numStatus: false,
        banners: false,
        waitBannerAnimation: false,
        progressBar: false
    })
});
</script>
<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="css/ie.css">
<![endif]-->
</head>
<body>
<div class="main">
  <!--==============================header=================================-->
  <header>
    <div>
      <h1><a href="index.html"><img src="images/logo.jpg" alt=""></a></h1>
      <div class="social-icons"></div>
      <div id="slide">
        <div class="slider">
          <ul class="items">
            <li><img src="images/slider-1.jpg" alt=""></li>
            <li><img src="images/slider-2.jpg" alt=""></li>
            <li><img src="images/slider-3.jpg" alt=""></li>
          </ul>
        </div>
        <a href="#" class="prev"></a><a href="#" class="next"></a> </div>
      <nav>
	  <?php
		echo '<ul class="menu">';
		echo '<li><a href="newHouse.php">New house</a></li>' ;
		echo '<li><a href="modifyHouse.php?id_house=all">Modify house</a></li>';
		echo '<li  class="current"><a href="deleteHouse.php">Delete house</a></li>';
		echo '<li><a href="logout.php">Logout</a></li>' ;
		echo '</ul>';
	  ?>
        
      </nav>
    </div>
  </header>
  <!--==============================content================================-->
  <section id="content">
    <div class="container_12">
      <div class="grid_8"></div>
		<?php
			include("variables.php");
			if(isset($_POST['sub']))
			{
				$requete = "update house set dateoflisting = NOW() where houseid = '".$_POST['idb']."';" ;
				$result = mysql_query($requete);
			}
			$requete = "select * from house where dateoflisting='0000-00-00'";
			$result = mysql_query("$requete");
	
			if (mysql_errno()==0)
			{ 
				if(mysql_num_rows($result) != 0)
				{
					
					echo "<table>";
					echo "<tr>";
					echo "<td><h4>House detail</h4></td>";
					echo "<td><h4>House photo</h4></td>";
					echo "<td><h4>Delete this house</h4></td>";
					echo "</tr>";
					
					while($row = mysql_fetch_array($result))
					{
						
						echo "<tr><td>";
						echo $row["housedetail"] ;
						echo "</td><td>"; 	
						$buff = $row["housephoto"] ;
						$buff1 = "<img src='./img/".$row["housephoto"]."' width='150px'>";
						echo '<a href="detailsHouse.php?id_photo=' ;
						echo $buff ;
						echo '">' ;
						echo $buff1 ;
						echo '</a>';
						echo "</td><td>";
						echo "<form id='form1' name='form_sale' method=post>";
						echo "<input name=\"idb\" type=\"hidden\" value=\"".$row['houseid']."\"/>"; 
						echo "<input class='button1' name=\"sub\" type=\"submit\" value=\"Sold\"/></form>";
						echo "</td></tr>";
					}
					
					echo "</table>";
					
				}
				else
				{
					echo "No house founded";
				}
			}
		?>
      </div>
      <div class="clear"></div>
    </div>
  </section>
</div>
<!--==============================footer=================================-->
<footer>
</footer>
<script>Cufon.now();</script>
</body>
</html>
