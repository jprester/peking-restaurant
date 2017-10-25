<?php require_once('../init.php');
	Session::init();
	if (!isset($_SESSION['logged'])){
	Session::destroy();
	header('location: ../index.php');
}
$page="admin";
$status="";
$jelo_id = $_REQUEST["fname"];
$jelo=new Jelo();
$jelo_arr= $jelo->chooseJelo($jelo_id);	
foreach ($jelo_arr as $row ) {
	$row_mid= $row['mid'];
	$row_jid= $row['jid'];
	$row_naziv= $row['naziv'];
	$row_naziv_en= $row['naziv_en'];
	$row_broj= $row['broj'];
	$row_sort= $row['sort'];
	$row_cijena= $row['cijena'];

}
include("../inc/header_private.php");?>
<?php
	// SPREMI
	 if  (isset($_POST['spremi'])) 	
			{
				$id = $jelo_id;
				$broj = $_POST["broj"];
				$sort = $_POST["sort"];
				$naziv = $_POST["naziv"];
				$naziv_en = $_POST["naziv_en"];
				$cijena = $_POST["cijena"];

				 $jelo = new Jelo();
				 $jelo->editJelo($id,$broj, $sort, $naziv,$naziv_en,$cijena);				 	
				 $status="Uspješno ste promijenili jelo!";

				 // Ponovo ucitaj formu!
				 $jelo=new Jelo();	
				 $jelo_arr= $jelo->chooseJelo($jelo_id);
				 foreach ($jelo_arr as $row ) {
				 $row_mid= $row['mid'];
				 $row_jid= $row['jid'];
				 $row_naziv= $row['naziv'];
				 $row_naziv_en= $row['naziv_en'];
				 $row_broj= $row['broj'];
				 $row_sort= $row['sort'];
				 $row_cijena= $row['cijena'];
 }
			}

	// DELETE
	if(isset($_POST['obrisi'])) 
			{
				Session::set('deleted', $row_mid);
				$jelo = new Jelo();
				$jelo->deleteJelo($jelo_id);
				header('location: meni_popis.php?fname='.Session::get('deleted'));
			}
?>


<div class = "container_12">
<br/>
 <?php if ($page=="admin") {	
 	echo "<a href='meni_popis.php?fname=".$row_mid."'> < POVRATAK</a>"; } ?> <br/>
	<div class="grid_6 prefix_3">
		<div id ="title">
			<h2>
				<?php
				$jelo = new Jelo();
				$jelo->chooseJelo($jelo_id);
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
			<div class ="text-c"><p><?php echo $status; ?></p></div> 
	<form name="form1" method="post" action="">
		<br/>
					<table class="uredi-table">
						 <tr class ="hide"><td><label>Id:</label></td>	<td><input type='text' name='jid'  id ='jid' class="small"  value=<?php echo  $row_jid ; ?>> </td></tr>
						<tr><td><label>Redni broj:</label></td>	 <td><input type='text' name='broj'  id ='broj' class="small"   value=<?php echo  $row_broj ; ?>></td></tr>
						<tr><td><label>Sortni broj:</label></td>	 <td><input type='text' name='sort'  id ='sort' class="small"   value=<?php echo  $row_sort ?>></td></tr>
						<tr> <td><label>Naziv:</label></td>	 <td><textarea name='naziv'  id ='naziv' class="big"><?php echo  $row_naziv; ?></textarea></td></tr>
						<tr> <td><label>Engleski naziv:</label></td>	<td><textarea name='naziv_en'   id ='naziv_en' class="big"><?php echo  $row_naziv_en ; ?></textarea></td></tr>
						<tr> <td><label>Cijena:</label></td>	<td><input type='text' name='cijena'  id ='cijena'  class="small" value=<?php echo  $row_cijena ; ?>></td></tr>

		</table>
		<br/>
		<div class ="text-c"><input type="submit" name="obrisi" value="Obriši" class ="red-button" id="delBtn" onclick="myAlert()"> 
		<input type="submit" name="spremi" value="Spremi" class ="red-button"></div><br/><br/>
		<br/>
	</form>
</div>
<?php include('../inc/footer.php')?>