<?php
    require('fpdf184/fpdf.php');
    require('config/functions.php');

    $SelCF = $_REQUEST['SelCF'];

    $pdf = new FPDF();
    $pdf->AddPage();

    // proprietario
    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    $sql = "SELECT *
            FROM immobiliare_proprietari
            WHERE CF = '$SelCF'";
    $rs = $db->query($sql);
    $record = $rs->fetch_assoc();

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,10,'Anagrafica di '.$record['nome']." ".$record['cognome']." (".$SelCF.")",0,1);

    // campi
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(40,8,'Codice fiscale',1);
    $pdf->Cell(35,8,'Nome',1);
    $pdf->Cell(35,8,'Cognome',1);
    $pdf->Cell(30,8,'Telefono',1);
    $pdf->Cell(50,8,'Email',1);
    $pdf->Ln();
    
    // ciclo per stampa dati
    $pdf->SetFont('Arial','',8);
    while($record){
        $pdf->Cell(40,8,$record['CF'],1);
        $pdf->Cell(35,8,$record['nome'],1);
        $pdf->Cell(35,8,$record['cognome'],1);
        $pdf->Cell(30,8,$record['telefono'],1);
        $pdf->Cell(50,8,$record['email'],1);
        $pdf->Ln(); 

        $record = $rs->fetch_assoc();
    }

    // spaziatura tra tabelle
    $pdf->Ln(5);
    
    // lista immobili
    $sql = "SELECT *
            FROM immobiliare_proprietari
            WHERE CF = '$SelCF'";
    $rs = $db->query($sql);
    $record = $rs->fetch_assoc();

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,10,'Lista immobili di '.$record['nome']." ".$record['cognome']." (".$SelCF.")",0,1);

    $sql = "SELECT immo.*, inte.IdProp
            FROM immobiliare_immobili AS immo, immobiliare_intestazioni AS inte
            WHERE inte.IdProp = '$SelCF'
            AND immo.Id = inte.IdImmob";
    $rs = $db->query($sql);
    $record = $rs->fetch_assoc();

    // campi
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(40,8,'Proprietario',1);
    $pdf->Cell(30,8,'Nome immobile',1);
    $pdf->Cell(35,8,'Via',1);
    $pdf->Cell(15,8,'Civico',1);
    $pdf->Cell(15,8,'Metratura',1);
    $pdf->Cell(12,8,'Piano',1);
    $pdf->Cell(13,8,'Locali',1);
    $pdf->Cell(15,8,'Tipo',1);
    $pdf->Cell(15,8,'Zona',1);
    $pdf->Ln(); 

        // ciclo per stampa dati
    $pdf->SetFont('Arial','',8);
    while($record){
        $pdf->Cell(40,8,$record['IdProp'],1);
        $pdf->Cell(30,8,$record['nome'],1);
        $pdf->Cell(35,8,$record['via'],1);
        $pdf->Cell(15,8,$record['civico'],1);
        $pdf->Cell(15,8,$record['metratura'],1);
        $pdf->Cell(12,8,$record['piano'],1);
        $pdf->Cell(13,8,$record['nLocali'],1);

        // partendo dall'Id della tipologia, vado nella tabella immobiliare_tipoimm e reperisco il nome della tipologia
        $temp = $record['IdTipo'];
        $sqlTemp = "SELECT tipo.tipo
                    FROM immobiliare_tipoimm AS tipo, immobiliare_immobili AS immo
                    WHERE tipo.Id = $temp";
        $rsTemp = $db->query($sqlTemp);
        $recordTemp = $rsTemp->fetch_assoc();
        $pdf->Cell(15,8,$recordTemp['tipo'],1);

        // partendo dall'Id della zona, vado nella tabella immobiliare_tipozona e reperisco il nome della zona
        $temp = $record['IdZona'];
        $sqlTemp = "SELECT zona.zona
                    FROM immobiliare_tipozona AS zona, immobiliare_immobili AS immo
                    WHERE zona.Id = $temp";
        $rsTemp = $db->query($sqlTemp);
        $recordTemp = $rsTemp->fetch_assoc();
        $pdf->Cell(15,8,$recordTemp['zona'],1);

        $pdf->Ln();

        $record = $rs->fetch_assoc();
    }

    $db->close();
    $pdf->Output();
?>