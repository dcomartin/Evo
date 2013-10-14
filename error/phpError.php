<html>
<head>
<title>Error</title>
<style type="text/css">

body {
background-color:	#fff;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#000;
}

#content  {
border:				#999 1px solid;
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

h1 {
font-weight:		bold;
font-size:			14px;
color:				#990000;
margin: 			0 0 4px 0;
}
</style>
</head>
<body>
	<div id="content">
		<h1>PHP Error</h1>
		<?php echo $errstr; ?> in <?php echo $errfile; ?> on line <?php echo $errline;?>
	</div>
</body>
</html>