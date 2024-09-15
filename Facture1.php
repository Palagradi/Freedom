<?php
session_start();
@include('connexion.php');
require('fpdf17/fpdf3.php');
include 'chiffre_to_lettre.php'; //include 'fpdf2/code128.php';
require_once('vendor/qrCode/qrcode.class.php');


class PDF extends FPDF
{  	function temporaire( $texte )
	{
		$this->SetFont('Arial','B',50);
		$this->SetTextColor(203,203,203);
		$this->Rotate(45,55,190);
		$this->Text(75,190,$texte);
		$this->Rotate(0);
		$this->SetTextColor(0,0,0);
	}
	//$this->temporaire( "Duplicata" );

	function Header()
	{  	if($this->PageNo()==1)
	    {
		global $mydate;
		//$this->Ln('4');
		$this->SetFont('Arial','B',14);
		//if(isset($_SESSION['nomHotel'])) $this->Cell(0,0,$_SESSION['nomHotel'],0,1,'');
		//$this->Ln('0');
		$this->SetFont('Arial','I',10);
		//$this->SetTextColor(0,0,0);

		$date = new DateTime("now"); // 'now' n'est pas n?c?ssaire, c'est la valeur par d?faut
		$tz = new DateTimeZone('Africa/Porto-Novo');
		$date->setTimezone($tz);
		$Heure_actuelle= $date->format("H") .":". $date->format("i").":". $date->format("s");
		$Date_actuel= $date->format("d") ."-". $date->format("m")."-". $date->format("Y");

		if(empty($_SESSION['date_emission']))
		$Date_actuel=!empty($_SESSION['date_emission'])?$_SESSION['date_emission']:$Date_actuel;
		$this->SetFont('Arial','B',13);
		$this->SetTextColor(100,150,255);
		//Titre encadr?
		$this->Cell(0,60,'              ',0,1,'');    //CODIAM

		//$this->Ln('4');
		$this->SetFont('Arial','B',13);
		if(isset($_SESSION['logo'])) $this->Image($_SESSION['logo'],5,10,35,35);
		$this->SetFont('Arial','',10);

		$this->SetTextColor(0,0,0);
			//$x= $this->GetX();$y= $this->GetY();
	// $this->SetXY( $x, $y+75 );

		//$this->fact_dev("Facture d'avoir N?: ",$_SESSION['initial_fiche']);
		if($_SESSION['FV']>0)
			$this->fact_dev("FACTURE DE VENTE ","");
		else
			$this->fact_dev("FACTURE D'AVOIR ","");

/* 		if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
			$this->addDate($_SESSION['remise']+$_SESSION['modulo']);  */   //Commentaire du 10.08.2020 06:52
		//if(isset($_SESSION['avanceA'])&& ($_SESSION['avanceA']>0))
			//$this->addDate($_SESSION['avanceA']);
		//else
			//{
				//if(!isset($_SESSION['fiche']))
				//$this->addDate($_SESSION['avanceA']+$_SESSION['modulo']);  //SOMME REMISE = PAYEE
			// else
				$this->addDate($_SESSION['Date_actuel']); //origine : occup.php

			//}
		//if($_SESSION['Mtotal']<$_SESSION['avanceA']) $_SESSION['Mtotal']=$_SESSION['avanceA'] ;   Revoir ce commentaire !
		//if($_SESSION['Mtotal']<=$_SESSION['avanceA'])
			//$difference2 = abs($_SESSION['Mtotal']-$_SESSION['remise']);
			//$difference = abs($_SESSION['Mtotal']-$_SESSION['avanceA']);
		//if(isset($_SESSION['modulo']) && ($_SESSION['modulo'] > 0))

		$Mtotal=isset($_SESSION['Mtotal'])?$_SESSION['Mtotal']:0;

/*
		if($Mtotal<$_SESSION['avanceA'])
			{$titre="ARRHES";  if($_SESSION['modulo']>0) $difference= $_SESSION['modulo'] ; //else $difference= abs($difference - $_SESSION['modulo']) ;
		}
		else {
			if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
				{$titre="REMISE"; $Mtotal+=$_SESSION['remise'] ; $difference=$_SESSION['remise']; }
			else
				$titre="SOLDE";

			}   */$titre="TYPE SFE";

		$modeReglement="Espèces";
		//$this->addClient($modeReglement);
		$this->addClient($titre,"SFE en ligne");

		//if(($Mtotal< $_SESSION['avanceA'])&&($_SESSION['modulo'] > 0))  $Mtotal = $_SESSION['avanceA'] - $_SESSION['modulo'];

		//$this->addPageNumber($_SESSION['initial_fiche']);
		if(isset( $_SESSION['SIGNATURE_MCF'])) 
			$this->addPageNumber($_SESSION['numFact']); 
		else 
			$this->addPageNumber($_SESSION['eMCF']."-000"); 

/* 		$this->SetXY( $this->GetX()-115, $this->GetY()+35 ); $this->SetTextColor (45);
		if($_SESSION['avanceA']>=0)
			$this->Cell( 10, 8, "Mode de r?glement : ".$modeReglement, 0, 0, 'C');
		else
			{$this->Cell( 47, 8, "Ref. de facture originale : ".$_SESSION['Foriginal1']." (".$_SESSION['Foriginal2'].")", 0, 0, 'C');
			$this->Cell( 100, 8, "|    Mode de r?glement : ".$modeReglement, 0, 0, 'C');
			} */


		$this->SetTextColor(0,0,0);$code=$_SESSION['userId'];
		$vendeur=substr($_SESSION['vendeur'],0,18);
		$this->addReglement($code,$vendeur);

		$this->SetTextColor(0,0,0);
		$this->addEcheance($modeReglement);
		//$_SESSION['fin']="04-04-2014"; //$_SESSION['debut']="04-04-2014";
		$this->addNumTVA($_SESSION['objet']);
		//$this->Ln('10');
		}



	}		// Ajoute une remarque (en bas, a gauche)
		function addRemarque($remarqu,$remarque)
		{
			$this->SetFont( "Arial", "", 10);
			$length = $this->GetStringWidth( "Remarque : " . $remarque );
			$r1  = 10;
			$r2  = $r1 + $length;
			$y1  = $this->h - 45.5;
			$y2  = $y1+5;
			$this->SetXY( $r1 , $y1 );
			$this->Cell($length,4, $remarqu. $remarque);
		}

