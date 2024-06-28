<?php
session_start();
if(isset($_SESSION['admin'])){
    include 'koneksi.php';
    include 'funcion_rupiah.php';
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Slip Pembayaran SPP</title>
        <style>
            body{
                font-family: arial;
            }
            
            table{
                border-collapse: collapse;
            }
        </style>
    </head>
    <body onload="window.print();">
        <h3>SD ISLAM TERPADU AL IZZAH<b><br/>LAPORAN PEMBAYARAN SPP</b></h3>
        <br/>
        <hr/>
        <?php
        $nisn = $_GET['nisn'];
        $siswa = mysqli_query($conn, "SELECT siswa.*, angkatan.*, kelas.* FROM
        siswa,angkatan,kelas WHERE siswa.id_angkatan = angkatan.id_angkatan AND
        siswa.id_kelas = kelas.id_kelas AND siswa.nisn = '$nisn'");
        $sw = mysqli_fetch_assoc($siswa);

        // Check if $sw is not null before accessing its keys
        if($sw !== null) {
            $idspp = $_GET['id'];
            ?>
            <table>
                <tr>
                    <td>Nama siswa </td>
                    <td>:</td>
                    <td> <?= $sw['nama_siswa'] ?></td>
                </tr>
                <tr>
                    <td>NISN </td>
                    <td>:</td>
                    <td> <?= $sw['nisn'] ?></td>
                </tr>
                <tr>
                    <td>kelas </td>
                    <td>:</td>
                    <td> <?= $sw['nama_kelas'] ?></td>
                </tr>
                <tr>
                    <td>angkatan </td>
                    <td>:</td>
                    <td> <?= $sw['nama_angkatan'] ?></td>
                </tr>
            </table>
            <hr>
            <table border="1" cellpadding="4" width="100%">
                <tr>
                    <th>No</th>
                    <th>No. BAYAR</th>
                    <th>PEMBAYARAN BULAN</th>
                    <th>JUMLAH</th>
                    <th>KETERANGAN</th>
                </tr>
                <?php
                $spp = mysqli_query($conn, "SELECT siswa.*, pembayaran.* FROM 
                siswa,pembayaran WHERE pembayaran.id_siswa = siswa.id_siswa AND
                pembayaran.idspp = '$idspp' ORDER BY nobayar ASC");
                $i=1;
                $total=0;
                while($dta=mysqli_fetch_assoc($spp)) :
                ?>
                <tr>
                    <td align="center"><?= $i ?></td>
                    <td align=""><?= $dta['nobayar'] ?></td>
                    <td align=""><?= $dta['bulan'] ?></td>
                    <td align="right"><?= format_rupiah($dta['jumlah']) ?></td>
                    <td align="center"><?= $dta['ket'] ?></td>
                </tr>
                <?php 
                $i++; 
                $total += intval(str_replace(['Rp', '.'], '', format_rupiah($dta['jumlah'])));


                endwhile; ?>
                <tr>
                    <td colspan="4" align="right">TOTAL</td>
                    <td align="right"><?= format_rupiah($total) ?></br></td>
                </tr>
            </table>

            <table width="100%">
                <tr>
                    <td></td>
                    <td width="200px">
                        <br/>
                        <p>Tangerang , <?= date('d/m/y') ?> <br/>
                            Operator,
                        <br/>
                        <br/>
                        <br/>
                        <p>____________________________</p>
                    </td>
                </tr>
            </table>
        <?php
        } else {
            echo "Data siswa tidak ditemukan.";
        }
        ?>
    </body>
    </html>
    <?php
}else{
    header("location: login.php");
}
?>
