<?php 
	header("Content-type: text/html;charset=UTF-8");
	//クロスサイトリクエストフォージェリ（CSRF）対策
	$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
	$token = $_SESSION['token'];
	//クリックジャッキング対策
	header('X-FRAME-OPTIONS: SAMEORIGIN');
	//DB接続 start
	$dsn='mysql:dbname=xxxxxxx;host=localhost';
	$user='txxxxxx';	
	$password = 'xxxxxxxxxxxx';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	// エラーなら1を立てる
	$error_flg = 0;
	$count = 0;
	$kekka_array = array();
	if(isset($_POST["lang_sol"]) and isset($_POST["error_sol"]) and isset($_POST["on_off"])){
		//searchError_io.phpで入力されたlang_sol,error_solを変数に代入（PHPVer）
		$lang_sol = $_POST["lang_sol"];
		$error_sol = $_POST["error_sol"];
		$on_off = $_POST["on_off"];

		// ソート機能 ON
		if($on_off == "on"){
			if(isset($lang_sol)){
				$sql = $pdo -> query("SELECT * FROM error_table_v2 WHERE lang='$lang_sol'");
				$res = $sql -> fetchAll();
			}
			else{
				echo "入力が不正です";
				$error_flg = 1;
			}
			// デバック用・テーブル内の内容を表示する
			// foreach ($res as $value) {
			// 	echo $value[0]."<br>";
			// 	echo $value[1]."<br>";
			// 	echo $value[2]."<br>";
			// 	echo $value[3]."<br>";
			// }
			// echo "<hr>";

			$space = " ";
			// echo mb_detect_encoding($error_sol);
			// $error_sol = mb_convert_encoding($error_sol, 'UTF-8');
			// echo gettype($error_sol);
			// $space = mb_convert_encoding($space, "UTF-8");
			// echo $space;
			// str_replaceに関して・第一 検索文字列、第二 置換後文字列、第三 検索対象文字列 指定した文字列が一致したら置き換える
			str_replace( "\xc2\xa0", " ", $space);//なぜこれでかわるの
			// echo $space;
			$error_sol_explode = explode($space,$error_sol);
			// echo mb_detect_encoding($error_sol);
			// foreach ($error_sol_explode as $value) {
			// 	echo $value."<br>";
			// }

			// エラーを出力しないとこの条件分岐を通る
			if($error_flg == 0){
				foreach ($res as $row) {
				// $row[2]がエラー内容に対応するわけ
					foreach ($error_sol_explode as $match){
						// echo "match:::".$match."<br>";
						// echo "row:::".$row[2]."<br>";
						if(preg_match("/$match/i", $row[2])){
							echo "エラー内容 ： ".$row[2]."<br />";
							echo "解決方法 ： ".$row[3]."<br>";
							echo "<hr>";
							$error_flg = 1;
						}
					}
				}

				// preg_matchに引っかからなかったとき
				if($error_flg == 0){
					echo "エラー内容がありませんでした。";
				}
				// preg_matchに引っかかったとき
				else{
					echo "検索結果は以上です。";
				}
			}
		}
		// ソート機能 OFF
		else{
			// エラー内容入力の使うスペースが全角か半角で分ける とりあえずは全角のスペースを入力している体でいく
			$lang_sol_explode = explode(" ", $error_sol);
			if(isset($lang_sol)){
				$sql = $pdo -> query("SELECT * FROM error_table_v2 WHERE lang='$lang_sol'");
				$res = $sql -> fetchAll();
			}
			else{
				echo "入力が不正です";
				$error_flg = 1;
			}
			if(empty($res)){
				echo "検索結果がヒットしませんでした";
				// ここで検索結果を入力させるのおもろいかも
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
	}
?>
 <!-- 
// error_sol エラー番号とその内容 何行目っていうところはなくす
// explode ( string $delimiter , string $string [, int $limit = PHP_INT_MAX ] ) : array

// Parse error: syntax error, unexpected 'if' (T_IF) in /public_html/SearchError_io.php on line 21
// 20行目に(;)がなかった

// Parse error: syntax error, unexpected '；' (T_STRING), expecting ',' or ';' in /public_html/SearchError_io.php on line 30
// 30行目で全角の；がはいっていたので半角の;に直した

// Parse error: syntax error, unexpected end of file, expecting elseif (T_ELSEIF) or else (T_ELSE) or endif (T_ENDIF) in /public_html/SearchError_io.php on line 102
// どっかでカッコが抜けている。必ずしも102ではない
// が2箇所に存在していたことによるエラー
// preg_matchらへんと正規表現の理解必要
// エラー表示をコピー、そのエラーの2個目までerrorまでの文字列を正規表現で表示
// preg_matchの第一引数に正規表現持ってくる。第二引数にDBのErrorをあてて正規表現にあったやつを出力するようにしたい。
// Preg_matChの第三引数が重要になってくると思われ。第三引数の配列の中に正規表現に当たったやつが格納されるのでは？？
// 1・31エラーの内容をコピペするのは今後の課題にしよう
// とりあえずは選択された言語のエラー内容が出てくるようにしよう
//  -->
<!-- preg系を使えるのはutf-8だけらしいｗ 
explodeの空白はheader charset="UTF-8"に変えたらできた
-->


<!DOCTYPE html>
<html>
<head>
	<title>SearchError</title>
</head>
<body>
	<?php if ($error_flg == 0): ?>
		<h2>備忘録サイト 検索フォーム</h2>
	<h3>言語と検索内容を入力する</h3>
	<form action="SearchError_io_v2.php" method="post">
		<p>言語
			<select name="lang_sol">
				<option value="python">python</option>
				<option value="php">php</option>
				<option value="mysql">mysql</option>
				<option value="else">その他</option>
			</select>
		</p>
		<p>検索内容<input type="text" name="error_sol"></p>
		<p>ソート機能
		<select name="on_off" >
			<option value="on">ON</option>
			<option value="off">OFF</option>
		</select>
		</p>
		<input type="submit" name="">
	</form>
	<?php endif; ?>
</body>
</html>
