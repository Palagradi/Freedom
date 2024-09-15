<?php
	require("config.php");
		// automatisation du numéro
		//$numfiche = !empty($_GET['numfiche'])?$_GET['numfiche']:NULL;		
	$tableS=(int)$_SESSION['tableS'];			

	if (isset($_POST['Envoyer']) and $_POST['Envoyer']=="Affecter")
			{if(!empty($_POST['edit3']) )
					{   $pre_sql1="UPDATE tableencours SET Serveurassoc ='".$_POST['edit3']."' WHERE numTable='".$tableS."' AND Etat <> 'Desactive' ";
						$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));	
						$submit=TRUE;
					}
			}

?>

<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="css/bootstrap.min.js"></script>
<script src="css/jquery-1.11.1.min.js"></script>
<link href="css/customize.css" rel="stylesheet">
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
<script type="text/javascript">

 window.onunload = refreshParent;
    function refreshParent() {
		window.close();
		window.opener.location.reload();
    }

</script>
<!------ Include the above in your HEAD tag ---------->
<div class="container" style='background-color:#84CECC;'>
	<div class="row">
		
        <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3" style='margin-top:-1px;'>
           		<form method="post" action="tableS.php" >
		<table align='center' style='margin-top:2%'>
		 <?php
					   echo "
								<tr>
									<td>
										<fieldset>
											<legend align='center' style='color:#2F574D;'><b>  Affectation d'un serveur à une table</b></legend>
											<table style=''>
								
													<td style='font-size:1.2em;'> Serveur associé : </td>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<select name='edit3' style='width:125px;'>";
														 echo "<option value=''>";  echo" </option>";
														$req = mysqli_query($con,"SELECT * FROM serveur") or die (mysqli_error($con));	
														while($data=mysqli_fetch_array($req))
														{    
															echo" <option value ='".$data['nomserv']."'> ".ucfirst($data['nomserv'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
														}

													echo "</select>
													</td>
												</tr>
											</table>
										</fieldset>
									</td>
								</tr> <br/> ";

				    ?>
				</table>
				<div align='center'><br/> <input class='bouton5' type="submit" name='Envoyer' value="Affecter" style=''/>
				</div>
			</form>
         </div>
			
        </div>    
</div>
