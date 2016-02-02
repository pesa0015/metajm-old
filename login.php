<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>Logga in</h1>
	<form action="mobile_api/post/auth" method="post">
		<p>Salong:</p>
		<input type="text" name="company">
		<p>Lösenord:</p>
		<input type="password" name="password">
		<input type="submit" name="Logga in">
	</form>
</body>
</html>