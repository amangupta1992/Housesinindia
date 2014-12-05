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
			if(isset($_POST['mot']))
			{
				$te = $_POST['mot'] ;
			}
			else
			{
				$te ="";
			}
			echo "<form id='form' action='research.php' method=post>" ;
			echo "<br/><h3>" . "Write key words to find houses : " . "</h3>" ;
			echo "<input class='text' name='mot' type='text' value='".$te."'><br/><br/>" ;
			echo '<input class="button" name="search" type="submit" value="Search"><br/><br/>'; 
			echo '</form>';
			
			if(isset($_POST['mot']))
			{
				$var = $_POST['mot'];
			}
			include("variables.php");
			if(isset($_POST['search']))
			{
				$mcs = explode(" ",$var);
				if(count($mcs)>3)
				{
					echo "Too many keywords entered (Max: 3)";
				}
				else
				{
					$patterns = array();
					$replacements = array();

					if(count($mcs)==1)
					{
						$mc1 = $mcs[0] ;
						$request = "select housedetail , housephoto , houseid from house where housedetail like ('"."%".$mc1."%"."') order by housedetail";
						$patterns[0] = '/'.$mc1.'/';
						$remplacement[0] = "<b><font color='red'>".$mc1."</font></b>";
					}
					if(count($mcs)==2)
					{
						$mc1 = $mcs[0] ;
						$mc2 = $mcs[1] ;
						$request = "select housedetail , housephoto , houseid from house where housedetail like ('"."%".$mc1."%"."') or housedetail like ('"."%".$mc2."%"."') order by housedetail";
						$patterns[0] = '/'.$mc1.'/';
						$patterns[1] = '/'.$mc2.'/' ;
						$remplacement[0] = "<b><font color='red'>".$mc1."</font></b>";
						$remplacement[1] = "<b><font color='red'>".$mc2."</font></b>";
					}
					if(count($mcs)==3)
					{
						$mc1 = $mcs[0] ;
						$mc2 = $mcs[1] ;
						$mc3 = $mcs[2] ;
						$request = "select housedetail , housephoto , houseid from house where housedetail like ('"."%".$mc1."%"."') or housedetail like ('"."%".$mc2."%"."') or housedetail like ('"."%".$mc3."%"."') order by housedetail";
						$patterns[0] = '/'.$mc1.'/';
						$patterns[1] = '/'.$mc2.'/';
						$patterns[2] = '/'.$mc3.'/';
						$remplacement[0] = "<b><font color='red'>".$mc1."</font></b>";
						$remplacement[1] = "<b><font color='red'>".$mc2."</font></b>";
						$remplacement[2] = "<b><font color='red'>".$mc3."</font></b>";
					}
					
					$result = mysql_query("$request");
			
					if (mysql_errno()==0)
					{ 
						if(mysql_num_rows($result) != 0)
						{
							echo "<table border=1>";
							echo "<tr>";
							echo "<td><h4>House details</h4></td>";
							echo "<td><h4>House photo</h4></td>";
							echo "<td><h4>Visit</h4></td>";
							echo "</tr>";
							 
							while($row = mysql_fetch_array($result))
							{
								
								echo "<tr><td>";
								$string = $row["housedetail"] ;

								echo preg_replace($patterns, $remplacement, $string);

								echo "</td><td>"; 	
								$buff = $row["housephoto"] ;
								$buff1 = "<img src='img/".$row["housephoto"]."'>";
								echo '<a href="detailsHouse.php?id_photo=' ;
								echo $buff ;
								echo '">' ;
								echo $buff1 ;
								echo '</a>';
								echo "</td><td>"; 
								echo '<form id="form1"><input class="button1" name="visite" type="button" value="Visit" OnClick="window.location.href=\'confirmVisit.php?id_house='.$row["houseid"].'\'"></form>';
								echo "</td></tr>"; 	
							}
							
							echo "</table>";
						}
						else
						{
							echo "No house found";
						}
					}
				}
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
