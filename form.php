<?php include_once('countries.php') ?> 

<!DOCTYPE html>
<html>
<head>
	<script src="jquery-3.6.0.min.js"></script>
	<script src="form.js"></script>
	<title>Countries</title>
</head>
<body>
<form>
<p>Podaj imię: <input id="name" type="text"></p>
<p>Wybierz kraj: <select id="country"><?php printCountries2Select() ?></select></p>
<p><button id="submit">Zatwierdź</button></p>
<p id="result" style="color: red;"></p>
</form>
</body>
</html>