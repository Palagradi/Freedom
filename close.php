<?php
	include_once'menu.php';

   	function create_my_pdf_data($num_facture) {
		//$petsJson = file_get_contents('ex.php');
		//$pets = json_decode($petsJson,true);
		//return $pets;
		ob_start();
		include_once('ex.php');
		//$content = ob_get_clean();
		return $pdf->Output('Facture', 'S');
	}

	require_once 'vendor/vendor/autoload.php'; require_once 'credential.php';
?>
<html>
	<head>
	<link rel="Stylesheet" type="text/css"  href='css/input2.css' />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<script type="text/javascript" src="js/date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript">

		</script>
		<style>
			.alertify-log-custom {
				background: blue;
			}
			.bouton2 {
				border-radius:12px 0 12px 0;
				background: white;
				border:2px solid #B1221C;
				color:#B1221C;
				font:bold 12px Verdana;
				height:auto;font-family:cambria;font-size:0.9em;
			}
			.bouton2:hover{color:white;
				cursor:pointer;background-color: #B1221C;border:2px solid #B1221C;
			}
			#bouton3:hover{
				cursor:pointer;background-color: #000000;color:white;font-weight:bold;
			}
		#info:hover{

		}
		</style>
	<body bgcolor='azure' style="">
	<div align="center" style="">
	<?php
		if(isset($_GET['num_facture']))
			{	echo "<iframe src='ex.php"; echo "?num_facture=".$_GET['num_facture']."' width='1000' height='800' style='margin-left:5%;'></iframe>";
			}
			else{
	?>
	<?php
 	if(isset($_POST['mailer']))
	{	//require_once 'vendor/vendor/autoload.php'; require_once 'credential.php';
		 $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
        ->setUsername(EMAIL)
        ->setPassword(PASSWORD)
        ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));  //https://bugsdb.com/_en/debug/093fcffa336b6d9fe5a9dabdc90d712f

		 //$transport = new Swift_SendmailTransport('C:\wamp64\sendmail\sendmail.exe -t');

		// Create the Mailer using your created Transport
		$mailer = new Swift_Mailer($transport);

		// Create the message
		$message = (new Swift_Message('Test depuis Swift_Mailer'))

	  // Give the message a subject
	 // ->setSubject('Test depuis Swift_Mailer')

	  // Set the From address with an associative array
	  ->setFrom([EMAIL => 'Entreprise '.$nomHotel])

	  // Set the To addresses with an associative array (setTo/setCc/setBcc)
	  ->setTo([EMAIL, 'akpovo@yopmail.com' => 'Palagradi'])

	  //->setTo(['akpovo@yopmail.com' => 'Palagradi'])

	  // Give it a body
	  ->setBody('Ceci est un Test pour envoyer un message depuis Swift_Mailer')

	  // And optionally an alternative body
	  //->addPart('<q>Here is the message itself</q>', 'text/html')

	  // Optionally add any attachments
	  //->attach(Swift_Attachment::fromPath('my-document.pdf'))
	  ;


		// Create your file contents in the normal way, but don't write them to disk
		$data = create_my_pdf_data('00318/20');

		$attachment = new Swift_Attachment($data, $Jour_actuelp.'_'.$Heure_actuelle.'_Point_Tresorerie.pdf', 'application/pdf');

		// Attach it to the message
		$message->attach($attachment);

		// Send the message

		//$result = $mailer->send($message);

		if (!$mailer->send($message)) {
		  //echo "Failures:";
		  //print_r($failures);
		  echo 'Erreur ';

		} else {
			echo 'email sent successfully';
		}
	}

 	if(isset($_POST['mailer']) AND !empty($_POST['email']))
	{
		$dest = "akpovo@yopmail.com";
		$sujet = "Email de test";
        $corps = "Salut ceci est un email de test envoyer par un script PHP";
		$headers = "From: akpovojeandedieu@gmail.com";
        if (mail($dest, $sujet, $corps, $headers)) {
			echo "Email envoyé avec succès à ".$dest." ...";
		}
		else {
			echo "Échec de l'envoi de l'email...";
		}
	}
	}


		// www.e3b.org  (pour les emails jetables
