<?php
ob_start();
echo $indirimYuzdesi;
echo $indirim;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('fonts/DejaVuSans.ttf') format('truetype');
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        .invoice-box {
            max-width: 1000px;
            margin: 0px;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-bottom: 1px solid #555;
        }
        .invoice-box table td {
            padding: 1px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom:1px;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 1px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            margin-top: 2px;
            padding-bottom: 15px;
            padding-top: 6px;
            width: 100%;
        }
        .invoice-box table tr.details td {
            padding-bottom: 2px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #555;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 1px solid #555;
            font-weight: bold;
        }
        .images-container {
          display: flex;
          justify-content: space-between; /* Bu, sol ve sağdaki resimlerin kenarlara yerleşmesini sağlar */
          align-items: center; /* Bu, resimlerin dikeyde ortalanmasını sağlar */
           height: 125px; /* Bu, konteynerin yüksekliğini tarayıcı yüksekliği yapar, isteğe bağlı */
           bottom: 20px;
}

        .logo {
            width: 120px;
            
            flex: 1;
            text-align: left;
            height: 120px;
            padding-right: 125px;
            
        }
        .small-logo {
            width: 120px;
            
            flex: 1;
            text-align: center;
            height: 120px;
            
            
        }
        .qr-code{
            flex: 1;
            text-align: right;
            height: 120px;
            
            padding-right: 5px;
            width: 120px;
        }
        img{
            width: 120px; /* Resimlerin boyutlarını korur */
            height: 120px;
            top:40px;
        }
        .e-fatura{

            font-weight: bold;
            padding-right: 30px;
            position: relative;
            right: 104px;
            top: 7px;

        }
        /*.invoice-box table tr.iban{
            width: fit-content;
        }
       */
    </style>
    <title>Faturalandırma</title>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="3">
                    <table>
                    <tr>
                <td colspan="2">
                    <div class="images-container">
                        <img src="image/yourlogo.jpg" alt="sol" class="logo" >
                        <img src="image/maliye.jpg" alt="orta" class="small-logo">
                         <span class="e-fatura">E-Fatura</span>
                        <img src="image/qr-code.jpg" alt="sağ" class="qr-code" >
                    </div>
                </td>
            </tr>
                        <tr>
                            <td class="title" style="padding-top: 0;padding-bottom:0px; font-weight: bold;">
                                Şirket Adı <br>
                                Şirket Bilgileri <br>
                                Şirket Vergi No: 999999<br>
                            </td>
                            <td>
                                Tarih: <?= date('d-m-Y') ?><br>
                                Fatura No : #<?= rand(1000, 9999) ?><br>
                                Mersis No: 999999<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="3">
                    <table>
                        <tr>
                            <td>
                                <span style="font-weight: bold;">Kiralayan Kişi</span><br>
                                Adı Soyadı<br>
                                TC Kimlik Numarası<br>
                                Telefon Numarası<br>
                                Kiralama Tarihi<br>
                                Teslim Tarihi<br>
                            </td>
                            <td>
                                <br>
                                <?= htmlspecialchars($ad) ?> <?= htmlspecialchars($soyad) ?><br>
                                <?= htmlspecialchars($tcno) ?><br>
                                <?= htmlspecialchars($telefon) ?><br>
                                <?= htmlspecialchars($alistarihi->format('d-m-Y')) ?><br>
                                <?= htmlspecialchars($teslimtarihi->format('d-m-Y')) ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Araç Bilgisi</td>
                <td>Kiralama Ücreti</td>
            </tr>
            <tr class="item">
                <td><?= htmlspecialchars($urun_bilgileri["aciklama"]) ?></td>
                <td><?= htmlspecialchars(number_format($urun_bilgileri["fiyat"], 2)) ?>₺</td>
            </tr>
            <tr class="details">
                <td>Kiralanan Gün Sayısı: <?= htmlspecialchars($gunsayisi) ?></td>
                <td><?= htmlspecialchars(number_format($gunsayisi * $urun_bilgileri["fiyat"], 2)) ?>₺</td>
            </tr>
            <tr class="details">
                <td>Depozito</td>
                <td><?= htmlspecialchars(number_format($depozito, 2)) ?>₺</td>
            </tr>
            <tr class="details">
                <td>KDV (%20)</td>
                <td><?= htmlspecialchars(number_format($kdv, 2)) ?>₺</td>
            </tr>
            <tr class="details">
                <td>İndirim</td>
                <td>-<?= htmlspecialchars(number_format($indirim, 2)) ?>₺</td>
            </tr>
            <tr class="total" style="background: #eee;">
                <td style="border-top: 1px solid #555; font-weight: bold;">Toplam:</td>
                <td><?= htmlspecialchars(number_format($son_fiyat, 2)) ?>₺</td>
            </tr>
         <tr class="iban">
    <td colspan="2" style="border-top: 1px solid #555; border-left: none; border-right: none; border-bottom:none; padding-bottom:10px;">
        Ad Soyad: <?= htmlspecialchars($ibanadsoyad) ?><br>
        IBAN: <?= htmlspecialchars($ibanno) ?><br>
        Banka: <?= htmlspecialchars($nameofbank) ?>
    </td>
</tr>
<tr>
    <td colspan="2" style="border:none; padding-top:15px;">
        <i class="fa fa-file-text-o" aria-hidden="true" style="font-size:43px;top:30px;position:relative;"></i> 
        &nbsp;&nbsp;&nbsp;<span style="font-weight:bold; color:#555;">Açıklama:</span>
    <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#555;">Bu Fatura E-Arşiv Olarak Dijital Ortamda Kesilmiştir.</span>
    </td>
</tr>
 
        </table>
    </div>
</body>
</html>

<?php
ob_end_flush();
?>
