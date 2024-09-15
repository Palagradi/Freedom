<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My page</title>

    <!-- CSS dependencies -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>

    <p>Content here. <a class="show-alert" href=#>Alert!</a></p>

    <!-- JS dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Bootstrap 4 dependency -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- bootbox code -->
    <script src="js/bootbox/bootbox.min.js"></script>
    <script src="js/bootbox/bootbox.locales.min.js"></script>
    <script>
        $(document).on("click", ".show-alert", function(e) {
			
		bootbox.prompt({
		title: "This is a prompt with select!",
		inputType: 'select',
		inputOptions: [
		{
			text: 'Choose one...',
			value: '',
		},
		{
			text: 'Choice One',
			value: '1',
		},
		{
			text: 'Choice Two',
			value: '2',
		},
		{
			text: 'Choice Three',
			value: '3',
		}
		],
		callback: function (result) {
			//console.log(result);
			//alert(result);
			document.getElementById('modeP').value=result;
		}
	});
			
			
        });
    </script>
	
	<input type='text' name='modeP' id='modeP' value='' readonly />
</body>
</html>