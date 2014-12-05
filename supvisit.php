<?php   
session_start();
$i=0 ;
$is = 0;
while($i < $_SESSION['nbVisitesX'] && ($is != 1))
{
	if($_GET['id_house'] == $_SESSION['visitesX'][$i])
	{
		unset($_SESSION['visitesX'][$i]);
		$is = 1;
	}
	$i++ ;
}
$i-- ;
while($i<$_SESSION['nbVisitesX']-1)
{
	$_SESSION['visitesX'][$i] = $_SESSION['visitesX'][$i+1];
	$i++;
}
$_SESSION['nbVisitesX'] -- ;	

?>

<script type="text/javascript">
var obj = 'window.location.replace("http://localhost/realestate/request.php");';
setTimeout(obj,0000);
</script>
