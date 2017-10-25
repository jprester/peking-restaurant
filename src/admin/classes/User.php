<?php class User extends Db{
	private $user_id;
	private $username;
	private $password;	

	public function __construct(){
		parent::__construct();
	}

	public function login($username, $password){
		$user=strip_tags(trim( $_POST['username']));
		$pass=strip_tags(trim( $_POST['password']));
		$sth = $this->pdo->prepare("SELECT * FROM user WHERE username = :username AND password=:password ");
 		$sth->execute(array(
			':username' => $user,
			':password'=>$pass
		));
	
		$count = $sth->rowCount();

		if ($count > 0) {
			Session::init();
			Session::set('logged', $_POST['username']);
			header('location:private/admin.php', true,  301);
		} else {
			Session::init();
			Session::set('login_error', "Wrong username or password. Please try again.");
			header('location:index.php');
		}
	}

	public function logout(){
		Session::init();
		Session::destroy();
	}
}
?>