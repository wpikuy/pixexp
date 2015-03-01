<html lang="zh_CN">
<head>
	<title>Entrance - Trove Convert</title>
	<link rel="shortcut icon" type="image/x-icon" href="./img/favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div id="wrapper" class="cover-container test1">
	<h1 class="title">Trove Convert</h1>
		<div class="unlock-button center button" type="submit" value="Submit" onclick="login();"></div>
		<input id="password" type="password" class="form-control center passinput" aria-label="Amount (to the nearest dollar)"
			maxlength="16"/>
		<input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
		<p id="request"></p>
	</div>
	<p id="copyright">Copyright © Crimson Work. All rights reserved.</p>
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/entrance.css">
	<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script src="./js/login.js"></script>
</body>
</html>