<html lang="zh_CN">
<head>
	<title>Pictures Administration - Trove Convert</title>
	<link rel="shortcut icon" type="image/x-icon" href="./img/favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div id="wrapper container">
		<div id="aside" class="col-xs-5 col-sm-3">
			<p id="title">Trove Convert</p>
			<div class="divide"></div>
			<button id="download" class="btn btn-default" style="background-color: rgba(0, 0, 0, 0); color: #ffffff;" type="submit" onclick="download()">Download Selected Pictures</button>
			<button id="goto" class="btn btn-default" style="background-color: rgba(0, 0, 0, 0); color: #ffffff;" type="submit" onclick="location.href='request?page=1'">Goto Requests Administration</button>
			<div style="float: center; margin: 30px 0">
				<button class="btn btn-default" style="background-color: rgba(0, 0, 0, 0); color: #ffffff;" type="submit" onclick="window.location.href='?page={{$page - 1}}'">prev</button>
				<p style="display: inline; margin: 0 10px; color: white;">{{$page}}</p>
				<button class="btn btn-default" style="background-color: rgba(0, 0, 0, 0); color: #ffffff; display:inline;" type="submit"  onclick="window.location.href='?page={{$page + 1}}'">next</button>
			</div>
			<p id="copyright">Copyright © Crimson Work. All rights reserved.</p>
		</div>
		<div id="main" class="col-xs-7 col-sm-9">
			<div class="row">
				<div id="pic-div">
					@for($i = 1; $i < $piccount + 1; $i++)
					<div class="pic-frame col-xs-2" onclick="pic_click('pic-{{ $i }}');">
						<div id="pic-{{ $i }}" class="pic-container" style="background-image:url(./minpic?id={{ $picdata[$i - 1]['id'] }});">
							<input id={{ $picdata[$i - 1]['id'] }} class="pic-check" type="checkbox" style="margin: 8px auto auto 8px;"></input>
							<div class="pic-info-box">
								<p class="pic-info">{{ $picdata[$i - 1]['info'] }}</p>
							</div>
						</div>
					</div>
					@endfor
				</div>
			</div>
		</div>
	</div>
	
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/picadmin.css">
	<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script src="./js/picadmin.js">
	</script>
</body>
</html>