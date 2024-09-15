<?php
	require("config.php");
	$req = mysqli_query($con,"SELECT * FROM QteBoisson ORDER BY qte") or die (mysqli_error($con));	
	$nbreX=mysqli_num_rows($req);$nbreX++;
	if(($nbreX>=0)&&($nbreX<=9)) $nbreX="QT000".$nbreX ; else if(($nbreX>=10)&&($nbreX <=99)) $nbreX="QT00".$nbreX ;else $nbreX="QT".$nbreX ;
	
if(isset($_POST['Envoyer'])&& ($_POST['Envoyer']=="Envoyer")){
		$Qte=ucfirst($_POST['edit2']);
		echo $req="INSERT INTO QteBoisson SET qte='".$Qte."'";
		$query = mysqli_query($con,$req) or die (mysqli_error($con));
}
?>

<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="css/bootstrap.min.js"></script>
<script src="css/jquery-1.11.1.min.js"></script>
<link href="css/customize.css" rel="stylesheet">
<script type="text/javascript">

 window.onunload = refreshParent;
    function refreshParent() {
       	window.close();
		 window.opener.location.reload();
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
           		<form method="post" action="QuantBois.php">
		<table align='center' style='margin-top:2%'>
		 <?php
				   echo "
								<tr>
									<td>
										<fieldset>
											<legend align='center' style='color:#2F574D;'><b>  Enrégistrement d'une Quantité</b></legend>
											<table style=''>
												<tr>
													<td style='font-size:1.2em;'> Code Quantité : </td>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='edit1' id='edit1'   required='required' value='".$nbreX."'/> </td>
												</tr>
												<tr>
													<td style='font-size:1.2em;'> Quantité indiquée : </td>
													<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' style='' name='edit2' id='edit2'  value=''  required='required'/> </td>
												</tr>
											</table>
										</fieldset>
									</td>
								</tr> <br/> ";
								//}
					   //}
				 //}
				    ?>
				</table>
				<div align='center'><br/> <input class='bouton5' type="submit" value="Envoyer" name='Envoyer' style=''/>
				</div>
			</form>
         </div>
			
        </div>    
</div>
