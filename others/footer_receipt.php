	<?php 
	echo "<tr>
	<td align='right' colspan='2'>Signature,</td>
	</tr>";

	if(isset($signature))
	 echo "<tr> 
				<td align='right' colspan='2'>	<img src='logo/signature.png' alt='' title='' width='100' height='75' border='0'></td>
		 </tr>";
	else echo "<tr> 
				<td align='right' colspan='2'>	&nbsp;</td>
			</tr>
			<tr> 
				<td align='right' colspan='2'>	&nbsp;</td>
			</tr>";
	echo "<tr> 
		<td align='right' colspan='2'>".$signataireFordinaire."</td>
	</tr>
	<tr> 
		<td align='right' colspan='2'>&nbsp;</td>
	</tr>
	<tr>
		<td colspan='2' align='center'> <font size='2' >"; 
		if(!empty($Apostale)) 
			echo $Apostale."&nbsp;&nbsp;"; 
		if((!empty($telephone1))||(!empty($telephone2))) 
		{ echo "TEL: ".$telephone1."/".$telephone2."&nbsp;";}  
		if(!empty($Email))
			echo "&nbsp;&nbsp;E-mail: ".$Email."&nbsp;&nbsp;";
		if(!empty($Siteweb ))
			echo "&nbsp;&nbsp;Site web: ".$Siteweb."&nbsp;&nbsp;";
		if(!empty($NumBancaire))
			echo "Compte Bancaire: ".$NumBancaire; 
		if(!empty($NumUFI))
			echo "&nbsp;&nbsp;N° IFU: ".$NumUFI."&nbsp;&nbsp;";
		if(!empty($nomHotel))
		  echo $nomHotel; 
		echo "&nbsp;- REPUBLIQUE DU BENIN";
		echo "</font>
		</td>
	</tr>";
?>