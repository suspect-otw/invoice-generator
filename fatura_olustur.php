<?php
ob_start(); 

require_once 'autoload.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = $_POST["ad"];
    $soyad = $_POST["soyad"];
    $tcno = $_POST["tcno"];
    $telefon = $_POST["telefon"];
    $urun = $_POST["urun"];
    $alistarihi = DateTime::createFromFormat('d-m-Y', $_POST["alistarihi"]);
    $teslimtarihi = DateTime::createFromFormat('d-m-Y', $_POST["teslimtarihi"]);
    $ibanadsoyad = $_POST["ibanadsoyad"];
    $ibanno = $_POST["ibanno"];
    $nameofbank = $_POST["nameofbank"];
    $indirimYuzdesi = isset($_POST["indirimYuzdesi"]) ? intval($_POST["indirimYuzdesi"]) : 0;
    

    // Tarih formatının doğru olup olmadığını kontrol et
    if (!$alistarihi || !$teslimtarihi) {
        die("Tarih formatı hatalı!");
    }
    
    $urunler = [
        "urun1" => ["isim" => "Clio 2022", "fiyat" => 1000.00, "aciklama" => "RENAULT CLİO 2023 Model Dizel Otomatik Beyaz Renk - 2023 - Dizel - Otomatik"],
        "urun2" => ["isim" => "Golf 2023", "fiyat" => 2000.00, "aciklama" => "2023 Volkswagen Golf 1.5 eTSI 150 PS DSG R-Line"],
        "urun3" => ["isim" => "Mercedes-Benz 2016", "fiyat" => 3000.00, "aciklama" => "2016 Mercedes C 200d 1.6 136 PS 7G-Tronic AMG"]
    ];

    $urun_bilgileri = $urunler[$urun];

    // Gün sayısını hesapla
    $interval = $teslimtarihi->diff($alistarihi);
    $gunsayisi = $interval->days;

    

    // Hesaplamalar
    $toplam_fiyat = $urun_bilgileri["fiyat"] * $gunsayisi;
    $kdv = $toplam_fiyat * 0.20;
    $indirim = ($toplam_fiyat * $indirimYuzdesi) / 100;
    $depozito = 2000.00;
    $son_fiyat = $toplam_fiyat + $depozito + $kdv - $indirim;

}

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('tempDir', '/tmp');
$options->set('chroot', __DIR__);

include 'content.php'; // PDF içeriği burada oluşturulacak
$content = ob_get_clean(); // Çıktıyı al

$dompdf = new Dompdf($options);
$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("invoice.pdf", ["Attachment" => false]);

exit(); // İşlem tamamlandıktan sonra çıkış yap
?>