if(isset($_POST['enregistrer1']) AND !empty($_POST['enregistrer1']))
{
	 $ChiffreAf=$_POST['ChiffreAf']; $Chiffre=$_POST['Chiffre']; $FondD=!empty($_POST['FondD'])?$_POST['FondD']:0; $Tva=!empty($_POST['Tva'])?$_POST['Tva']:0;$Taxe=!empty($_POST['Taxe'])?$_POST['Taxe']:0;
	 if($ChiffreAf>=0){
		 $update="UPDATE cloturecaisse SET State='1',FondDeclare='".$FondD."',ChiffreAffaire='".$ChiffreAf."',ChiffreAffaireHT='".$Chiffre."',TVA='".$Tva."',TaxeDesejour='".$Taxe."',Heure='".$Heure_actuelle."' WHERE DateCloture= '".$Jour_actuelp."' AND utilisateur='".$_SESSION['login']."'";
		 $req1 = mysqli_query($con,$update) or die (mysqli_error($con));
	  $DateCloture=substr($Jour_actuelp,8,2).'-'.substr($Jour_actuelp,5,2).'-'.substr($Jour_actuelp,0,4);

		$details="<ul style='font-size:1.2em;'>";
		if($ChiffreAf>0) $details.="<li>Chiffre d'affaire TTC : <strong>".$ChiffreAf."".$devise."</strong></li>"; if($Tva>0) $details.=" <li style=''> TVA : <strong>".$Tva."".$devise."</strong></li>"; if($Taxe>0) $details.="<li style=''>Taxe de séjour :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>".$Taxe."".$devise."</strong></li>";
		$details.="</ul>";


		$Email= "akpovo@yopmail.com";
		//$Email.= ";bolsminter@gmail.com";
		//$nomHotel="HOTEL SESY";

		if(!empty($Email)&&(isset($req1))){
		   	$connected=is_connected();
			   if($connected=='true'){ //echo $Email;
			   	$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
							->setUsername(EMAIL)
							->setPassword(PASSWORD)
							->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));  //https://bugsdb.com/_en/debug/093fcffa336b6d9fe5a9dabdc90d712f
					$mailer = new Swift_Mailer($transport);
					$Email="akpovo@yopmail.com"; 
					// Create the message
					$message = (new Swift_Message('POINT DE TRESORERIE DE '.$nomHotel.' EN DATE DU : '.$DateCloture))
					// Set the From address with an associative array
					->setFrom([EMAIL => 'Entreprise '.$nomHotel])
					// Set the To addresses with an associative array (setTo/setCc/setBcc)
					->setTo([EMAIL, $Email => 'SYSTEME DE GESTION HOTELIERE FREEDOM'])
					->setBody('<span style="font-size:1.2em;">Cher promoteur, <br/><br/>L\'agent  '.ucfirst($_SESSION['login']).' a clôturé la caisse du <b>'.$DateCloture.'</b> à : <b>'.$Heure_actuelle.'</b>. Le <strong>chiffre d\'affaire</strong> de l\'entreprise s\'élève à : <span style="color:maroon; font-weight:bold;"> '.$Chiffre.
					' '.$devise.'</span>. <br/><br/> <u>Le point total de trésorerie  est réparti comme suit </u>: '.$details.'</span> <span style="font-size:0.8em;"> </span>' )	  ;
					$message->setContentType("text/html");
					// Create your file contents in the normal way, but don't write them to disk
					//$data = create_my_pdf_data('00318/20');
					//$attachment = new Swift_Attachment($data, $Jour_actuelp.'_'.$Heure_actuelle.'_Point_Tresorerie.pdf', 'application/pdf');
					// Attach it to the message
					//$message->attach($attachment);
					// if (!$mailer->send($message)) {
					// 	echo 'Erreur ';
					// } else {
					// 	//echo 'email sent successfully';
					// }
			}else {
				echo "<script language='javascript'>";
				echo 'alertify.error("Clôture de caisse effectuée. Envoi du point de trésorie impossible. Vous n`\'êtes pas connecté à Internet.");';
				echo "</script>";
			}
		}
	if($connected=='true'){
		echo "<script language='javascript'>";
		echo "var date = '".$DateCloture."';";
		echo 'alertify.success("La clôture de la caisse du "+date+" a été effectué avec succès !");';
		echo "</script>";
		echo '<meta http-equiv="refresh" content="2; url=close.php?menuParent=Facturation&upd=1" />';
		}
	}else {
		echo "<script language='javascript'>";
		echo 'alertify.error("Clôture de caisse impossible. Le total encaissé doit être supérieur à zéro.");';
		echo "</script>";
	}

}
 $NbreOP=0;  if($mysqli_num_rowsN>0) $Jour_actuelp=$DateClotureN;
 $req="SELECT count(DISTINCT numFactNorm) AS NbreOP FROM reedition_facture WHERE date_emission='".$Jour_actuelp."' AND numFactNorm <> 0";
 $reqsel=mysqli_query($con,$req);$result=mysqli_fetch_assoc($reqsel);$NbreOP+=isset($result['NbreOP'])?$result['NbreOP']:0;
 //$req=" SELECT count(DISTINCT numrecu) AS NbreOP1 FROM reedition_facture WHERE date_emission='".$Jour_actuel."' AND numFactNorm <> 0";
 //$reqsel=mysqli_query($con,$req);$result=mysqli_fetch_assoc($reqsel);$NbreOP+=isset($result['NbreOP1'])?$result['NbreOP1']:0;
 //$req="SELECT count(DISTINCT num_facture) AS NbreOP2 FROM reedition_facture WHERE date_emission='".$Jour_actuel."' AND numFactNorm <> 0";
 //$reqsel=mysqli_query($con,$req);$result=mysqli_fetch_assoc($reqsel);$NbreOP+=isset($result['NbreOP2'])?$result['NbreOP2']:0;

 $req="SELECT SUM(qte_affecte) AS NbreArt FROM operation WHERE date_modification='".$Jour_actuelp."'  AND designation_operation IN ('Vente de Produits') ";
		$reqsel=mysqli_query($con,$req);$result=mysqli_fetch_assoc($reqsel);  $NbreArt=isset($result['NbreArt'])?$result['NbreArt']:0;

	if($NbreOP>0) $IndiceV=round($NbreArt/$NbreOP,2);

