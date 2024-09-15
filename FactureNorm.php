<?php
session_start();
//if(isset($_SESSION['EtatS'])&& ($_SESSION['remise']>0))
	//require('fpdf17/fpdf.php');
//else

@include('connexion.php');

/*  		//if(isset($_SESSION['EtatS'])){
		$sql="SELECT MAX(id_request) AS  id_request FROM t_mecef";
		$query=mysqli_query($con,$sql);$data=mysqli_fetch_object($query);
		//	$id_request=$data->id_request;
		$id_request=61;

		$query="SELECT responsjson FROM t_mecef WHERE id_request='".$id_request."'";
		$res1=mysqli_query($con,$query); $data=mysqli_fetch_object($res1);
		$result = array ();
		$result = json_decode($data->responsjson);

 		$QRCODE_MCF      = isset($result->QRCODE_MCF)?$result->QRCODE_MCF:NULL;
		$COMPTEUR_MCF    = isset($result->COMPTEUR_MCF)?$result->COMPTEUR_MCF:NULL;
		$DT_HEURE_MCF    = isset($result->DT_HEURE_MCF)?$result->DT_HEURE_MCF:NULL;
	    $NIM_MCF         = isset($result->NIM_MCF)?$result->NIM_MCF:NULL;
		$SIGNATURE_MCF   = isset($result->SIGNATURE_MCF)?$result->SIGNATURE_MCF:NULL;
		$IFU_MCF         = isset($result->IFU_MCF)?$result->IFU_MCF:NULL; */
		//}
require('fpdf17/fpdf2.php');
		 include 'chiffre_to_lettre.php'; //include 'fpdf2/code128.php';

require_once('qrCode/qrcode.class.php');


