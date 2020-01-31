<?php 
	header("Content-type: text/html");
	//クロスサイトリクエストフォージェリ（CSRF）対策
	$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
	$token = $_SESSION['token'];
	//クリックジャッキング対策
	header('X-FRAME-OPTIONS: SAMEORIGIN');
	//DB接続 start
	$dsn='mysql:dbname=tb210435db;host=localhost';
	$user='tb-210435';	
	$password = 'uTCtdSRht7';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	// エラーなら1を立てる
	$error_flg = 0;
	$count = 0;
	$kekka_array = array();
	if(isset($_POST["lang_sol"])){
		//searchError_io.phpで入力されたlang_sol,error_solを変数に代入（PHPVer）
		$lang_sol = $_POST["lang_sol"];
		if(isset($lang_sol)){
			$sql = $pdo -> query("SELECT * FROM error_table_v2 WHERE lang='$lang_sol'");
			$res = $sql -> fetchAll();
		}
		else{
			echo "入力が不正です";
			$error_flg = 1;
		}
		// エラーがなければここを通過する
		if($error_flg == 0){
			echo $lang_sol."に登録されているエラーリストはこちら<br /><br />";
			foreach ($res as $value) {
				// echo $value[1]."  ";
				echo "エラー内容 ： ".$value[2]."<br />";
				echo "解決方法 ： ".$value[3]."<br>";
				echo "<hr>";
			}
		}
	}
?>
<!-- 
error_sol エラー番号とその内容 何行目っていうところはなくす
explode ( string $delimiter , string $string [, int $limit = PHP_INT_MAX ] ) : array

Parse error: syntax error, unexpected 'if' (T_IF) in /public_html/SearchError_io.php on line 21
20行目に(;)がなかった

Parse error: syntax error, unexpected '；' (T_STRING), expecting ',' or ';' in /public_html/SearchError_io.php on line 30
30行目で全角の；がはいっていたので半角の;に直した

Parse error: syntax error, unexpected end of file, expecting elseif (T_ELSEIF) or else (T_ELSE) or endif (T_ENDIF) in /public_html/SearchError_io.php on line 102
どっかでカッコが抜けている。必ずしも102ではない
<?php?>が2箇所に存在していたことによるエラー
preg_matchらへんと正規表現の理解必要
エラー表示をコピー、そのエラーの2個目までerrorまでの文字列を正規表現で表示
preg_matchの第一引数に正規表現持ってくる。第二引数にDBのErrorをあてて正規表現にあったやつを出力するようにしたい。
Preg_matChの第三引数が重要になってくると思われ。第三引数の配列の中に正規表現に当たったやつが格納されるのでは？？
1・31エラーの内容をコピペするのは今後の課題にしよう
とりあえずは選択された言語のエラー内容が出てくるようにしよう
1/31エラーがながいとTEXTが見えなくなるから長くした

 -->

<!DOCTYPE html>
<html>
<head>
	<title>SearchError</title>
</head>
<body>
	<h2>エラーの備忘録サイト</h2>
	<?php if ($error_flg == 0): ?>
	<form action="SearchError_io.php" method="post">
		<p>言語を選んでください
			<select name="lang_sol">
				<option value="python">python</option>
				<option value="php">php</option>
				<option value="mysql">その他</option>
			</select>
		</p>
		<input type="submit" name="">
	</form>
	<?php endif; ?>
</body>
</html>
