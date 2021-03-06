<?php session_start(); include("variables.php");?>

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
		echo '<li><a href="index.php">Main</a></li>' ;
		echo '<li><a href="houses.php">Houses</a></li>' ;
		echo '<li class="current"><a href="research.php">Research houses</a></li>';
		echo '<li><a href="admin.php">Administration</a></li>';
		echo '</ul>';		
	  ?>      
      </nav>
    </div>
  </header>
  <!--==============================content================================-->
  <section id="content">
    <div class="container_12">
		<?php		
		echo "<h3>" . "House details : " . "</h3>" ;
		if(isset($_GET["id_photo"]))
		{
			$var = $_GET["id_photo"] ;
			$requete = "select b.houseid , b.housename , b.housedetail , b.houseprice, b.houseadr , t.housetype , b.housephoto  from house b , typeofhouse t 
						where b.idtype = t.idtype and b.housephoto = '$var'  ;";
						
			$result = mysql_query("$requete");
			if (mysql_errno()==0)
			{ 
				echo "<table>";
				echo "<tr>";
				echo "<td><h4>House photo</h4></td>";
				echo "<td><h4>House name</h4></td>";
				echo "<td><h4>House detail</h4></td>";
				echo "<td><h4>House address</h4></td>";
				echo "<td><h4>House price</h4></td>";
				echo "<td><h4>Kind of house</h4></td>";
				echo "<td><h4>Number of demand of visit</h4></td>";
				echo "</tr>";
				 
				while($row = mysql_fetch_array($result))
				{
					$idB = $row["houseid"] ;
					$requete2 = "select count(*) as nbD from request d , visiter v , house b where d.requestid = v.requestid and v.houseid = '$idB' and b.houseid = v.houseid;";
					$result2 = mysql_query("$requete2");
					$row2 = mysql_fetch_array($result2);
					echo "<tr><td>";
					$buff = $row["housephoto"] ;
					$buff1 = "<img src='img/".$row["housephoto"]."'>";
					echo '<a href="detailsHouse.php?id_photo=' ;
					echo $buff ;
					echo '">' ;
					echo $buff1 ;
					echo '</a>';
					echo "</td><td>"; 
					echo $row["housename"];
					echo "</td><td>"; 
					echo $row["housedetail"];
					echo "</td><td>"; 
					echo $row["houseadr"];
					echo "</td><td>"; 
					echo $row["houseprice"];
					echo "</td><td>";
					echo $row["housetype"];
					echo "</td><td>";
					echo $row2["nbD"];
					echo "</td></tr>";
				}
			}
			else
			{
				echo "Probleme .... ";
				echo (mysql_error());
			}
			echo "</table>";
				
			//Les house ressemblants
			echo "<h3>" . "Similar houses : " . "</h3>\n\n" ;
			$requete3 = "select b.housephoto , b.housename from house b where b.houseid IN ( select r.houseid2 from ressembler r where r.houseid1 IN (select b.houseid from house b where b.houseid = '$idB'));";
			$result3 = mysql_query("$requete3");
			if (mysql_errno()==0)
			{ 
				if (mysql_num_rows($result3)!=0)
				{
					echo "<table>";
					echo "<tr>";
					echo "<td><h4>House photo</h4></td>";
					echo "<td><h4>House name</h4></td>";
					echo "</tr>";
					while($row3 = mysql_fetch_array($result3))
					{
						echo "<tr><td>";
						$buff = $row3["housephoto"] ;
						$buff1 = "<img src='img/".$row3["housephoto"]."'>";
						echo '<a href="detailsHouse.php?id_photo=' ;
						echo $buff ;
						echo '">' ;
						echo $buff1 ;
						echo '</a>';	
						echo "</td><td>";
						echo $row3["housename"];
						echo "</td></tr>";
					}
					echo "</table>";
				}
				else
				{
					echo "<strong>No similar houses</strong>";
				}
			}
			else		
			{
				echo "Problem .... ";
				echo (mysql_error());
			}		
		}
		else
		{
			echo "Problem";
			echo (mysql_error());
		}	
		?>
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
