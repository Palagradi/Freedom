
function verifyCheckBoxes4()
	{
		if((document.getElementById("button_checkbox4").checked) )
		{
			document.getElementById("button_checkbox5").checked = false;
		}
	}
function verifyCheckBoxes5()
	{
		if((document.getElementById("button_checkbox5").checked) )
		{
			document.getElementById("button_checkbox4").checked = false;
		}
	}