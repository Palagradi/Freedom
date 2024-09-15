<?php
//include 'menu.php';
	require("config.php");
		// automatisation du numéro
		$numfiche = !empty($_GET['numfiche'])?$_GET['numfiche']:NULL;
/* 		$reqsel=mysqli_query($con,"SELECT max(numero) AS numero FROM tarifChambres");
		while($data=mysqli_fetch_array($reqsel))
			{  $numero=$data['numero']+1;
			}
			if(($numero>=0)&&($numero<=9))	 $numero="0000".$numero ;
			if(($numero>=10)&&($numero <=99))	 $numero="000".$numero ;
			if($numero>100)	 $numero="".$numero ; */
	
			 $id1=1;
		if (isset($_POST['Envoyer']) and $_POST['Envoyer']=="Ajouter")
			{if(!empty($_POST['RaisonSociale']) )
					{ echo $pre_sql1="INSERT INTO fournisseurs VALUES(NULL,'".ucfirst($_POST['RaisonSociale'])."','".$_POST['adresse']."','".$_POST['telephone']."','".$_POST['email']."')";
					$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));	
					 $_SESSION['fournisseur']=$_POST['RaisonSociale'];
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
           		<form method="post" action="fournisseurs.php">
				<table align='center' style='margin-top:2%'>
				<?php	
				   echo "								
							<tr>
								<td>
									<fieldset> 
										<legend align='center' style='color:#2F574D;'><b> Informations sur le Fournisseur </b></legend> 
										<span style='color:#573E39;'>   </span>
										<table style='font-size:1.1em;'> 
											<tr> 
												<td style='font-size:1.1em;'> Raison Sociale :  </td>
												<td style='font-size:1.1em;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' style='' name='RaisonSociale' id=''  value='' required='required' /> </td>
											</tr>
											<tr> 
												<td style='font-size:1.1em;'> Adresse :  </td>
												<td style='font-size:1.1em;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' style='' name='adresse' id='' /> </td>
											</tr>
											<tr> 
												<td style='font-size:1.1em;'> N° de Téléphone :  </td>
												<td style='font-size:1.1em;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='tel' style='' name='telephone' id=''  value='' required='required'  onkeypress='testChiffres(event);'/> </td>
											</tr>
											<tr> 
												<td style='font-size:1.1em;'> Email :  </td>
												<td style='font-size:1.1em;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='email'  name='email' style=''  /> </td>
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
