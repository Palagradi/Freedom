<?php
include_once'menu.php';
		mysql_query("SET NAMES 'utf8'");
		$reqsel=mysql_query("SELECT * FROM reservationch WHERE numreserv='".$_GET['numreserv']."'");
		while($data=mysql_fetch_array($reqsel))
			{  $rlt1=$data['numresch'];  
			   $rlt2=$data['nomdemch'];
			   $rlt3=$data['prenomdemch'];
			   $rlt4=$data['contactdemch'];
			   $rlt5=$data['datarrivch'];
			   $rlt6=$data['datdepch'];
			   $rlt7=$data['nomch'];
			 }
		if(isset($_POST['Confirmer']) && $_POST['Confirmer'] == "Confirmer")
		{ 	$reference=$_POST['reference'];
			if($_POST['cham']==2)
				{ 	$reqsel=mysql_query("SELECT numch,avancerc FROM reservationch WHERE numreserv='$reference' ");
					while($data=mysql_fetch_array($reqsel))
						{  $numch=$data['numch']; $avancerc=$data['avancerc'];
						}if($avancerc<=0){$test = "DELETE FROM reservationch WHERE reservationch.numreserv='$reference'";
				   $test1 = "DELETE FROM reserverch WHERE reserverch.numresch='$rlt1' AND numch='$numch'";}
				 // header('location:Reservation_suppression.php?cham=2');
				}
			else
				{$reqsel=mysql_query("SELECT numsalle,avancerc FROM reservationsal WHERE numreserv='$reference' ");
					while($data=mysql_fetch_array($reqsel))
						{  $numsalle=$data['numsalle'];   $avancerc=$data['avancerc'];
						}if($avancerc<=0){ $test2 = "DELETE FROM reservationsal WHERE reservationsal.numreserv ='$reference'";	
				 $test3 = "DELETE FROM reserversal WHERE reserversal.numresch='$reference'";}
				// header('location:Reservation_suppression.php?sal=2');

				}				
			if(!empty($test)) $reqsup = mysql_query($test) or die(mysql_error());
			if(!empty($test1)) $reqsup = mysql_query($test1) or die(mysql_error());
						if(!empty($test2)) $reqsup = mysql_query($test2) or die(mysql_error());
			if(!empty($test3)) $reqsup = mysql_query($test3) or die(mysql_error());
			if($reqsup)
			{$msg="La reservation a &eacute;t&eacute; effectivement supprimer de la liste";
			//$msg1="Retour";
			 if($_POST['cham']==2) echo '<meta http-equiv="refresh" content="0; url=planning_php.php?cham=2" />';
			 else echo '<meta http-equiv="refresh" content="0; url=planning_php.php?sal=2" />';
			}
			if($avancerc>0)
			{ $msg="Vous ne pouvez pas supprimer une réservation déjà payée";
			$msg1="Retour";}
}				
		if(isset($_POST['annuler']) && $_POST['annuler'] == "Annuler")
		{ if($_POST['cham']==2) echo '<meta http-equiv="refresh" content="0; url=planning_php.php?cham=2" />';
			 else echo '<meta http-equiv="refresh" content="0; url=planning_php.php?sal=2" />';
		}
?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>SYGHOC</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<script type="text/javascript" src="date-picker.js"></script>
	</head>
	<body bgcolor='azure' style="margin-top:-1%;">
		<div align="center">
			<form action="Reservation_suppression.php<?php if($sal!='') echo "?sal=2"; if($cham!='') echo "?cham=2";?>" method="POST" name="reservation_modification">
				<table width="700" height="200" border="0" cellpadding="2" cellspacing="0" style="margin-top:50px; border:2px solid; font-family:Cambria;">
					<tr>
						<td colspan="4">
							<h2 style="text-align:center; font-family:Cambria;color:#a4660d;">CONFIRMATION DE LA SUPPRESSION</h2>
						</td>
					</tr>
							  <tr>
						<td colspan="4">
							<h4 style="text-align:center; font-family:Cambria;color:blue;">Voulez vous vraiment supprimer cette réservation?</h4>
						</td>
				</tr>
				<tr>
					<td colspan="2" align="right" style="padding-right: 20px;"> <br/><input type="submit" class="les_boutons" value="Confirmer" id="" name="Confirmer" style="border:2px solid #317082;margin-bottom:20px;"/> </td>
					<td colspan="2">  <br/><input type="submit" name="annuler" class="les_boutons" value="Annuler"/ style="border:2px solid #317082;margin-bottom:20px;"> </td>
				</tr>
				<input type="hidden" id="" name="cham" value="<?php echo $_GET['cham']; ?>" />
<tr>   <td colspan="2"> <input type="hidden" id="" name="reference" value="<?php echo $_GET['numreserv']; ?>" onFocus="this.blur()" style="width:75px;" /> </td></tr>

				</table>
			</form>
			<table width="582" border="0" cellspacing="0" cellpadding="0">
			<tr>
			    <td>
				<h4 style="text-align:center; font-family:Cambria;color:#a4660d;"> <?php echo $msg ?></h4>
				</td>
			</tr>
			<tr>
			    <td>
				<a href="planning_php.php?<?php if(!empty($cham)){ echo 'cham='.$cham;} if(!empty($sal)) { echo 'sal='.$sal;}?>" style="text-decoration:none;"><span style="text-align:center; font-family:Cambria;color:blue;margin-left:250px;"><?php echo $msg1 ?></span></a>
				</td>
			</tr>
			</table>
		</div>
	</body>
</html>