// $req="SELECT montant_ttc,tva  FROM factureeconomat WHERE date_emission='".$Jour_actuel."'";
// 		$reqsel=mysqli_query($con,$req);$montant_ttc=0;$Tva=0;
// 		while($result=mysqli_fetch_array($reqsel)){
// 			$montant_ttc1=isset($result['montant_ttc'])?$result['montant_ttc']:0;
// 			$montant_ttc+=$montant_ttc1;
// 			$Tva1=isset($result['tva'])?$result['tva']:0;
// 			$Tva+=$Tva1;
// 		}
// 		$montant_HT=$montant_ttc-$Tva;

	//if($NbreOP>0)  $Pmoyen=round($montant_ttc/$NbreOP,2); 	if($NbreArt>0)  $PmoyenA=round($montant_ttc/$NbreArt,2);




	//if(isset($agent))
	//{
	//$query="SELECT somme_paye,numrecu,num_facture,Arrhes,numFactNorm FROM reedition_facture WHERE  date_emission='".$Jour_actuel."'  AND receptionniste='".$_SESSION['login']."'";




//http://help.tactill.com/fr/articles/2693907-indice-de-vente-panier-moyen-et-prix-moyen-d-article



if($mysqli_num_rowsN<=0)  $query.="AND state='1' ";
$req1 = mysqli_query($con,$query) or die (mysqli_error($con));
while($close=mysqli_fetch_array($req1)){
	$Heure= $close['Heure']; $utilisateur= $close['utilisateur']; $state= $close['state'];
}  $mysqli_num_rows=mysqli_num_rows($req1);

//echo $query; //echo $DateClotureN;
?>
<!--<h1>Swift_Mailer</h1>
<form action='' method='POST'>
Email : <input type='text' name='email'/> <br/>
Objet : <input type='text' name='objet'/> <br/>
Contenu : <input type='textarea' name='contenu'/> <br/>
<input type='submit' name='mailer' value='Boum!'/>

</form> !-->


