<?php
//include 'menu.php';
	require("config.php");
		// automatisation du numéro
		$numfiche = !empty($_GET['numfiche'])?$_GET['numfiche']:NULL;
		$reqsel=mysqli_query($con,"SELECT max(numero) AS numero FROM typechambre");
		while($data=mysqli_fetch_array($reqsel))
			{  $numero=$data['numero']+1;
			}
			if(($numero>=0)&&($numero<=9))	 $numero="0000".$numero ;
			if(($numero>=10)&&($numero <=99))	 $numero="000".$numero ;
			if($numero>100)	 $numero="".$numero ;
	
			 $id1=1;
		if (isset($_POST['Envoyer']) and $_POST['Envoyer']=="Ajouter")
			{if(!empty($_POST['typeC']) )
					{ $pre_sql1="INSERT INTO typechambre VALUES(NULL,'".ucfirst($_POST['typeC'])."')";
					$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));	
					$submit=TRUE;
					}
			}
?>

<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="css/bootstrap.min.js"></script>
<script src="css/jquery-1.11.1.min.js"></script>
<link href="css/customize.css" rel="stylesheet">
<script type="text/javascript">

 window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
		window.close();
    }

</script>
<style>
.bouton5 {
	border-radius:12px 0 12px 0;
	background: #d34836;
	border:none;
	color:#fff;
	font:bold 12px Verdana;
	padding:6px ;font-family:cambria;font-size:1em;
}
.bouton5:hover{
    cursor:pointer;background-color: #000000;
}
.bouton13 {
	border:none;
	padding:6px 0 6px 0;
	border-radius:8px;
	background:#d34836;
	font:bold 13px Arial;
	color:#fff;
}
</style>
<!------ Include the above in your HEAD tag ---------->
<div class="container" style='background-color:#84CECC;'>
	<div class="row">
		
        <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3" style='margin-top:-1px;'>
           		<form method="post" action="Tchambre.php" onSubmit="refreshParent()">
				<table align='center' style='margin-top:2%'>
				<?php	
				   echo "								
							<tr>
								<td>
									<fieldset> 
										<legend align='center' style='color:#2F574D;'><b> Enrégistrer un type de Chambre</b></legend> 
										<table style='font-size:1.1em;'> 
											<tr> 
												<td style='font-size:1.2em;'>  Numéro : </td><input type='hidden' name='numero' value='' /><input type='hidden' name='' id=''  />
												<td style='font-size:1.2em;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='edit1' id='edit1'  value='".$numero."'  readonly /> </td>		
											</tr> 
											<tr> 
												<td style='font-size:1.2em;'> Type de chambre : </td>
												<td style='font-size:1.2em;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' style='' name='typeC' id='edit2'  value='' required='required' /> </td>
											</tr>
					
										</table> 
									</fieldset> 
								</td>
							</tr> <br/> ";

				?>	
				</table>
			<div align='center'><br/> <input class='bouton5' type="submit" name="Envoyer" value="Ajouter" style=''/>
			</div>
			</form>
         </div>
			
        </div>    
</div>
