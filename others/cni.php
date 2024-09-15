	<input id='file' type='file' accept='image/*' name='cpi' onchange="document.forms['form1'].submit();"> 
	<a class='info' id='info' href='fiche_groupe2.php?menuParent=Hébergement&<?php if(!empty($numero)) echo "numero=".$numero; ?>' style='text-decoration:none;'>
	<span style='font-size:0.9em;color:maroon;'> JOINDRE UNE COPIE DE LA PIECE D'IDENTITE</span>
	<label for='file' id='label-file'><i class='fas fa-id-card' style='font-size:1.8em;<?=$style; ?>' ></i></label></a>