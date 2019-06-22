<?php
defined('BASEPATH') or exit('No direct script access allowed');

function date_id($date)
{
    $date = date('Y-m-d', strtotime($date));
    if ($date == '0000-00-00') {
        return 'Tanggal Kosong';
    }

    $tgl = substr($date, 8, 2);
    $bln = substr($date, 5, 2);
    $thn = substr($date, 0, 4);

    switch ($bln) {
        case 1:{ $bln = 'Januari';}break;
        case 2:{ $bln = 'Februari';}break;
        case 3:{ $bln = 'Maret';}break;
        case 4:{ $bln = 'April';}break;
        case 5:{ $bln = 'Mei';}break;
        case 6:{ $bln = "Juni";}break;
        case 7:{ $bln = 'Juli';}break;
        case 8:{ $bln = 'Agustus';}break;
        case 9:{ $bln = 'September';}break;
        case 10:{ $bln = 'Oktober';}break;
        case 11:{ $bln = 'November';}break;
        case 12:{ $bln = 'Desember';}break;
        default:{ $bln = 'UnKnown';}break;
    }

    $tanggalIndonesia = $tgl . " " . $bln . " " . $thn;
    return $tanggalIndonesia;
}

function romawi($month)
{
    switch ($month) {
        case 1:{return "I";}break;
        case 2:{return "II";}break;
        case 3:{return "III";}break;
        case 4:{return "IV";}break;
        case 5:{return "V";}break;
        case 6:{return "VI";}break;
        case 7:{return "VII";}break;
        case 8:{return "VII";}break;
        case 9:{return "IX";}break;
        case 10:{return "X";}break;
        case 11:{return "XI";}break;
        case 12:{return "XII";}break;
    }
}