<form action='' method='post' name='' enctype='multipart/form-data'>
	<?php	?><table align="center" width="800" height='500' border="1" BORDERCOLOR="white"  cellspacing="0" style="border:2px solid white;margin-top:-30px;border-collapse: collapse;font-family:Cambria;background-color:#DDEEDD;"> <!-- #EFECCA  !-->
		<caption style="text-align:center;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:blue;"> <span style="font-style:italic;font-size:0.8em;color:red;"> </span></caption>
		<tr style="background-color:#F4DEBC;color:teal;font-size:1.2em; padding-bottom:5px;">
			<td colspan="2" align="center"><b> <?php  if(($mysqli_num_rows<=0)||($mysqli_num_rowsN>0)) echo "<span style='color:maroon;'>CLOTURE DE CAISSE JOURNALIERE</span>"; else echo "<span style=''>CAISSE DU &nbsp;<span style='color:maroon;'>".$Date_actuel."</span>&nbsp; CLOTUREE &nbsp;A <span style='color:maroon;'>".$Heure." </span>&nbsp;PAR &nbsp;<span style='color:maroon;'>".strtoupper($utilisateur)."</span></span>"; ?><b/></td>
		</tr><?php  if(($mysqli_num_rows<=0)||($mysqli_num_rowsN>0)){ ?>
		<tr>
			<td  style="padding-left:80px;"> Date de clôture  : &nbsp;&nbsp;&nbsp;<span class="rouge"></span> </td>
			<td >&nbsp;&nbsp;<input type="text" id="" name="Dcloture" style="width:250px;" placeholder='<?php echo $Date_actuel." à ".$Heure_actuelle; ?>' readonly/> </td>
		</tr><?php } ?>

		<tr>
			<td  style="padding-left:80px;"> Nombre d'opérations  : &nbsp;&nbsp;&nbsp;<span class="rouge"></span> </td>
			<td >&nbsp;&nbsp;<input type="text" id="" name="NbreOp" style="width:250px;" placeholder='<?php echo $NbreOP; ?>' onkeypress="testChiffres(event);"  readonly /> </td>
		</tr>
	<!-- <tr>
			<td  style="padding-left:80px;" >Nombre d'articles vendus  :</td>
			<td >&nbsp;&nbsp;<input type="text" id="" name="NbreArt" style="width:250px;" placeholder='<?php if(isset($NbreArt)) echo $NbreArt; ?>' value=""  readonly />
			</td>
	</tr> !-->
	<!-- 	<tr>
			<td  style="padding-left:80px;" >Indice de vente  :</td>
			<td >&nbsp;&nbsp;<input type="text" id="" name="IndiceV" style="width:250px;" placeholder='<?php if(isset($IndiceV)) echo $IndiceV; ?>' value=""  readonly />
			</td>
	</tr> !-->
	<!--<tr>
			<td  style="padding-left:80px;" >Panier moyen d'article :</td>
			<td >&nbsp;&nbsp;<input type="text" id="" name="PmoyenA" style="width:250px;" placeholder='' value=""  readonly />
			</td>
	</tr> !-->
	<tr>
			<td  style="padding-left:80px;color:maroon;font-weight:bold;" >Chiffre d'affaires TTC :&nbsp;&nbsp;&nbsp;<span class="rouge"></span></td>
			<td >&nbsp;&nbsp;<input type="text" id="" name="ChiffreAf" style="width:250px;" readonly value='<?php  if(isset($mt)) echo $mt; ?>' readonly />
			</td>
	</tr>
	<tr>
			<td  style="padding-left:80px;" >Chiffre d'affaires HT:&nbsp;&nbsp;&nbsp;<span class="rouge"></span></td>
			<td >&nbsp;&nbsp;<input type="text" id="" name="Chiffre" style="width:250px;" readonly value='<?php  if(isset($mt)) echo $mt-$Tva-$taxe; ?>' readonly />
			</td>
	</tr>
	<tr>
			<td  style="padding-left:80px;" >Total TVA collectée :</td>
			<td >&nbsp;&nbsp;<input type="text" id="" name="Tva" style="width:250px;" readonly value='<?php if(isset($Tva)) echo $Tva; ?>' readonly />
			</td>
	</tr>
	<tr>
			<td  style="padding-left:80px;" >Total Taxe sur séjour :</td>
			<td >&nbsp;&nbsp;<input type="text" id="" name="Taxe" style="width:250px;" readonly value='<?php if(isset($taxe)) echo $taxe; ?>' readonly />
			</td>
	</tr>
	<tr>
			<td  style="padding-left:80px;" >Fond de Caisse Initial :</td>
			<td >&nbsp;&nbsp;<input type="text" id="" name="FondI" style="width:250px;" value='<?php  echo $Finitial=isset($Finitial)?$Finitial:0;  ?>' readonly />
			</td>
	</tr>
	<tr>
			<td  style="padding-left:80px;color:maroon;font-weight:bold;" >Fond de Caisse Final :</td>
			<td >&nbsp;&nbsp;<input type="text" id="" name="FondF" style="width:250px;" value='<?php if(isset($mt)) echo $mt+$Finitial; ?>' readonly />
			</td>
	</tr>
	<tr>
			<td  style="padding-left:80px;" >Fond de Caisse déclaré :&nbsp;&nbsp;&nbsp;<span style="color:red;">*</span></td>
			<td >&nbsp;&nbsp;<input type="text" id="" name="FondD" style="width:250px;" onkeypress="testChiffres(event);"  value="<?php if(isset($mt)) echo $mt+$Finitial; ?>"/>

			</td>
	</tr>
	<tr><td  colspan='2' align="center" ><br/><?php
		//if(mysqli_num_rows($req1)==0)
		if(($mysqli_num_rows<=0)||($mysqli_num_rowsN>0))	{ ?>

			 <input type="submit" value="Valider"  name="enregistrer1"  id="" class="bouton2"  style=""/>
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> <br/>&nbsp;&nbsp;</td>

		<?php } else echo "&nbsp;";?>
	</td></tr>
</form>

	</div>
</body>
</html>
