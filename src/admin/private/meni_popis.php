<?php require_once('../init.php');
Session::init();
if (!isset($_SESSION['logged'])){
Session::destroy();
header('location: ../index.php');
}
?>

<?php
$page="admin";
$status="";
$meni_ime = $_REQUEST["fname"];
include("../inc/header_private.php"); 


 	if (isset($_POST['submit']))
 	{

		 if (empty($_POST['broj'])|| empty($_POST['sort']) || empty($_POST['naziv']) || empty($_POST['naziv_en']) || empty($_POST['cijena'])) 
				{	
					$status="Ostavili ste neka polja prazna"; 
				} else {
				$jelo=new Jelo();
				$jelo->insertJelo( $_POST['sort'], $_POST['broj'], $_POST['naziv'], $_POST['naziv_en'], $_POST['cijena'], $meni_ime );	
				$status="Dodali ste novo jelo!";
			}
	}
 ?>

<div class = "container_12">
	<br/> 
<?php if ($page=="admin") {	echo "<a href='admin.php'> < POVRATAK</a>";} ?>
		<br/>
	<div class="grid_6 prefix_3">

		<div id ="title">
			<h2>
				<?php 
				$page_id=$_REQUEST["fname"];
				$meni = new Meni();
				echo $meni->chooseMeni($page_id);		   
				 ?>
			</h2>
		</div>
		<br/> 
	</div>
	<div class="grid_3">
		<div class="log-form">
				<p class ="log-pic"> <img src="../img/lock.png" width="13" height="17"></p>
				<p class ="log-options">
					 <?php	if($_SESSION['logged']) {
						?>
						Prijavljeni ste kao : <?php echo Session::get('logged'); ?>. <br/>	 Odjavite se <a href="logout.php" tite="Logout">ovdje.</a>
						<?php
						}

						else {
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
		<div class ="text-c"><p><?php echo $status; ?></p>
		<?php if (isset($_SESSION['deleted'])){
			echo "Obrisali ste jelo id: ".Session::get('deleted');
		 unset($_SESSION['deleted']);
		}
		 ?>
		</div>
			<br/>	<br/>
		<table class ="popis-table">
			<tr>
				<th>redni broj</th><th>sortni broj</th><th>naziv jela</th><th>engleski naziv</th><th>cijena</th><th></th>

			</tr>
				
					<?php 
					$jelo=new Jelo(); 
					$array_jela= $jelo->getJela($meni_ime);
					foreach ($array_jela as $row) {
						echo "<tr>".
						"<td>".$row['broj']."</td>".
						"<td>".$row['sort']."</td>".
						"<td>".$row['naziv']."</td>".
						"<td>".$row['naziv_en']."</td>".
						"<td>".$row['cijena']."</td>".
						"<td><a href=meni_jelo.php?fname=".$row['jid']." >" . 'UREDI' . "</a></td>".
						"</tr>";
					}
					 ?>

		</table>
		<br/>	<br/>
	<form name="form1" method="post" action ="">
<br/>
	<h4 class="text-c">Dodaj novo jelo</h4>
	<br/>

		<table class ="dodaj-table">
		<tr> <td><label>redni broj</label></td>  <td><input type='text' name='broj' id="broj" class ="small"></td></tr>

		<tr> <td><label>sortni broj</label></td>  <td><input type='text' name='sort' id="sort" class ="small"></td></tr>

		<tr><td><label>naziv</label></td>  <td><textarea name='naziv' id="naziv" ></textarea></td></tr>

		<tr><td><label>engleski naziv</label></td>  <td> <textarea name='naziv_en' id="naziv_en" ></textarea> </td></tr>

		<tr><td><label>cijena</label></td>  <td><input type='text' name='cijena' id="cijena" class ="small"></td></tr>

		<tr class ="hide"><td> <input type='text' name='meni_vrsta' id="meni_vrsta" value=<?php echo $meni_ime; ?></td></tr>

		</table>
		<br/>  <div class ="text-c"><input type="submit" name="submit" value="Submit" class ="red-button"></div><br/><br/>
	</form>
	</div>
 <?php include('../inc/footer.php')?>