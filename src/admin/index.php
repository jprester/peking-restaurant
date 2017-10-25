<?php require_once('init.php');
	require_once('login.php');
	$page="log";
	include("inc/header.php"); 
?>
<div id ="title"><h2>Login</h2></div><br/> <div class="container_12 text-c"><p class ="txt1">Ovo je stranica za uređivanje menija na web stranici kineskog restorana Peking. <br/> Molimo vas da se logirate sa Vašim korisničkim imenom i lozinkom.</p></div>
<br />
<div class = "container_12">
	<form name="frmUser" method="post" action="" class="adminform">
				<div class="message text-c"><?php echo $message;?></div>
				<table class="login-table">
					<tr>
						<td class ="text-r"><label>Korisničko ime</label></td> <td> <input type="text" name="username" class ="loginform"></td>
					</tr>

					<tr>
						<td class ="text-r"><label> Lozinka</label></td> <td>  <input type="password" name="password" class ="loginform"></td>
					</tr>
					<tr>
						<td colspan="2" class ="text-c">  <input type="submit" name="submit" value="Logiraj se" class ="red-button"></td>
					</tr>
				</table>
		</form>
</div>
<br/><br/><br/><br/><br/>
<?php include('inc/footer.php'); ?>



 