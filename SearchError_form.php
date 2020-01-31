<!DOCTYPE html>
<html>
<head>
	<title>SearchError</title>
</head>
<body>
	<h2>Welcome To SearchError Communication</h2>
	<form action="SearchError_DB_res.php" method="POST">
		<p>言語を選んでください
			<select name="lang">
				<option value="python">python</option>
				<option value="php">php</option>
				<option value="mysql">その他</option>
			</select>
		</p>
		<p>エラー表示をコピペしてきてください<input type="text" size="50" name="error"></p>
		<p>解決方法を入力してください<input type="text" size="50" name="sol"></p>
		<input type="submit" name="">
	</form>
</body>
</html>
