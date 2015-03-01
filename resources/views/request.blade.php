<html lang="zh_CN">
<head>
	<title>Requests Administration - Trove Convert</title>
	<link rel="shortcut icon" type="image/x-icon" href="./img/favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div id="zbp-container">
		<p id="zbp">You smiled and talked to me of nothing and I felt that for this I had been waiting long. </p>
	<button id="goto" class="btn btn-default" style="border: solid 2px; background-color: rgba(0, 0, 0, 0); color: #ffffff;" type="submit" onclick="location.href='picadmin?page=1'">Go to picture admin</button>
	</div>
	<div id="data-table">
		<table class="tb table">
			<thead><tr>
				<th>Id</th>
				<th>Pid</th>
				<th>Time</th>
				<th>State</th>
				<th>Operation</th>
			</tr></thead>
			@for($i = 1; $i < count($data) + 1; $i++)
			<tr>
				<td style="line-height:32px;">{{$data[$i-1]['id']}}</td>
				<td style="line-height:32px;">{{$data[$i-1]['pid']}}</td>
				<td style="line-height:32px;">{{$data[$i-1]['time']}}</td>
				<td style="line-height:32px;">{{$data[$i-1]['state']}}</td>
				<td style="line-height:32px;"><button class="btn btn-default" style="background-color: rgba(0, 0, 0, 0); width: 70px; color: #ffffff;@if($data[$i-1]['state'] != 'wait') visibility: collapse;@endif" type="submit" onclick="window.location.href='requestdel?stop={{$data[$i-1]['id']}}'">stop</button></td>
			</tr>
			@endfor
		</table>
		<div style="float: right; margin-right: 30px; margin-bottom: 10px">
			<button class="btn btn-default" style="background-color: rgba(0, 0, 0, 0); color: #ffffff;" type="submit" onclick="window.location.href='?page={{$page - 1}}'">prev</button>
			<p style="display: inline; margin: 0 10px; color: white;">{{$page}}</p>
			<button class="btn btn-default" style="background-color: rgba(0, 0, 0, 0); color: #ffffff; display:inline;" type="submit" onclick="window.location.href='?page={{$page + 1}}'">next</button>
		</div>
	</div>
	<p id="copyright">Copyright © Crimson Work. All rights reserved.</p>
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/request.css">
	<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</body>
</html>