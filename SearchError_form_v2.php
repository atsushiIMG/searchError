	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!DOCTYPE html>
<html>
<head>
	<title>SearchError</title>

</head>
<body>
	<div class="text-center bg-info text-muted py-5">
		<h2 class="font-weight-bold">Welcome To SearchError Communication</h2>
	<form action="SearchError_DB_res.php" method="POST">
		<div class="container">
			<div class="form-group px-4">
				<label>言語を選んでください</label>
				<select name="lang" class="form-control">
				<option value="python">python</option>
				<option value="php">php</option>
				<option value="mysql">その他</option>
			</select>
			</div>
			<div class="form-group">
				<label>エラー内容を入力してください</label>
			<input type="text" class="form-control" name="error">
			</div>
			<div class="form-group">
				<label>解決方法を入力してください</label>
			<input type="text" class="form-control" name="sol">
			</div>
		</div>
		<button type="submit" class="btn btn-primary">送信</button>
	</div>
	</form>
</body>
</html>
<!-- 
2019 31
2017 29
2015 27 
Traceback (most recent call last):
File "2-256_2.py", line 5, in <module>
IndexError: list assignment index out of range
 -->