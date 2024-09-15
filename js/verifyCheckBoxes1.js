function verifyCheckBoxes1()
	{
		if((document.getElementById("button_checkbox_1").checked) )
		{
			document.getElementById("button_checkbox_2").checked = false;
			document.getElementById("button_checkbox_3").checked = false;
		}
	}
function verifyCheckBoxes2()
	{
		if((document.getElementById("button_checkbox_2").checked) )
		{
			document.getElementById("button_checkbox_1").checked = false;
			document.getElementById("button_checkbox_3").checked = false;
		}
	}
function verifyCheckBoxes3()
	{
		if((document.getElementById("button_checkbox_3").checked) )
		{
			document.getElementById("button_checkbox_1").checked = false;
			document.getElementById("button_checkbox_2").checked = false;  
		}
	}
