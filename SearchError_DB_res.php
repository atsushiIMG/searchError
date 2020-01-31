<?php 
	header("Content-type: text/html");
	//クロスサイトリクエストフォージェリ（CSRF）対策
	$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
	$token = $_SESSION['token'];
	//クリックジャッキング対策
	header('X-FRAME-OPTIONS: SAMEORIGIN');
	//DB接続 start
	$dsn='mysql:dbname=xxxx;host='xxx';
	$user='xxx';	
	$password = 'xxx';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	//テーブル登録
	$sql = "CREATE TABLE IF NOT EXISTS error_table_v2"
	."("
	."id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,"
	."lang VARCHAR(20) NOT NULL,"
	."error VARCHAR(1500) NOT NULL,"
	."sol VARCHAR(1500) NOT NULL 
"	.");";
	$stmt = $pdo->query($sql);

	//0ならエラーなし、1ならエラーあり
	$error_flag = 0;
	if(isset($_POST["lang"]) && isset($_POST["sol"]) && isset($_POST["error"])){
		echo "登録ありがとうございます。";
		$sql = $pdo -> prepare("INSERT INTO error_table_v2(lang, error, sol) VALUES (:lang, :error, :sol)");
		$sql->bindParam(':lang', $lang, PDO::PARAM_STR);
		$lang = $_POST["lang"];
		$sql->bindParam(':error', $error, PDO::PARAM_STR);
		$error = $_POST["error"];
		$sql->bindParam(':sol', $sol, PDO::PARAM_STR);
		$sol = $_POST["sol"];
		$sql->execute();
	}
	else{
		$error_flag = 1;
		echo "入力フォームに正しく入力されていません";
	}
	// DB show
	$sql = 'SELECT * FROM error_table_v2';
	$stmt=$pdo->query($sql);
	$res=$stmt->fetchAll();
	// foreach ($res as $row){
	// 	//$rowの中にはテーブルのカラム名が入る
	// 	echo $row['id'].' ';
	// 	echo $row['lang'].' ';
	// 	echo $row['error'].' ';
	// 	echo $row['sol'].'<br>';
	// 	echo "<hr>";
	// }

?>
