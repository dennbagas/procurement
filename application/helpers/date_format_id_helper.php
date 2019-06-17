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
