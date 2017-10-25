<?php include('admin/init.php');
	$visit1="";
	$visit2="";
	$visit3="";
	$visit4="";
	$dvisit1="";
	$dvisit2="";
	$dvisit3="";
	$meni = new Meni();
	$meni_array = $meni->getMeni();
foreach ($meni_array as $row)  {
	echo("<li><a href=meni_izbor.php?fname=".trim($row['mid'])." >" . $row['meni_ime'] . $row['en_ime']."</a></li>");
} ?>
<li><a href="meni(m2osobe).php" class ="<?php echo $dvisit1 ?>" > MENU ZA 2 OSOBE </a></li>
<li><a href="meni(m3osobe).php" class ="<?php echo $dvisit2 ?>" > MENU ZA 3 OSOBE </a></li>
<li><a href="meni(m4osobe).php" class ="<?php echo $dvisit3 ?>" > MENU ZA 4 OSOBE </a></li>
