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
			var message='Erreurs, champs invalides ou inexistant : \n';
			if((formula.type.value.length!=2)||(!verify_type(formula.type.value))){
				message+='--> Type : Greater than 0\n';
				bool=false;
			}
			if((formula.name.value.length<3)||(formula.name.value.length>30)){
				message+='--> name : minimum 4 characters, 30 characters maximum\n';
				bool=false;
			}
			if((formula.detail.value.length<10)||(formula.detail.value.length>50)){
				message+='--> Details : 10 character minimum , 50 character maximum\n';
				bool=false;
			}
			if((formula.adr.value.length<5)||(formula.adr.value.length>30)){
				message+='--> Address : 5 character minimum , 30 characters maximum\n';
				bool=false;
			}
			if(formula.file_photo.value.length<5){
				message+='--> file_photo is invalid\n';
				bool=false;
			}
			if((!verify_price(formula.price.value))||(formula.price.value.length<4)){
				message+='--> price : greater than 0, and in format XXXXX.XX\n';
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
		echo '<li class="current"><a href="modifyHouse.php?id_house=all">Modify house</a></li>';
		echo '<li><a href="deleteHouse.php">Delete house</a></li>';
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
		if($_GET['id_house'] == "all")
		{
			$request = "select * from house";
			$result = mysql_query("$request");
			if (mysql_errno()==0)
			{ 
				if(mysql_num_rows($result) != 0)
				{
					
					echo "<table>";
					echo "<tr>";
					echo "<td><h4>House detail</h4></td>";
					echo "<td><h4>House photo</h4></td>";
					echo "<td><h4>Modify this house</h4></td>";
					echo "</tr>";
					
					while($row = mysql_fetch_array($result))
					{
						
						echo "<tr><td>";
						echo $row["housedetail"] ;
						echo "</td><td>"; 	
						$buff = $row["housephoto"] ;
						$buff1 = "<img src='./img/".$row["housephoto"]."' width='150px'>";
						echo '<a href="/detailsHouse.php?id_photo=' ;
						echo $buff ;
						echo '">' ;
						echo $buff1 ;
						echo '</a>';
						echo "</td><td>";
						echo '<form id="form1"><input class="button1" name="modify" type="button" value="Modify" OnClick="window.location.href=\'modifyHouse.php?id_house='.$row['houseid'].'\'"></form>';
						echo "</td></tr>";
					}
					echo "</table>";	
				}
				else
				{
					echo "No houses found";
				}
			}
		}
		else
		{
			$request = "select * from house where houseid = '".$_GET['id_house']."';";
			$result = mysql_query("$request");
			if (mysql_errno()==0)
			{ 
				if(mysql_num_rows($result) != 0)
				{
					while($row = mysql_fetch_array($result))
					{
						if(!isset($_POST['valider']))
						{
							echo "<form id='form' class='form-1 bot-2' action='modifyHouse.php?id_house=".$_GET['id_house']."' method=post enctype='multipart/form-data'>" ;
							echo "<br/><img src='./img/".$row["housephoto"]."'>";
							echo "<fieldset>";
							echo "<label><strong>House name : </strong><input class='text' name='titre' type='text' value='".$row['housename']."'></label>";
							echo "<label><strong>House detail : </strong><textarea name='detail' type='text'>".$row['housedetail']."</textarea></label>";
							echo "<label><strong>House adress : </strong><input class='text' name='adr' type='text' value='".$row['houseadr']."'></label>";
							echo "<label><strong>House price : </strong><input class='text' name='price' type='text' value='".$row['houseprice']."'></label>";
							echo "<label><strong>Sell date : </strong><input class='text' name='date' type='text' value='".$row['dateoflisting']."'></label>";
							echo "<label><strong>House photo : </strong><input class='text' type='file' name='file_photo' value='.\img'".$row['housephoto']."'></label></fieldset>";
							echo '<input class="button" name="valider" type="submit" value="Submit">';
							echo "</form>" ;
						}				
					}
					
					if(isset($_POST['valider']))
					{
						$request = "update house set housename='".$_POST['title']."' , 
															housedetail='".$_POST['detail']."' , 
															houseadr='".$_POST['adr']."' , 
															houseprice=".$_POST['price']." , 
															dateoflisting='".$_POST['date']."'
															where houseid='".$_GET['id_house']."' ;" ;
						
						$result = mysql_query($request);
						if($result)
						{
							if($_FILES['file_photo']['name'] != "")
							{
								$destination = "./img/";
								unlink("./img/".$_GET['id_house'].".jpg");
								move_uploaded_file($_FILES['file_photo']['tmp_name'], $destination.$_GET['id_house'].".jpg");
							}
						}
						echo "Your modification has been done successfully !!";									
					}
				}
				else
				{
					echo "No properties found";
				}
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