class PDF extends FPDF
{ /* 	function temporaire( $texte )
	{
		$this->SetFont('Arial','B',50);
		$this->SetTextColor(203,203,203);
		$this->Rotate(45,55,190);
		$this->Text(75,190,$texte);
		$this->Rotate(0);
		$this->SetTextColor(0,0,0);
	} */
	//if(isset($_GET['d'])&& ($_GET['d']==1)) $this->temporaire( "Duplicata" );
	function Header()
	{  	if($this->PageNo()==1)
	    {
		global $mydate;
		//$this->Ln('4');
		$this->SetFont('Arial','B',14);
		//Titre encadrï¿½
		//$this->SetTextColor(100,150,255);
		//$sDateReturn=substr(date("Y-m-d")).'-'.substr(date("Y-m-d")).'-'.substr(date("Y-m-d"));
		if(isset($_SESSION['nomHotel'])) $this->Cell(0,0,$_SESSION['nomHotel'],0,1,'');
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

		//if(empty($_SESSION['date_emission']))
		//$this->Cell(0,0,'
		                                                                                                                                  //Cotonou le, '.substr(date("Y-m-d"),8,2).'/'.substr(date("Y-m-d"),5,2).'/'.substr(date("Y-m-d"),0,4),0,1,'');
		//else
				//$this->Cell(0,0,'
		                                                                                                                                  //Cotonou le, '.substr($_SESSION['date_emission'],8,2).'/'.substr($_SESSION['date_emission'],5,2).'/'.substr($_SESSION['date_emission'],0,4),0,1,'');$this->Ln('10');
		$this->SetFont('Arial','B',13);
		$this->SetTextColor(100,150,255);
		//Titre encadrï¿½
		$this->Cell(0,60,'              ',0,1,'');    //CODIAM

		//$this->Ln('4');
		$this->SetFont('Arial','B',13);
		//$this->SetTextColor(0,0,0);



		//Titre encadrï¿½
		//$this->Cell(0,0,"Facture Nï¿½: ".$_SESSION['initial_fiche'],0,1,'C');
		if(isset($_SESSION['logo'])) $this->Image($_SESSION['logo'],10,15,30,20);
		$this->SetFont('Arial','',10);

		$this->SetTextColor(0,0,0);
			//$x= $this->GetX();$y= $this->GetY();
	// $this->SetXY( $x, $y+75 );
		$this->fact_dev( "Facture N°: ",$_SESSION['initial_fiche'] ); //$_SESSION['modulo']=0;//$_SESSION['avanceA']=0;
/* 		if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
			$this->addDate($_SESSION['remise']+$_SESSION['modulo']);  */   //Commentaire du 10.08.2020 06:52
		//if(isset($_SESSION['avanceA'])&& ($_SESSION['avanceA']>0))
			//$this->addDate($_SESSION['avanceA']);
		//else
			//{
				//if(!isset($_SESSION['fiche']))
				//$this->addDate($_SESSION['avanceA']+$_SESSION['modulo']);  //SOMME REMISE = PAYEE
			// else
				$this->addDate($_SESSION['avanceA']); //origine : occup.php

			//}
		//if($_SESSION['Mtotal']<$_SESSION['avanceA']) $_SESSION['Mtotal']=$_SESSION['avanceA'] ;   Revoir ce commentaire !
		//if($_SESSION['Mtotal']<=$_SESSION['avanceA'])
			//$difference2 = abs($_SESSION['Mtotal']-$_SESSION['remise']);
			$difference = abs($_SESSION['Mtotal']-$_SESSION['avanceA']);
		//if(isset($_SESSION['modulo']) && ($_SESSION['modulo'] > 0))

		$Mtotal=$_SESSION['Mtotal'];


		if($Mtotal<$_SESSION['avanceA'])
			{$titre="ARRHES";  if($_SESSION['modulo']>0) $difference= $_SESSION['modulo'] ; //else $difference= abs($difference - $_SESSION['modulo']) ;
		}
		else {
			if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
				{$titre="REMISE"; $Mtotal+=$_SESSION['remise'] ; $difference=$_SESSION['remise']; }
			else
				$titre="SOLDE";

			}

		//if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
			$this->addClient($titre,$difference);  //SOMME PAYEE
		//else
			//$this->addClient($titre,abs($Mtotal-$_SESSION['remise']));

		if(($Mtotal< $_SESSION['avanceA'])&&($_SESSION['modulo'] > 0))  $Mtotal = $_SESSION['avanceA'] - $_SESSION['modulo'];



		$this->addPageNumber($Mtotal);  // TOTAL TTC


		$this->SetTextColor(0,0,0);
		$this->addReglement($_SESSION['nom']." ".$_SESSION['prenom']);

		$this->SetTextColor(0,0,0);
		$this->addEcheance( "Hébergement");
		//$_SESSION['fin']="04-04-2014";
		$this->addNumTVA(  "Du"." ".$_SESSION['debut']." "."au"." ".$_SESSION['fin'] );
		$this->Ln('10');
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
	        $this->SetXY( 1, 268 ); $this->SetFont('Arial','',7);
        //$this->Cell( $this->GetPageWidth(), 7, "Clause de rï¿½serve de propriï¿½tï¿½ (loi 80.335 du 12 mai 1980) : Les marchandises vendues demeurent notre propriï¿½tï¿½ jusqu'au paiement intï¿½gral de celles-ci.", 0, 0, 'C');
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

//Positionnement ï¿½ 1,5 cm du bas
		//$this->SetY(-15);
		 $this->SetXY( 1, 274 );
		$this->SetFont('Arial','B',15);
		$this->Cell(0,0,'',0,0,'L');
		//Police Arial italique 8
		$this->SetFillColor(200,220,255);
		$this->SetFont('Arial','I',10);
		//Numï¿½ro et nombre de pages
		if(isset($_SESSION['nomHotel'])&& isset($_SESSION['footer1']))
			$this->Cell(-200,10,' '.$_SESSION['nomHotel'].' '.$_SESSION['footer1'] ,0,0,'C');
		if(isset($_SESSION['footer2']))
			$this->Cell(0,18,$_SESSION['footer2'],0,0,'C');
		$this->Cell(-200,25,'REPUBLIQUE DU BENIN ',0,0,'C');

//$this->addRemarque(" Signature",$_SESSION['chiffre_en_lettre']);

//$this->addCadreEurosFrancs("Dï¿½tails de la facture",$_SESSION['montant'],$_SESSION['avanceA'],$_SESSION['montant']- $_SESSION['avanceA']);


    $this->SetTextColor(128);
    // Numï¿½ro de page
    //$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'R');

	}

	// Chargement des donnï¿½es
function LoadData($file)
{
    // Lecture des lignes du fichier
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Tableau colorï¿½
function FancyTable($header, $data)
{
	$x= $this->GetX();$y= $this->GetY();
	 $this->SetXY( $x, $y+38 );
    // Couleurs, ï¿½paisseur du trait et police grasse
    $this->SetFillColor(193,229,252);
	 //$this->SetFillColor(255,0,0);
    //$this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    //$this->SetFont('arial','B',7);
    // En-tï¿½te
    $w = array(10,65,20,15,25,15,20,25);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);

    $this->Ln();
    // Restauration des couleurs et de la police
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Donnï¿½es
    $fill = false; $t=0;
    foreach($data as $row)
    {   $this->SetFont('arial','',8); $t++;
        //$this->Cell($w[0],6,substr($row[0],0,17),'LR',0,'C',$fill);
		$this->Cell($w[0],6,$t.".",'LR',0,'C',$fill);
        $this->Cell($w[1],6,utf8_decode($row[1]),'LR',0,'L',$fill);
		$this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
        $this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'C',$fill);
		//$this->Cell($w[4],6,number_format($row[4],4,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[4],6,number_format($row[4],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[5],6,number_format($row[5],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[6],6,number_format($row[6],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[7],6,number_format($row[7],0,',',' '),'LR',0,'C',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T'); $x= $this->GetX();$y=$this->GetY();

			$somme=125; $reglement="espece"; $date_ech=12;
	       // les totaux, on n'affiche que le HT. le cadre aprï¿½s les lignes, demarre a 213
            $this->SetLineWidth(0.1); $this->SetFillColor(192); $this->Rect(10, $y+2, 116, 8, "DF");
            // HT, la TVA et TTC sont calculï¿½s aprï¿½s
            //$nombre_format_francais = "Total HT : " . number_format($_SESSION['TotalHT'], 0, ',', ' ') . " F CFA";
            //$this->SetFont('Arial','',10); $this->SetXY( 95, 213 ); $this->Cell( 63, 8, $nombre_format_francais, 0, 0, 'C');
            // en bas ï¿½ droite
           // $this->SetFont('Arial','B',8); $this->SetXY( 181, 227 ); $this->Cell( 24, 6, number_format($_SESSION['TotalHT'], 2, ',', ' '), 0, 0, 'R');

            // trait vertical cadre totaux, 8 de hauteur -> 213 + 8 = 221
            $this->Rect(10, $y+2, 191, 8, "D"); //$this->Line(95, 213, 95, 221); $this->Line(158, 213, 158, 221);

            // reglement
            $this->SetXY( 5, 225 ); //$msg="123456789012";


			if(isset($_SESSION['QRCODE_MCF']))
			{
			$msg = isset($_GET['msg']) ? $_GET['msg'] : $_SESSION['QRCODE_MCF'];
			if (!$msg) $msg = "Le site du spipu\r\nhttp://spipu.net/";

			$err = isset($_GET['err']) ? $_GET['err'] : '';
			if (!in_array($err, array('L', 'M', 'Q', 'H'))) $err = 'L';

			$qrcode = new QRcode(utf8_encode($msg), $err);
			$qrcode->displayFPDF($this, 10, $y+12, 33, array(255,255,255),array(0,0,0));
			}
			if(isset($_SESSION['NIM_MCF'])) { $this->SetXY( 45, $y+15 ); $this->Cell( 38, 5, "MECeF NIM : ", 0, 0, 'L'); $this->Cell( 38, 5,$_SESSION['NIM_MCF'], 0, 0, 'L');
			}
			if(isset($_SESSION['COMPTEUR_MCF'])) {
			$this->SetXY( 45, $y+22 ); $this->Cell( 38, 5, "MECeF Compteurs : ", 0, 0, 'L'); $this->Cell( 38, 5,$_SESSION['COMPTEUR_MCF'], 0, 0, 'L');
			}
			if(isset($_SESSION['DT_HEURE_MCF'])) {
			$this->SetXY( 45, $y+30 ); $this->Cell( 38, 5, "MECeF Heure : ", 0, 0, 'L'); $this->Cell( 38, 5,$_SESSION['DT_HEURE_MCF'], 0, 0, 'L');
			}
			if(isset($_SESSION['DT_HEURE_MCF'])) {
			$this->SetXY( 45, $y+40 ); $this->Cell( 38, 5, " ISF : ", 0, 0, 'L'); $this->Cell( 38, 5,$_SESSION['ISF'], 0, 0, 'L');
			}






			//$this->UPC_A(100,150,'123456789012',5,0.5,9);//$pdf->UPC_A(10,20,'12345678', 5, 0.35, 9);

			//$this->Cell( 38, 5, "Mode de Rï¿½glement :", 0, 0, 'R'); $this->Cell( 55, 5, $reglement, 0, 0, 'L');
            // echeance
           // $champ_date = date_create($echeance); $date_ech = date_format($champ_date, 'd/m/Y');
            //$this->SetXY( 5, 230 ); $this->Cell( 38, 5, "Date Echï¿½ance :", 0, 0, 'R'); $this->Cell( 38, 5, $date_ech, 0, 0, 'L');



	$taux_tva =12;
		//if ($num_page == $nb_page)
        {
            // le detail des totaux, demarre a 221 aprï¿½s le cadre des totaux
            $this->SetLineWidth(0.1); $this->Rect(126, $y+10, 75, 36, "D");
            // les traits verticaux
            $this->Line(158, $y+10, 158, $y+10+36); //$this->Line(164, 221, 164, 245);
			//$this->Line(181, 221, 181, 245);
            // les traits horizontaux pas de 6 et demarre a 221
            $this->Line(126, $y+16, 201, $y+16);
			$this->Line(126, $y+16+6, 201, $y+16+6);
			$this->Line(126, $y+16+6+6, 201, $y+16+6+6);
			$this->Line(126, $y+16+6+6+6, 201, $y+16+6+6+6);
			$this->Line(126, $y+16+6+6+6+6, 201, $y+16+6+6+6+6);
			//$this->Line(126, $y+16+6+6+6+6+6, 201, $y+16+6+6+6+6+6);
            // les titres

			$TotalHT=isset($_SESSION['TotalHT'])?$_SESSION['TotalHT']:0;
			$TotalTva=isset($_SESSION['TotalTva'])?$_SESSION['TotalTva']:0;
			$TotalTaxe=isset($_SESSION['TotalTaxe'])?$_SESSION['TotalTaxe']:0;
			$remise=!empty($_SESSION['remise'])?$_SESSION['remise']:0;
			$TotalTTC=isset($_SESSION['TotalTTC'])?$_SESSION['TotalTTC']:0;
			$TotalTTC+=$remise;
			$devise=isset($_SESSION['devise'])?$_SESSION['devise']:NULL;
			$NetPayer=(int)$TotalTTC-(int)$remise;

            $this->SetFont('Arial','',8);
			$this->SetXY( 165,$y+10 ); $this->Cell( 24, 6,$TotalHT." ".$devise, 0, 0, 'R');
			$this->SetXY( 165,$y+10+6 ); $this->Cell( 24, 6, $TotalTva." ".$devise, 0, 0, 'R');
			$this->SetXY( 165,$y+10+6+6 ); $this->Cell( 24, 6, $TotalTaxe." ".$devise, 0, 0, 'R');
			$this->SetXY( 165,$y+10+6+6+6 ); $this->Cell( 24, 6, $TotalTTC." ".$devise, 0, 0, 'R');
			$this->SetXY( 165,$y+10+6+6+6+6 ); $this->Cell( 24, 6, $remise." ".$devise, 0, 0, 'R');
			$this->SetXY( 165,$y+10+6+6+6+6+6 ); $this->Cell( 24, 6, $NetPayer." ".$devise, 0, 0, 'R');
            $this->SetFont('Arial','',8);
            $this->SetXY( 130, $y+10 ); $this->Cell( 25, 6, "Montant Total HT", 0, 0, 'R');
            $this->SetXY( 130, $y+10+6 ); $this->Cell( 25, 6, "TVA Collectée", 0, 0, 'R');
            $this->SetXY( 130, $y+10+6+6 ); $this->Cell( 25, 6, "Taxe de séjour", 0, 0, 'R');
            $this->SetXY( 130, $y+10+6+6+6 ); $this->Cell( 25, 6, "Total TTC", 0, 0, 'R');
			$this->SetXY( 130, $y+10+6+6+6+6 ); $this->Cell( 25, 6, "Remise accordée", 0, 0, 'R');
			$this->SetXY( 130, $y+10+6+6+6+6+6 ); $this->Cell( 25, 6, "Net à payer ", 0, 0, 'R');

            // les taux de tva et HT et TTC
            $col_ht = 0; $col_tva = 0; $col_ttc = 0;
            $taux = 0; $tot_tva = 0; $tot_ttc = 0;
            $x = 130;
           // $sql = 'select taux_tva,sum( round(pu * qte,2) ) tot_ht FROM ligne_facture where id_facture=' .$var_id_facture . ' group by taux_tva order by taux_tva';
            //$res = mysqli_query($con, $sql)  or die ('Erreur SQL : ' .$sql .mysqli_connect_error() );
            //while ($data =  mysqli_fetch_assoc($res))
           // {
                //$this->SetXY( $x, 221 ); $this->Cell( 17, 6, $taux_tva . ' %', 0, 0, 'C');
               // $taux = $data['taux_tva'];
				$taux = 0.18; $tot_ht=$_SESSION['TotalHT'];

                $nombre_format_francais = number_format($tot_ht, 2, ',', ' ');
                //$this->SetXY( $x, 227 ); $this->Cell( 17, 6, $nombre_format_francais, 0, 0, 'R');
                $col_ht = $tot_ht;

                //$col_tva = $col_ht - ($col_ht * (1-($taux/100)));
				$col_tva = $col_ht / 0.18;
                $nombre_format_francais = number_format($col_tva, 2, ',', ' ');
                //$this->SetXY( $x, $y+12 ); $this->Cell( 17, 6, $nombre_format_francais, 0, 0, 'R');

                $col_ttc = $col_ht + $col_tva;
                $nombre_format_francais = number_format($col_ttc, 2, ',', ' ');
                $this->SetXY( $x, $y+18 ); //$this->Cell( 17, 6, $nombre_format_francais, 0, 0, 'R');

                $tot_tva += $col_tva ; $tot_ttc += $col_ttc;

                $x += 17;
           // }
           // mysqli_free_result($res);

            //$nombre_format_francais = "Net ï¿½ payer TTC : " . number_format($_SESSION['Mtotal'], 0, ',', ' ') . " F CFA";
            //$this->SetFont('Arial','B',12); $this->SetXY( 5, $y+2 ); $this->Cell( 90, 8, $nombre_format_francais, 0, 0, 'C');
			$this->SetFont('Arial','B',12); $this->SetXY(35, $y+2 );
			if(isset($_SESSION['SIGNATURE_MCF']))
			$this->Cell( 65, 8, " CODE MECeF/DGI : ".$_SESSION['SIGNATURE_MCF'], 0, 0, 'C');
            // en bas ï¿½ droite
            $this->SetFont('Arial','B',8); $this->SetXY( 181, $y+19 ); //$this->Cell( 24, 6, number_format($tot_ttc, 2, ',', ' '), 0, 0, 'L');
            // TVA
            //$nombre_format_francais = "Total TVA : " . number_format($tot_tva, 0, ',', ' ') . " F CFA";
            //$this->SetFont('Arial','',10); $this->SetXY( 158, $y+2 ); $this->Cell( 47, 8, $nombre_format_francais, 0, 0, 'C');
			$this->SetFont('Arial','B',10); $this->SetXY( 140, $y+2 ); $this->Cell( 47, 8, "Détails sur la Facturation", 0, 0, 'C');

			// en bas ï¿½ droite
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
$this->SetXY( $r1+2, $y1+4 ); $this->Cell( 47, 8, "IDENTIFICATION DU CLIENT ", 0, 0, 'C');
  $this->SetLineWidth(.1);
	$this->Line($r1+2, $y1+10, $r1+48, $y1+10); //$this->Line(158, $y+10, 158, $y+10+36);
	//$this->SetFont('Arial','I',10);
	//$this->SetXY( $r1-22, $y1+10 ); $this->Cell( 47, 8, "Identite ", 0, 0, 'L');
	//$this->SetXY( $r1-22, $y1+15 ); $this->Cell( 47, 8, "du client", 0, 0, 'L');

	//$this->SetFont('Arial','B',10);
//$this->SetFont('');
	$this->SetXY( $r1, $y1+11);
	$this->MultiCell( 60, 4, $adresse);
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
}


$pdf = new PDF();

$client=isset($_SESSION['groupe1'])?$_SESSION['groupe1']:$_SESSION['client'];

$client=utf8_decode($client);

//$NomClt="Client anonyme";
$AdresseClt="Adresse : ";
//$NumIFU=!empty($_SESSION['NumIFU'])?"\n"."Num IFU : ".$_SESSION['NumIFU']:NULL;
$NumIFU=!empty($_SESSION['NumIFU'])?"\n".$_SESSION['NumIFU']:NULL;
if(isset($_SESSION['AdresseClt'])&& !empty($_SESSION['AdresseClt'])) $AdresseClt=$_SESSION['AdresseClt']; else if(isset($_SESSION['EmailClt']))  $AdresseClt=$_SESSION['EmailClt'];else  $AdresseClt=NULL;
$TelClt=!empty($_SESSION['TelClt'])?"\n".$_SESSION['TelClt']:NULL;
//



// Titres des colonnes
$header = array('N°', 'Nom & Prénoms', 'Chambre', 'Nuitée', 'Montant HT','TVA','Taxe','Montant TTC');
// Chargement des donnï¿½es
$data = $pdf->LoadData('txt/facture.txt');
$pdf->AddPage();


$pdf->addClientAdresse("".$client."\n"."Num IFU :".$NumIFU."\n"."Adresse : ".$AdresseClt."\n"."Tel : ".$TelClt);

$pdf->addDateduJour("Cotonou le, ".$_SESSION['Date_actuel']);

$pdf->FancyTable($header,$data);

//$pdf->SetFont('Arial','B',10);
//$pdf->Cell(0,5,'Hello World !',1);

$val=$_SESSION['Mtotal'];  $devise=isset($_GET['devise'])?$_GET['devise']:"Francs CFA"; if($devise=="F CFA") $devise="Francs CFA";

 $tot_prods = array( array ( "px_unit" => 600, "qte" => 1, "tva" => 1 ),
                    array ( "px_unit" =>  10, "qte" => 1, "tva" => 1 ));
$tab_tva = array( "1"       => 0,
                  "2"       => 0);
$params1  = "Arrêté la présente facture à la somme de :";
$params2=chiffre_en_lettre($val, $devise1=$devise);
//$pdf->addTVAs( $params1,$params2, $tab_tva, $tot_prods);  // les donnï¿½es des tableaux
//$pdf->addCadreEurosFrancs('logo\signature.png','AKPOVO Jean de Dieu');  //Tableau 2

$name="Sylvestre SEGOUN";$img="logo\signature.png"; $montant=$params1."".$params2; $signataire="Le Gérant";

$x= $pdf->GetX();$y= $pdf->GetY();

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
