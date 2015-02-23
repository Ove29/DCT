<?php
	$content = 'content/index.php';
	$content_dir = 'content/';
	$time_start = microtime(true);
	
	if(isset($_GET["group"])) {
		$group = $_GET["group"];
		if(strlen($group) !=0) {
			switch($group) {
				case 'gw':
					$contentg = 'gw';
					break;
				case 'dp-meter':
					$contentg = 'dp-meter';
					break;
				case 'output':
					$contentg = 'output';
					break;
				case 'customer':
					$contentg = 'customer';
					break;
				case 'account':
					$contentg = 'account';
					break;
				default:
					$conteng = '';
					break;
			}
		}
		$content = $content_dir . $contentg;
	}else {
		$content = '';
	}

	if (isset($_GET["site"])){
		$site = $_GET["site"];
		if (strlen($site) != 0){
			switch ($site) {
				case 'add':
					$contents = '-add';
					break;
				case 'edit':
					$contents = '-edit';
					break;
				case 'list':
					$contents = '-list';
					break;
				case 'info':
					$contents = 'content/info';
					break;
				default:
					$contents = 'content/index';
					break;
			}
	 	}
	 	$content=$content . $contents . '.php';
  	}else {
  		$content = 'content/index.php';
  	}
?>

<html>
 	<head>
		<meta charset="utf8">
  		<title> Energy-Tool</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<style type="text/css">
			body{padding-top:80px;}
		</style>
 	</head>
 	<body>
		<nav id="main" style="height: 60px;" class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div style="margin-top: 7px;" class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" rel="home" href="index.php">
						<img style="margin-top: -17px;" src="" class="img-responsive" alt=" logo"> 
						Energy-Tool
					</a>
				</div>
				<div class="collapse navbar-collapse" id="main">
					<ul class="nav navbar-nav">
						<li><a href="index.php">Index</a></li>
						<li class="dropdown">
							<a href="index.php?group=gw" class="dropdown-toggle" data-toggle="dropdown">Gateway<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="index.php?group=gw&site=list">List Gateways</a></li>
								<li><a href="index.php?group=gw&site=add">Add Gateway</a></li>
								<li><a href="index.php?group=gw&site=edit">Edit Gateway</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="index.php?group=dp_meter" class="dropdown-toggle" data-toggle="dropdown">DP-Meter<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="index.php?group=dp-meter&site=list">List DP-Meter</a></li>
								<li><a href="index.php?group=dp-meter&site=add">Add DP-Meter</a></li>
								<li><a href="index.php?group=dp-meter&site=edit">Edit DP-Meter</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="index.php?group=output" class="dropdown-toggle" data-toggle="dropdown">Output<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="index.php?group=output&site=list">List Outputs</a></li>
								<li><a href="index.php?group=output&site=edit">Edit Output</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="index.php?group=customer" class="dropdown-toggle" data-toggle="dropdown">Customer<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="index.php?group=customer&site=list">List Customer</a></li>
								<li><a href="index.php?group=customer&site=add">Add Customer</a></li>
								<li><a href="index.php?group=customer&site=edit">Edit Customer</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="index.php?group=account" class="dropdown-toggle" data-toggle="dropdown">Account<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="index.php?group=account&site=list">List Account</a></li>
								<li><a href="index.php?group=account&site=add">Add Customer</a></li>
								<li><a href="index.php?group=account&site=edit">Edit Customer</a></li>
							</ul>
						</li>
						<li><a href="index.php?site=info">Get phpinfo</a></li>
					</ul>
					<form class="navbar-form navbar-right" role="search">
        				<div class="form-group">
          				<input type="text" class="form-control" placeholder="Keyword">
        				</div>
        				<button type="submit" class="btn btn-default">Search</button>
      			</form>
				</div>
			</div>
		</nav>
		<div class="container">
			<div class="content">
				<?php include($content); ?>
			</div>
		</div>
		<script src="http://code.jquery.com/jquery.min.js"></script>
    	<script src="js/bootstrap.js"></script>
		<div id="footer">
			<div class="row">
				<div class="col-md-2 col-md-offset-1">
					<p class="muted credit">
						<span class="glyphicon glyphicon-copyright-mark"></span>
						2014-<?php echo date("Y")?>  usw.
					</p>
				</div>
				<div class="col-md-2 col-md-offset-1">Ver 0.0. by Jan Ove Steppat</div>
				<div class="col-md-1 col-md-offset-0">
					<?php 
						$time_end = microtime(true);
						$time = $time_end - $time_start;
						echo $time;
					?>
				</div>
				<div class="col-md-1 col-md-offset-3"><a href="#">Top<span class="glyphicon glyphicon-arrow-up"></span></a></div>
			</div>
		</div>
 	</body>
</html>