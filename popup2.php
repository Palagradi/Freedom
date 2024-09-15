<?php
	require("config.php");
		// automatisation du numéro
		$numfiche = !empty($_GET['numfiche'])?$_GET['numfiche']:NULL;

		$Numclt = !empty($_GET['Numclt'])?$_GET['Numclt']:NULL;  $sal = !empty($_GET['sal'])?$_GET['sal']:NULL;

		if(isset($_POST['Valider']) && $_POST['Valider'] == "Valider")
			{ 		$code_reel=$_POST['groupe'];$numfiche=$_POST['numfiche'];
					$sql="SELECT codegrpe FROM groupe WHERE code_reel LIKE '".$code_reel."'";
					$req = mysqli_query($con,$sql) or die (mysqli_error($con));
					if(mysqli_num_rows($req)>0){
						$dataT=mysqli_fetch_object($req);
						$codegrpe= $dataT->codegrpe;
						if($_POST['Vente']==0){
							
						if(isset($_POST['sal'])&&($_POST['sal']==1)) $table="location"; else $table="fiche1";
						$sql="SELECT MAX(Periode) AS Periode FROM ".$table." WHERE numfichegrpe='".$_POST['groupe']."' AND etatsortie='NON'";
						$Query1=mysqli_query($con,$sql);
						if (!$Query1) {
							printf("Error: %s\n", mysqli_error($con));
							exit();
						}
						$data1=mysqli_fetch_object($Query1); 
						if(isset($data1->Periode)&&($data1->Periode>0))
						 $periode=$data1->Periode;		 //Là on n'incrémente pas. Les clients sont entrées ensemble.
						else 
						{
						$sql2="SELECT MAX(Periode) AS Periode FROM ".$table." WHERE numfichegrpe='".$_POST['groupe']."'";
						$Query1=mysqli_query($con,$sql2);
						$data1=mysqli_fetch_object($Query1); $data1->Periode; 
						$periode=isset($data1->Periode)?(1+$data1->Periode):1;
						} 
						//echo $periode;
			
						$pre_sql1="UPDATE mensuel_fiche1 SET Periode='".$periode."',codegrpe = '".$codegrpe."',numfichegrpe = '".$_POST['groupe']."' WHERE numfiche LIKE '".$numfiche."' ";
						if($_POST['sal']!=1)
							$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
						$pre_sql1="UPDATE ".$table." SET Periode='".$periode."',codegrpe = '".$codegrpe."',numfichegrpe = '".$_POST['groupe']."' WHERE numfiche LIKE '".$numfiche."' ";
						$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
						}else {
						$pre_sql1="UPDATE compte2 SET groupe = '".$codegrpe."' WHERE numfiche LIKE '".$numfiche."' ";
						$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
						}
						echo "<script language='javascript'>";
						echo 'alert(" Enrégistrement effectué avec succès");';
						echo 'window.opener.location.reload();';
						echo 'window.close();';
						echo "</script>";
					}
			}
			
		$s=mysqli_query($con,"SELECT id FROM categoriefconnexe ");
		$i=0;$totalRows_Recordset=mysqli_num_rows($s);
		while($ret1=mysqli_fetch_array($s))
		 {	$id[$i]=$ret1['id'];$i++;

		 }

$submit=!empty($submit)?$submit:NULL;

$idr  = isset($_POST['groupe'])?$_POST['groupe']:NULL;  
$idr  = isset($_GET['idr'])?$_GET['idr']:$idr;  
$_SESSION['idr'] = $idr;

