<?php require_once('init.php');
$message="";
Session::init();	
if(isset($_SESSION['login_error'])){
	$message="Pogrešno korisničko ime ili lozinka!";
}

Session::destroy();

	if (isset($_POST['submit'])){	

		if (empty($_POST['username']) || empty($_POST['password'])){

			$message="Niste upisali korisničko ime ili lozinku!";


		} else{

		$user=new User();
		$user->login( $_POST[ 'username' ], $_POST[ 'password' ]);


		}

				
	}

	else{


	}




 ?>