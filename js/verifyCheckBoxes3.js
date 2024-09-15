
function verifyCheckBoxes4()
	{
		if((document.getElementById("button_checkbox1").checked) )
		{
			document.getElementById("button_checkbox4").checked = false;
		}
	}
function verifyCheckBoxes5()
	{
		if((document.getElementById("button_checkbox4").checked) )
		{
			document.getElementById("button_checkbox1").checked = false;
		}
	}