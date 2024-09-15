					if(isset($_POST['exhonerer_tva']) || isset($_POST['exhonerer_aib']) || (isset($_POST['exhonerer_tva']) && isset($_POST['exhonerer_aib'])))
						{
							if($_POST['remise']>0)
								$edit5=$_POST['remise']+$_POST['edit3T']-$_POST['Ttotal']; 
							else 
								$edit5=$_POST['edit3T']-$_POST['Ttotal'];
							
							$_SESSION['exhonerer_aib']=$_POST['exhonerer_aib'];$_SESSION['exhonerer_tva']=$_POST['exhonerer_tva'];
						}
					else{
							if($_POST['remise']>0)
								$edit5=$_POST['remise']+$_POST['edit5']-$_POST['Ttotal']; 
							else 
								$edit5=$_POST['edit5']-$_POST['Ttotal'];
						}



						
<html>  
	<head> 
		<title> SYGHOC </title>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>	
		<script type="text/javascript">
		function action2(){
			if(document.getElementById(nbCheck).checked == true){
		 if (document.getElementById("edit26").value!='') {
						document.getElementById('edit26').value =document.getElementById("edit26").value- 5;	
				}

		}

		
		</script>
	</head> 
	<body bgcolor='azure' style="margin-top:-20px;padding-top:0px;"><br/>
	<div align="" style="margin-top:0%;">
		<table align='center' width="800">

				<tr>
					<td><br/> Montant TTC: </td>
					<td><br/> <input type='text' name='edit26' id='edit26' readonly <?php   echo "value='200'"; ?> onchange='FconnexeT();' /> </td>

				</tr>
			
				<tr>
					<td colspan='4' align='left'> <br/>
					<input  type='checkbox' name='exhonerer'
					id='exhonerer'<?php if(!empty($numfiche_1)) echo "checked='checked'";?> onclick='action2();' value='1'/>
					<span style='font-size:0.8em;font-style:italic;'>Exhonérer de la TVA</span> &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
					</td>
				</tr>
	
		</table>	
	</div>		
	</body>
	
</html>