	function Footer()
	{

	//$this->SetLineWidth(0.1);
	$this->Rect(5, 275, 200, 15, "D");
	        $this->SetXY( 5, 267 ); $this->SetFont('Arial','',8);
          //if(isset($_SESSION['reimprime']))
			//			$this->Cell( $this->GetPageWidth(), 7, "NB: Cette facture n'est qu'un duplicata. L'original a ?t? ?dit?e le : ".substr($_SESSION['date_emission'],8,2).'-'.substr($_SESSION['date_emission'],5,2).'-'.substr($_SESSION['date_emission'],0,4), 0, 0, 'L');
		 //else
			 //$this->Cell( $this->GetPageWidth(), 7, " Merci pour votre visite! Confiants que vous avez pass? un bon s?jour dans notre h?tel, nous esp?rons vous revoir de sit?t.", 0, 0, 'L');
/*
        $y1 = 270;
        //Positionnement en bas et tout centrer
        $this->SetXY( 1, $y1 ); $this->SetFont('Arial','B',10);
        $this->Cell( $this->GetPageWidth(), 5, "REF BANCAIRE : FR76 xxx - BIC : xxxx", 0, 0, 'C');

        $this->SetFont('Arial','',10);

        $this->SetXY( 1, $y1 + 4 );
        $this->Cell( $this->GetPageWidth(), 5, "NOM SOCIETE", 0, 0, 'C');

        $this->SetXY( 1, $y1 + 8 );
        $this->Cell( $this->GetPageWidth(), 5, "ADRESSE 1 + CP + VILLE", 0, 0, 'C');

        $this->SetXY( 1, $y1 + 12 );
        $this->Cell( $this->GetPageWidth(), 5, "Tel + Mail + SIRET", 0, 0, 'C');

        $this->SetXY( 1, $y1 + 16 );
        $this->Cell( $this->GetPageWidth(), 5, "Adresse web", 0, 0, 'C'); */

        // par page de 18 lignes
       // $num_page++; $limit_inf += 18; $limit_sup += 18;

//Positionnement ? 1,5 cm du bas
		//$this->SetY(-15);
		 $this->SetXY( 1, 274 );
		$this->SetFont('Arial','B',15);
		$this->Cell(0,0,'',0,0,'L');
		//Police Arial italique 8
		$this->SetFillColor(200,220,255);
		$this->SetFont('Arial','I',10);
		//Num?ro et nombre de pages
		if(isset($_SESSION['nomHotel'])&& isset($_SESSION['footer1']))
			$this->Cell(-200,10,' '.$_SESSION['nomHotel'].' '.$_SESSION['footer1'] ,0,0,'C');
		if(isset($_SESSION['footer2']))
			$this->Cell(0,18,$_SESSION['footer2'],0,0,'C');
		$this->Cell(-200,25,'REPUBLIQUE DU BENIN ',0,0,'C');

//$this->addRemarque(" Signature",$_SESSION['chiffre_en_lettre']);

//$this->addCadreEurosFrancs("D?tails de la facture",$_SESSION['montant'],$_SESSION['avanceA'],$_SESSION['montant']- $_SESSION['avanceA']);


    $this->SetTextColor(128);
    // Num?ro de page
    //$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'R');

	}

