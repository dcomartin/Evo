<html>
<head>
	<title></title>	
</head>
<body>

	Hello <?PHP echo $name; ?>, it's currently <span id="txtDate"><?PHP echo date('Y-m-d H:i:s'); ?></span>

	<input type="button" value="Update Date & Time" id="btnGetDate">
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$('#btnGetDate').click(function() {
			$.get("<?PHP echo Uri::view('getDate');?>", function( data ) {
				var obj = jQuery.parseJSON(data);
				$('#txtDate').text(obj);
			});
		});
	});
	</script>
</body>
</html>