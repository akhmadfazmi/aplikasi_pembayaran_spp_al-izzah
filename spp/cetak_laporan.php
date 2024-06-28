<?php
session_start();
if(isset($_SESSION['admin'])){
    include 'koneksi.php';
    include 'funcion_rupiah.php';
    $awal = $_GET['awal'];
    $akhir = $_GET['akhir'];
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title> Laporan Pembayaran</title>
            <style>
                body{
                    font-family: arial;
                }
                .print{
                    margin-top:10px;
                }
                @media print{
                    .print{
                        display: none;
                    }
                }
                table{
                    border-collapse: collapse;
                }
            </style>
        </head>
        <body onload="window.print()">
        <h3>SD ISLAM TERPADU AL IZZAH<b><br/>LAPORAN PEMBAYARAN SPP</b></h3>
        <br/>
        <hr/>
        Tanggal <?= $awal." Sampai ".$akhir; ?>
        <br/>
        <br>
        <table border="1" cellspacing="" cellpadding="4" width="100%">
            <tr>
                <th>no</th>
                <th>NISN</th>
                <th>NAMA SISWA</th>
                
                <th>NO. BAYAR</th>
                <th>PEMBAYARAN BULAN</th>
                <th>JUMLAH</th>
                <th>KETERANGAN</th>
            </tr>
            <?php
            $spp = mysqli_query($conn, "SELECT siswa.*, pembayaran.* FROM siswa,pembayaran WHERE pembayaran.id_siswa = siswa.id_siswa AND tglbayar BETWEEN '$awal' AND '$akhir' ORDER BY nobayar");
            $i=1;
            $total = 0;
            while($dta=mysqli_fetch_assoc($spp)):
                ?>
                <tr>
                <td align="center"><?= $i ?></td>
                <td align="center"><?= $dta['nisn'] ?></td>
                <td align=""><?= $dta['nama_siswa'] ?></td>
                <td align=""><?= $dta['nobayar'] ?></td>
                <td align=""><?= $dta['bulan'] ?></td>
                <td align="right"><?= format_rupiah($dta['jumlah']) ?></td>
                <td align="center"><?= $dta['ket'] ?></td>
            </tr>
            <?php $i++; ?>
            <?php $total += $dta['jumlah']; ?>
            <?php endwhile; ?>
            <tr>
                <td colspan="7" align="right">TOTAL</td>
                <td align="right"><b><?= format_rupiah($total) ?></b></td>
            </tr>
            </table>
            <table width="100%">
                <tr>
                    <td></td>
                    <td width="200px">
                    <BR/>
                    <p>Tangerang , <?= date('d/m/y') ?> <br/>
                        Operator, 
                        <br/>
                        <br/>
                        <br/>
                <p>___________________________</p>
                </td>
            </tr>
            </table>
            </body>
            </html>

<?php
}else {
    header("location: login.php");
}
?>