	// Chargement des donn?es
function LoadData($file)
{
    // Lecture des lignes du fichier
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Tableau color?
function FancyTable($header, $data)
{
	$x= $this->GetX();$y= $this->GetY();
	 $this->SetXY( $x, $y+25 );
    // Couleurs, ?paisseur du trait et police grasse
    $this->SetFillColor(193,229,252);
	 //$this->SetFillColor(255,0,0);
    //$this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    //$this->SetFont('arial','B',7);
    // En-t?te
	//$w = array(10,75,40,22,15,33);
    $w = array(10,80,35,35,35);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],6,$header[$i],1,0,'C',true);

    $this->Ln();
    // Restauration des couleurs et de la police
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Donn?es
    $fill = false; $t=0; //$devise=isset($_SESSION['devise'])?$_SESSION['devise']:NULL;
	//.' '.ucfirst(substr($devise,0,1))
    foreach($data as $row)
    {   $this->SetFont('arial','',8); $t++;
        //$this->Cell($w[0],6,substr($row[0],0,18),'LR',0,'C',$fill);
		$this->Cell($w[0],5,$t.".",'LR',0,'C',$fill);
		$this->Cell($w[1],5,utf8_decode(substr($row[0],0,45)),'LR',0,'L',$fill);
        $this->Cell($w[2],5,number_format($row[1],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[3],5,number_format($row[2],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[4],5,number_format($row[3],0,',',' '),'LR',0,'C',$fill);
		//$this->Cell($w[5],6,number_format($row[5],0,',',' '),'LR',0,'C',$fill);
		//$this->Cell($w[6],6,number_format($row[6],0,',',' '),'LR',0,'C',$fill);
		//$this->Cell($w[7],6,number_format($row[7],0,',',' '),'LR',0,'C',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T'); $x= $this->GetX();$y=$this->GetY();

			$somme=125; $reglement="espece"; $date_ech=12;
	       // les totaux, on n'affiche que le HT. le cadre apr?s les lignes, demarre a 213
            $this->SetLineWidth(0.1); $this->SetFillColor(192); $this->Rect(10, $y+2, 125, 8, "DF");
            // HT, la TVA et TTC sont calcul?s apr?s
            //$nombre_format_francais = "Total HT : " . number_format($_SESSION['TotalHT'], 0, ',', ' ') . " F CFA";
            //$this->SetFont('Arial','',10); $this->SetXY( 95, 213 ); $this->Cell( 63, 8, $nombre_format_francais, 0, 0, 'C');
            // en bas ? droite
           // $this->SetFont('Arial','B',8); $this->SetXY( 181, 227 ); $this->Cell( 24, 6, number_format($_SESSION['TotalHT'], 2, ',', ' '), 0, 0, 'R');

            // trait vertical cadre totaux, 8 de hauteur -> 213 + 8 = 221
            $this->Rect(10, $y+2, 195, 8, "D"); //$this->Line(95, 213, 95, 221); $this->Line(158, 213, 158, 221);

            // reglement
            $this->SetXY( 5, 225 ); //$msg="123456789012";


			if(isset($_SESSION['QRCODE_MCF']))
			{
			$msg = isset($_GET['msg']) ? $_GET['msg'] : $_SESSION['QRCODE_MCF'];
			if (!$msg) $msg = "Le site du spipu\r\nhttp://spipu.net/";

			$err = isset($_GET['err']) ? $_GET['err'] : '';
			if (!in_array($err, array('L', 'M', 'Q', 'H'))) $err = 'L';

			$qrcode = new QRcode(utf8_encode($msg), $err);
			$qrcode->displayFPDF($this, 10, $y+12, 27, array(255,255,255),array(0,0,0));
			}

			//$this->SetXY( 45, $y+10 ); $this->Cell( 38, 5, "Mode de r?glement : ", 0, 0, 'L'); $this->Cell( 38, 5, " Esp?ces ", 0, 0, 'L');

			if(isset($_SESSION['NIM_MCF'])) {
			$this->SetXY( 45, $y+15 ); $this->Cell( 38, 5, "MECeF NIM : ", 0, 0, 'L'); $this->Cell( 38, 5,$_SESSION['NIM_MCF'], 0, 0, 'L');
			}
			if(isset($_SESSION['COMPTEUR_MCF'])) {
			$this->SetXY( 45, $y+23 ); $this->Cell( 38, 5, "MECeF Compteurs : ", 0, 0, 'L'); $this->Cell( 38, 5,$_SESSION['COMPTEUR_MCF'], 0, 0, 'L');
			}
			if(isset($_SESSION['DT_HEURE_MCF'])) {
			$this->SetXY( 45, $y+31 ); $this->Cell( 38, 5, "MECeF Heure : ", 0, 0, 'L'); $this->Cell( 38, 5,$_SESSION['DT_HEURE_MCF'], 0, 0, 'L');
			}
/* 			if(isset($_SESSION['DT_HEURE_MCF'])) {
			$this->SetXY( 45, $y+39 ); $this->Cell( 38, 5, " ISF : ", 0, 0, 'L'); $this->Cell( 38, 5,$_SESSION['ISF'], 0, 0, 'L');
			} */

			//$this->UPC_A(100,150,'123456789012',5,0.5,9);//$pdf->UPC_A(10,20,'12345678', 5, 0.35, 9);

			//$this->Cell( 38, 5, "Mode de R?glement :", 0, 0, 'R'); $this->Cell( 55, 5, $reglement, 0, 0, 'L');
            // echeance
           // $champ_date = date_create($echeance); $date_ech = date_format($champ_date, 'd/m/Y');
            //$this->SetXY( 5, 230 ); $this->Cell( 38, 5, "Date Ech?ance :", 0, 0, 'R'); $this->Cell( 38, 5, $date_ech, 0, 0, 'L');



	$taux_tva =12;
		//if ($num_page == $nb_page)
        {   $Xo=0; $Yo=0; if(isset($_SESSION['Apply_AIB'])) { $Xo+=6; $Yo+=6; }
            // le detail des totaux, demarre a 221 apr?s le cadre des totaux
            $this->SetLineWidth(0.1); $this->Rect(135, $y+10, 70, 27+$Yo, "D");
            // les traits verticaux
            $this->Line(165+7, $y+10, 158+7+7, $y+10+27+$Yo); //$this->Line(164, 221, 164, 245);
			//$this->Line(181, 221, 181, 245);
            // les traits horizontaux pas de 6 et demarre a 221
            $this->Line(135, $y+17.5, 205, $y+17.5);
			$this->Line(135, $y+18+6, 205, $y+18+6);
			$this->Line(135, $y+18+6+6.5, 205, $y+18+6+6.5);
			if(isset($_SESSION['Apply_AIB'])) $this->Line(135, $y+18+6+6.5+$Xo, 205, $y+18+6+6.5+$Yo);
			//$this->Line(135, $y+16+6+6+8.5+$Xo, 205, $y+16+6+6+8.5+$Yo);
			//$this->Line(135, $y+16+6+6+6+6+$Xo, 205, $y+16+6+6+6+6+$Yo);
					//$this->Line(126, $y+16+6+6+6+6+6, 201, $y+16+6+6+6+6+6);
					//$this->Line(135, $y+16+6+6+6+6+5, 205, $y+16+6+6+6+6+6);
            // les titres

			$TotalHT=isset($_SESSION['TotalHT'])?$_SESSION['TotalHT']:0;
			$TotalTva=isset($_SESSION['TotalTva'])?$_SESSION['TotalTva']:0;
			$TotalTaxe=isset($_SESSION['TotalTaxe'])?$_SESSION['TotalTaxe']:0;
			$remise=!empty($_SESSION['remise'])?$_SESSION['remise']:0;
			$TotalTTC=isset($_SESSION['TotalTTC'])?$_SESSION['TotalTTC']:0;
			$TotalTTC+=$remise;
			$devise=isset($_SESSION['devise'])?$_SESSION['devise']:"F CFA";
			$ValAIB=isset($_SESSION['ValAIB'])?$_SESSION['ValAIB']:0;
			$PourcentAIB=isset($_SESSION['PourcentAIB'])?$_SESSION['PourcentAIB']:0;
			$NetPayer=(int)$TotalTTC-(int)$remise;

			$voir=1;

            $this->SetFont('Arial','',8);
			$this->SetXY( 175,$y+10.5 ); $this->Cell( 24, 6,$TotalHT." ".$devise, 0, 0, 'R');

			//if($voir!=1)
				//$this->SetXY( 175,$y+10+6 ); $this->Cell( 24, 6, $TotalTva." ".$devise, 0, 0, 'R');

			$this->SetXY( 175,$y+12+6 ); $this->Cell( 24, 6, $TotalTTC." ".$devise, 0, 0, 'R');
			//if(isset($_SESSION['Apply_AIB'])&&!empty($_SESSION['Apply_AIB']))
			//	{$this->SetXY( 175, $y+12+8+$Yo ); $this->Cell( 24, 6, $ValAIB." ".$devise, 0, 0, 'R');	}
			$this->SetXY( 175,$y+9+6+8+$Yo ); $this->Cell( 24, 8, $remise." ".$devise, 0, 0, 'R');
			$this->SetXY( 175,$y+10+6+6+8+$Yo ); $this->Cell( 24, 6, $NetPayer." ".$devise, 0, 0, 'R');
			//$this->SetXY( 175,$y+10+6+6+6+8+$Yo ); $this->Cell( 24, 6, $NetPayer." ".$devise, 0, 0, 'R');



            $this->SetFont('Arial','',8);
            $this->SetXY( 143, $y+9.5 ); $this->Cell( 25, 8, "Montant Total", 0, 0, 'R');
            //if($voir!=1)
				//$this->SetXY( 143, $y+10+6 ); $this->Cell( 25, 6, "TVA Collectée", 0, 0, 'R');
            $this->SetXY( 143, $y+12+6 ); $this->Cell( 25, 6, "Total TTC ", 0, 0, 'R');
			if(isset($_SESSION['Apply_AIB'])&&!empty($_SESSION['Apply_AIB']))
				{$this->SetXY( 143, $y+12+6+$Yo ); $this->Cell( 25, 6, "AIB ( ".$PourcentAIB." % )", 0, 0, 'R');	}
            $this->SetXY( 143, $y+12+6+6+$Yo ); $this->Cell( 25, 6, "Remise accordée", 0, 0, 'R');
			$this->SetXY( 143, $y+12+6+6+6+$Yo ); $this->Cell( 25, 6, "Net à payer", 0, 0, 'R');
			//$this->SetXY( 143, $y+12+6+6+6+6+$Yo ); $this->Cell( 25, 6, "Net à payer ", 0, 0, 'R');
			
			//unset($_SESSION['Apply_AIB']);

            // les taux de tva et HT et TTC
            $col_ht = 0; $col_tva = 0; $col_ttc = 0;
            $taux = 0; $tot_tva = 0; $tot_ttc = 0;
            $x = 130;
           // $sql = 'select taux_tva,sum( round(pu * qte,2) ) tot_ht FROM ligne_facture where id_facture=' .$var_id_facture . ' group by taux_tva order by taux_tva';
            //$res = mysqli_query($con, $sql)  or die ('Erreur SQL : ' .$sql .mysqli_connect_error() );
            //while ($data =  mysqli_fetch_assoc($res))
           // {
                //$this->SetXY( $x, 221 ); $this->Cell( 18, 6, $taux_tva . ' %', 0, 0, 'C');
               // $taux = $data['taux_tva'];
				$taux = 0.18; $tot_ht=$_SESSION['TotalHT'];

                $nombre_format_francais = number_format($tot_ht, 2, ',', ' ');
                //$this->SetXY( $x, 227 ); $this->Cell( 18, 6, $nombre_format_francais, 0, 0, 'R');
                $col_ht = $tot_ht;

                //$col_tva = $col_ht - ($col_ht * (1-($taux/100)));
				$col_tva = $col_ht / 0.18;
                $nombre_format_francais = number_format($col_tva, 2, ',', ' ');
                //$this->SetXY( $x, $y+12 ); $this->Cell( 18, 6, $nombre_format_francais, 0, 0, 'R');

                $col_ttc = $col_ht + $col_tva;
                $nombre_format_francais = number_format($col_ttc, 2, ',', ' ');
                $this->SetXY( $x, $y+18 ); //$this->Cell( 18, 6, $nombre_format_francais, 0, 0, 'R');

                $tot_tva += $col_tva ; $tot_ttc += $col_ttc;

                $x += 18;
           // }
           // mysqli_free_result($res);

            //$nombre_format_francais = "Net ? payer TTC : " . number_format($_SESSION['Mtotal'], 0, ',', ' ') . " F CFA";
            //$this->SetFont('Arial','B',12); $this->SetXY( 5, $y+2 ); $this->Cell( 90, 8, $nombre_format_francais, 0, 0, 'C');
			$this->SetFont('Arial','B',12); $this->SetXY(35, $y+2 );
			if(isset($_SESSION['SIGNATURE_MCF']))
			$this->Cell( 70, 8, " CODE MECeF/DGI : ".$_SESSION['SIGNATURE_MCF'], 0, 0, 'C');
            // en bas ? droite
            $this->SetFont('Arial','B',8); $this->SetXY( 181, $y+19 ); //$this->Cell( 24, 6, number_format($tot_ttc, 2, ',', ' '), 0, 0, 'L');
            // TVA
            //$nombre_format_francais = "Total TVA : " . number_format($tot_tva, 0, ',', ' ') . " F CFA";
            //$this->SetFont('Arial','',10); $this->SetXY( 158, $y+2 ); $this->Cell( 47, 8, $nombre_format_francais, 0, 0, 'C');
			$this->SetFont('Arial','B',10); $this->SetXY( 142, $y+2 ); $this->Cell( 47, 8, "Détails sur la Facturation", 0, 0, 'C');

			// en bas ? droite
            //$this->SetFont('Arial','B',8); $this->SetXY( 181, $y+15 ); //$this->Cell( 24, 6, number_format($tot_tva, 2, ',', ' '), 0, 0, 'L');
        }

}

// Affiche l'adresse du client
// (en haut, a droite)
function addClientAdresse( $adresse )
{
	$r1     = $this->w - 80;
	$r2     = $r1 + 68;
	$y1     = 40;
//$this->SetFont('Arial','B',10);
$this->SetLineWidth(0.1);
 //5mm on, 5mm off
//$this->Line(20,20,190,20);
//$this->SetFont('times','B',10);
$this->SetXY( $r1+2, $y1+4 ); $this->SetTextColor (45); $this->Cell( 47, 8, "ADRESSE DE FACTURATION", 0, 0, 'C');

	//$this->SetDash(2,1);  //Soulignement en pointill?
    $this->SetLineWidth(.1);
	$this->Line($r1+1, $y1+10, $r1+50, $y1+10); //$this->Line(158, $y+10, 158, $y+10+36);

	//$this->SetDash();
	//$this->SetFont('Arial','B',10);
//$this->SetFont('');
	//$this->SetFont('times','B',11);
	$this->SetXY( $r1, $y1+11);
	$this->MultiCell( 60, 4, $adresse);
	$this->SetTextColor (0); //Valeur 0 pour la couleur noir et 255 pour le blanc
	$this->SetFont('Arial','',10); //Suite du tableau
}



function addEntrepriseAdresse( $adresse )
{
	$r1     = $this->w - 200;
	$r2     = $r1 + 68;
	$y1     = 40;
$this->SetFont('Arial','B',9);
//$this->SetLineWidth(0.1);
 //5mm on, 5mm off
//$this->Line(20,20,190,20);
//$this->SetFont('times','B',10);
$this->SetXY( $r1+14, $y1+4 ); $this->SetTextColor (45); $this->Cell( 30, 8, $_SESSION['entreprise'], 0, 0, 'C');
$this->SetFont('Arial','',10);
	//$this->SetDash(2,1);  //Soulignement en pointill?
    $this->SetLineWidth(.1);
	$this->Line($r1+1, $y1+10, $r1+57, $y1+10); //$this->Line(158, $y+10, 158, $y+10+36);

	//$this->SetDash();
	//$this->SetFont('Arial','B',10);
	$this->SetFont('');
	//$this->SetFont('times','B',11);
	$this->SetXY( $r1, $y1+11);
	$this->MultiCell( 60, 4, $adresse);
	$this->SetTextColor (0); //Valeur 0 pour la couleur noir et 255 pour le blanc
	$this->SetFont('Arial','',10); //Suite du tableau
}



function addDateduJour( $adresse )
{$this->SetFont('');
	$r1     = $this->w - 80;
	$r2     = $r1 + 68;
	$y1     = 40;
	$x= $this->GetX();//$y=$this->GetY();
	$this->SetXY( $x, $y1+10);
	$this->MultiCell( 60, 4, $adresse);
}

function SetDash($black=null, $white=null)
{
	if($black!==null)
		$s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
	else
		$s='[] 0 d';
	$this->_out($s);
}

}


$pdf = new PDF();

$client=$_SESSION['client']; $client=utf8_decode($client);

//$NomClt="Client anonyme";
$AdresseClt="Adresse : ";
//$NumIFU=!empty($_SESSION['NumIFU'])?"\n"."Num IFU : ".$_SESSION['NumIFU']:NULL;
$NumIFU=!empty($_SESSION['NumIFU'])?$_SESSION['NumIFU']:NULL;
if(isset($_SESSION['AdresseClt'])&& !empty($_SESSION['AdresseClt'])) $AdresseClt=$_SESSION['AdresseClt']; else if(isset($_SESSION['EmailClt']))  $AdresseClt=$_SESSION['EmailClt'];else  $AdresseClt=NULL;
$TelClt=!empty($_SESSION['TelClt'])?$_SESSION['TelClt']:NULL;
//
if(empty($client)){
	$client="Nom du client : ";$TelClt=NULL; $AdresseClt=NULL;
	}

	//$TelClt=NULL; $AdresseClt=NULL;


// Titres des colonnes
$header = array('N°', 'Désignation', 'Prix Unitaire', 'Quantité','Montant TTC');
// Chargement des donn?es
$data = $pdf->LoadData('txt/facture.txt');
$pdf->AddPage();


$pdf->addClientAdresse("".$client."\n"."IFU : ".$NumIFU."\n"."Adresse : ".$AdresseClt."\n"."Tel : ".$TelClt);

$pdf->addEntrepriseAdresse("IFU : ".$_SESSION['NumIFUEn']."\n"."RCCM : ".$_SESSION['RCCMEn']."\n"."Adresse : ".$_SESSION['AdresseEn']."\n"."Tel : ".$_SESSION['TelEn']."\n"."e-MCF : ".$_SESSION['eMCF']);

//$Date_actuel=!empty($_SESSION['date_emission'])?$_SESSION['date_emission']:$_SESSION['Date_actuel'];
//$pdf->addDateduJour("Cotonou le, ".$Date_actuel);

//$pdf->addDateduJour("Cotonou le, ".$_SESSION['Date_actuel']);

$pdf->FancyTable($header,$data);

//$pdf->SetFont('Arial','B',10);
//$pdf->Cell(0,5,'Hello World !',1);

//if($_SESSION['avanceA']>=0)
//$val=$_SESSION['Mtotal']; 
$val=$_SESSION['TotalTTC']; 

 //else $val=0;
$devise=isset($_GET['devise'])?$_GET['devise']:" Francs CFA"; if($devise=="F CFA") $devise=" Francs CFA";

 $tot_prods = array( array ( "px_unit" => 600, "qte" => 1, "tva" => 1 ),
                    array ( "px_unit" =>  10, "qte" => 1, "tva" => 1 ));
$tab_tva = array( "1"       => 0,
                  "2"       => 0);
$params1  = "Arrêté la présente facture à la somme de :";
$params2=chiffre_en_lettre($val, $devise1=$devise);
//$pdf->addTVAs( $params1,$params2, $tab_tva, $tot_prods);  // les donn?es des tableaux
//$pdf->addCadreEurosFrancs('logo\signature.png','AKPOVO Jean de Dieu');  //Tableau 2

$name=$_SESSION['signataire'];$img="logo\signature.png"; $montant=$params1."".$params2; $signataire="Le Directeur Général";

$x= $pdf->GetX();$y= $pdf->GetY(); if(isset($_SESSION['Apply_AIB'])) $y+=6;

	$pdf->SetXY(10, $y+10+6+6+6+6+6+10);
	$pdf->SetFont( "Arial", "", 10);
	//$pdf->Cell(20,9,"yyyy", 0, 0, "L");
	$pdf->Cell(-20,9,$montant, 0, 0, "");


	$pdf->SetXY($x-15, $y +10+6+6+6+6+6+25);
	$pdf->SetFont( "Arial", "", 9);
	//$pdf->Cell(20,9,"yyyy", 0, 0, "L");
	$pdf->Cell(20,9,$signataire, 0, 0, "R");

		//$pdf->Image($img,$x-25, $y+20,25,25);


	$pdf->SetXY($x-37, $y+10+6+6+6+6+6+42 );
	$pdf->Cell(20,4,'', 0, 0, "C");
	$pdf->Cell(25,9,$name, 0, 0, "R");

$pdf->Output('Facture','I');

//$pdf->Output();

//$req=mysql_query("DROP VIEW IF EXISTS view_temporaire");
//$_SESSION['avanceA']=0;
//$_SESSION['montant']=0;
$_SESSION['defalquer_impaye']=0;unset($_SESSION['date_emission']);
?>
