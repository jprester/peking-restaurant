<?php require_once('../init.php');
Session::init();
if (!isset($_SESSION['logged'])){
Session::destroy();
header('location: ../index.php');
}

 ?>

 <?php
$page="admin";
 include("../inc/header.php"); ?>



<div class = "container_12">

	<br/>


<div class="grid_6 prefix_3">
<div id ="title"><h2>Glavni izbornik</h2></div><br/> <div class="container_12 text-c"><p class ="txt1">Izaberite koji dio menija želite uređivati</p></div></div>
<div class="grid_3">
		

		<div class="log-form">

				<p class ="log-pic"> <img src="../img/lock.png" width="13" height="17"></p>
				<p class ="log-options">

					 <?php	if($_SESSION['logged']) {
						?>
						Prijavljeni ste kao : <?php echo Session::get('logged'); ?>. <br />	 Odjavite se <a href="logout.php" tite="Logout">ovdje.</a>
						<?php
						}

						else{

							session_write_close(); // OVO JE JAKO BITNO DA PRESTANE PISAT SESSION I U IDUĆOJ LINIJI POŠALJE NA REDIRECT						
							Session::destroy();
							header('location: ../index.php');
							exit;
						}
						?>

				 </p>
				<div class ="clear"></div>

		</div>

	</div>

<div class ="clear"></div>
			


		<br />	

		
		<ul>
		
				<?php					
					$meni=new Meni();
					$meni_array=$meni->getMeni();  
					 foreach ($meni_array as $row) {
					echo "<li class ='text-c'><a href=meni_popis.php?fname=".$row['mid']." >" . $row['meni_ime'] . "</a></li>";
					}
					?>
		</ul>
			
		   <br />		
	
	   <hr/><br />


</div>
<?php include('../inc/footer.php')?>