if(isset($idr))
{	$sql="SELECT * FROM groupe WHERE code_reel LIKE '".$idr."'";
	$req = mysqli_query($con,$sql) or die (mysqli_error($con));
	$dataT=mysqli_fetch_object($req);  //echo $dataT->Libcategorie;
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"

	<head>
		<title><?php echo $title; ?></title>
		<link rel="icon" href="<?php $icon="logo/link.png"; echo $icon; ?>" />
<script type="text/javascript">

		window.addEventListener('beforeunload', function (e) {
			window.opener.location.reload();
			window.close();
		});
</script>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="css/bootstrap.min.js"></script>
		<script src="css/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/ajax.js"></script>
		<script type="text/javascript" src="js/ajax-dynamic-list3.js"></script>
		<link href="css/customize.css" rel="stylesheet">
		<link rel="Stylesheet" href='css/table.css' />
		<style>

					/* Big box with list of options */
			#ajax_listOfOptions
			{
				position:absolute;	/* Never change this one */
				width:250px;	/* Width of box */
				height:100px;	/* Height of box */
				overflow:auto;	/* Scrolling features */
				border:1px solid #317082;	/* Dark green border */
				background-color:#FFF;	/* White background color */
				text-align:left;
				font-size:1.1em;
				z-index:100;
			}
			#ajax_listOfOptions div
			{	/* General rule for both .optionDiv and .optionDivSelected */
				margin:1px;
				padding:1px;
				cursor:pointer;
				font-size:0.9em;
			}
			#ajax_listOfOptions .optionDiv
			{	/* Div for each item in list */

			}
			#ajax_listOfOptions .optionDivSelected
			{ /* Selected item in the list */
				background-color:#317082;
				color:#FFF;
			}
			/*#ajax_listOfOptions_iframe
			{
				background-color:#F00;
				position:absolute;
				z-index:5;
			}*/

			form
			{
				display:inline;
			}
			input, select
			{
				/*border:1px solid; */
			}

			.bouton:hover
			{
				cursor:pointer;
			}

			.alertify-log-custom {
				background: blue;
			}


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
		function Aff55()
		{
			if ((document.getElementById("edit2").value!=''))
			{	document.getElementById("edit3").value=document.getElementById('edit2').value*document.getElementById('MontantUnites').value;
			}
		}
		function Aff54()
		{
			//if ((document.getElementById("edit3").value!='')&&(document.getElementById("MontantUnites").value!=0))
			{	//document.getElementById("edit3").value=52;
			}

				//function action6(event)  //A commenter pour avoir la réponse
				{
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit3').value = leselect;
						//document.getElementById("edit3").value=52;
					}
				}
				xhr.open("POST","others/prixP.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sh1 = document.getElementById('edit1').value;
				//sh1 = 1;
				//sh = sel.options[sel.selectedIndex].value;
				sh2= document.getElementById('edit2').value;
				//sh2=document.getElementById('edit2').options[document.getElementById('edit2').selectedIndex].value
				xhr.send("categorie="+sh1+"&designation="+sh2);
			}
		}

		var momoElement1 = document.getElementById("edit2");
		if(momoElement1.addEventListener){
		  momoElement1.addEventListener("onblur", action6, false);
		}else if(momoElement1.attachEvent){
		  momoElement1.attachEvent("onblur", action6);
		}

				//fonction standard
		function getXhr(){
			xhr=null;
				if(window.XMLHttpRequest){
					xhr=new XMLHttpRequest();
				}
				else if(window.ActiveXObject){
					try {
			                xhr = new ActiveXObject("Msxml2.XMLHTTP");
			            } catch (e) {
			                xhr = new ActiveXObject("Microsoft.XMLHTTP");
			            }
				}
				else{
					alert("votre navigateur ne suporte pas les objets XMLHttpRequest");
				}
				return xhr;
			}
		</script>
	</head>

	<div class="container" style='background-color:#84CECC;'>
	<div class="row"> <?php ?>
    <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3" style='margin-top:-1px;'>
			<?php
			 if(!isset($_GET['list'])) {										
			?>
		<form method="post" action="popup2.php<?php if(isset($_GET['numfiche'])) echo "?numfiche=".$_GET['numfiche']."&client=".$_GET['client']; if(isset($_GET['Vente'])) echo "&Vente=".$_GET['Vente']; if(isset($_GET['sal'])) echo "&sal=".$_GET['sal']; echo '"';//onSubmit="refreshParent()" ?> id="chgdept">
		<?php
		
		?>
		<input type='hidden' style='width:250px;font-size:1.3em;' name='Vente'  placeholder='' <?php  if(isset($_GET['Vente'])) echo "value='".$_GET['Vente']."'";?> />
		
		<table align='center' style='margin-top:-4px;' border='1' width='550'>
		
		<input type='hidden' name='sal' <?php if(isset($sal)) echo "value='".$sal."'"; ?>  />
		 <?php
			if($totalRows_Recordset==0) echo "<center> Aucun frais connexe n'a été défini. Contacter l'administrateur</center>";
			
					   echo "	<tr>
									<td>
										<fieldset>
											<legend align='center' style='color:#2F574D;'>
											<b>";
											echo "RECONVERSION EN ";											
											if(isset($sal)&&($sal==1)) echo "LOCATION GROUPEE"; else echo "HEBERGEMENT GROUPE";										
											echo "</b></legend>
											<table style='font-size:1.1em;'>";
												echo "<tr>
													<td style='font-size:1.2em;'> N° Fiche  : </td>
													<input type='hidden' name='numfiche'";	echo " />
													<input type='hidden' name='MontantUnites' id='MontantUnites' value='' />
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?>
												<input type='text' <?php //if(isset($_GET['numfiche'])) echo "placeholder=''"; else echo "placeholder='Identifiant du produit'";?> id='edit2' style='width:250px;font-size:1.3em;' name='numfiche'  <?php if(isset($_GET['numfiche'])) echo "value='".$_GET['numfiche']."'"; ?> readonly />
												<?php
												echo "</td>
												</tr>
												<tr>
													<td style='font-size:1.2em;'> Nom du Client : </td>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' style='width:250px;font-size:1.3em;' name='client' required id='edit3'"; if(isset($_GET['client'])) echo "value='".$_GET['client']."'";  echo "readonly  /> </td>
												</tr>";
												echo "<tr>
													<td style='font-size:1.2em;'> Nom du groupe : </td>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ?>
													<select id='edit1' name='groupe' required='required'  style='width:250px;font-size:1.3em;' <?php if(!isset($_GET['id'])&&(!isset($_GET['new'])))  { ?>onchange="document.forms['chgdept'].submit();" <?php } ?> >
													<?php
													if(isset($dataT->codegrpe))
														echo "<option value='".$idr."'>".$dataT->codegrpe."</option>";
													else
														echo "<option value=''></option>";?>
													<?php
														$req = mysqli_query($con,"SELECT * FROM groupe") or die (mysqli_error($con));
													while($data=mysqli_fetch_array($req))
													{    //$t++; if($t==1)
														echo "<option value=''> </option>";
														if(isset($data['code_reel'])) echo "<option value='".$data['code_reel']."'>".$data['codegrpe']."</option>";
													}
													echo "</select></td>
												</tr>";
											echo "
											</table>
										</fieldset>
									</td>
								</tr> <br/> ";
							//	}
					   //}
				 //}
				    ?>
				</table>
				<div align='center'><br/>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input class='bouton5' type="submit" name="Valider" <?php if(isset($_GET['modif'])) echo 'value="MODIFIER"'; else if(isset($_GET['supp'])) { echo 'value="SUPPRIMER"';   echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"';}   else echo 'value="Valider"';   ?> style='font-size:1.2em;'/>
				</div><br/>
			<a class='' href='popup2.php?delete=1  <?php if(isset($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche']; if(isset($_GET['codegrpe'])) echo "&codegrpe=".$_GET['codegrpe']; ?>' title='TOUT REINITIALISER' style='color:red;text-decoration:none;font-weight:bold;'>

			<?php

			?>

			</form>
         </div>
				 <?php
			 } else {

				?>

				 <?php
			 		}
				 ?>
      </div>
	</div>
	</body>
</html>
<?php
			//include ("footer.inc.php");
?>
