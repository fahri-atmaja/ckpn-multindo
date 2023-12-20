<div class="card" style="width: 18rem;">
  <!-- <img class="card-img-top" src="<?php echo hostname(); ?>/module/ckpn/asset/star.svg" alt="Card image cap"> -->
  <div class="card-body">
    <h5 class="card-title">Print Report 1</h5>
    <p class="card-text">Jika blank klik cancel, max screen kemudian klik kanan print.</p>
    <input type="button" class="button btn-primary" value="Print" onclick="PrintElem()" />
  </div>
</div>
<hr>

<div id="mydiv1">
    <!-- link rell  -->
<link rel="stylesheet" href="<?php echo HOSTNAME(); ?>/assets/bootstrap-4.6.0/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo hostname(); ?>/assets/datatables-1.11.0/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo hostname(); ?>/assets/fontawesome-5.15.4/css/all.css">
    <link rel="stylesheet" href="<?php echo hostname(); ?>/assets/jquery-confirm/jquery-confirm.min.css">
    <link rel="stylesheet" href="<?php echo hostname(); ?>/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo hostname(); ?>/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo hostname(); ?>/module/rutinitas/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cooltipz-css@2.2.0/cooltipz.min.css" />
   
    <!-- SCRIPT -->
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/assets/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/assets/bootstrap-4.6.0/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/assets/bootstrap-4.6.0/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/assets/fontawesome-5.15.4/js/all.js"></script>
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/assets/datatables-1.11.0/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/assets/datatables-1.11.0/dataTables.bootstrap4.js"></script>
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/assets/jquery-loading-overlay-2.1.7/dist/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/js/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
    <style type='text/css'>
      @page toc { sheet-size: A4; }
      table {
        font-family: Tahoma;
        border-collapse: collapse;
        font-size: 12px;
        table-layout: fixed;
      }

      table td {
        border: .4px solid #000;
        padding: 8px 5px;
      }

      .strong {
        font-weight: bold;
      }

      #t_karyawan td{
        border: none;
        padding: 3px;
      }

      .border-bottom {
        border-bottom: .4px solid #000 !important;
      }
    </style>

<?php
function komaKePersen($angka) {
    return $angka * 100 . '%';
}
?>

<label style="align:center">PERHITUNGAN CKPN LAPORAN KEUANGAN BULANAN</label>
<div class="row">
  <div class="column">
<label>Bucket Per Norek</label>
    <table class="table-sm table-bordered" id="table1">
        <thead class="secondary-color text-center">
            <tr>
                <th style="text-align: left; background-color: #F7F7FC;">No.</th>
                <th style="text-align: left;background-color: #F7F7FC;">Bucket Per Norek</th>
                <th style="text-align: left;background-color: #F7F7FC;">SUM OS Pokok</th>
                <th colspan="2" style="text-align: left;background-color: #F7F7FC;">SUM persen</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $query1 = mssql_query("SELECT bucketPerNorek,sumOsPokok = SUM(osPokok), sumPersen = SUM(osPokok) / (SELECT SUM(osPokok) 
            FROM ckpn_ecl WHERE thbl='$thbl') * 100, sumBaris5 = (SELECT SUM(osPokok) / (SELECT SUM(osPokok) 
            FROM ckpn_ecl WHERE thbl='$thbl') * 100
            FROM ckpn_ecl WHERE thbl='$thbl' AND bucketPerNorek='091 - 120')+(SELECT SUM(osPokok) / (SELECT SUM(osPokok) 
            FROM ckpn_ecl WHERE thbl='$thbl') * 100
            FROM ckpn_ecl WHERE thbl='$thbl' AND bucketPerNorek='121 - 150')+(SELECT SUM(osPokok) / (SELECT SUM(osPokok) 
            FROM ckpn_ecl WHERE thbl='$thbl') * 100
            FROM ckpn_ecl WHERE thbl='$thbl' AND bucketPerNorek='151 - 180')+(SELECT SUM(osPokok) / (SELECT SUM(osPokok) 
            FROM ckpn_ecl WHERE thbl='$thbl') * 100
            FROM ckpn_ecl WHERE thbl='$thbl' AND bucketPerNorek='180 UP')
            FROM ckpn_ecl 
            WHERE thbl='$thbl' AND bucketPerNorek!='Close'
            GROUP BY bucketPerNorek ORDER BY bucketPerNorek"); 
            while($data1= mssql_fetch_assoc($query1)){ 
                $totSumOsPokok += $data1['sumOsPokok'];
                $totSumPersen += $data1['sumPersen']; 
                if($no==5){
                    $sum5baris=ROUND($data1['sumBaris5'],2)."%";
                }else{
                    $sum5baris='';
                };
                ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;"><?php echo $data1['bucketPerNorek']; ?></td>
            <td style="text-align: left;"><?php echo number_format($data1['sumOsPokok']); ?></td>
            <td style="text-align: left;"><?php echo ROUND($data1['sumPersen'],2)."%"; ?></td>
            <td style="text-align: left;"><b><?php echo $sum5baris; ?></b></td>
            </tr>
            <?php } ?>
    </tbody>
    <tfoot>
    <td colspan="2" style="text-align: left;">Total</td>
    <td style="text-align: left;"><?= number_format($totSumOsPokok) ?></td>
    <td style="text-align: left;"><?= ROUND($totSumPersen,2)."%" ?></td>
    </tfoot>
    <br>
</table>
</div>
<div class="column">
<label>Bucket Per Cif</label>
    <table class="table-sm table-bordered" id="table2">
        <thead class="secondary-color text-center">
            <tr>
                <th style="text-align: left; background-color: #F7F7FC;">No.</th>
                <th style="text-align: left;background-color: #F7F7FC;">Bucket Per Cif</th>
                <th style="text-align: left;background-color: #F7F7FC;">SUM OS Pokok</th>
                <th colspan="2" style="text-align: left;background-color: #F7F7FC;">SUM persen</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $query2 = mssql_query("SELECT bucketPerCif,sumOsPokok = SUM(osPokok), 
            sumPersen = SUM(osPokok) / (SELECT SUM(osPokok) FROM ckpn_ecl WHERE thbl='$thbl') * 100
            ,sumBaris5 = (SELECT SUM(osPokok) / (SELECT SUM(osPokok) 
            FROM ckpn_ecl WHERE thbl='$thbl') * 100
            FROM ckpn_ecl WHERE thbl='$thbl' AND bucketPerCif='091 - 120')+(SELECT SUM(osPokok) / (SELECT SUM(osPokok) 
            FROM ckpn_ecl WHERE thbl='$thbl') * 100
            FROM ckpn_ecl WHERE thbl='$thbl' AND bucketPerCif='121 - 150')+(SELECT SUM(osPokok) / (SELECT SUM(osPokok) 
            FROM ckpn_ecl WHERE thbl='$thbl') * 100
            FROM ckpn_ecl WHERE thbl='$thbl' AND bucketPerCif='151 - 180')+(SELECT SUM(osPokok) / (SELECT SUM(osPokok) 
            FROM ckpn_ecl WHERE thbl='$thbl') * 100
            FROM ckpn_ecl WHERE thbl='$thbl' AND bucketPerCif='180 UP')
            FROM ckpn_ecl 
            WHERE thbl='$thbl' AND bucketPerCif!='Close'
            GROUP BY bucketPerCif ORDER BY bucketPerCif"); 
            while($data2= mssql_fetch_assoc($query2)){ 
                $totalSumOsPokok += $data2['sumOsPokok'];
                $totalSumPersen += $data2['sumPersen']; 
                if($no==5){
                    $sum5baris2=ROUND($data2['sumBaris5'],2)."%";
                }else{
                    $sum5baris2='';
                };   
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;"><?php echo $data2['bucketPerCif']; ?></td>
            <td style="text-align: left;"><?php echo number_format($data2['sumOsPokok']); ?></td>
            <td style="text-align: left;"><?php echo ROUND($data2['sumPersen'],2)."%"; ?></td>
            <td style="text-align: left;"><b><?php echo $sum5baris2; ?></b></td>
            </tr>
            <?php } ?>
    </tbody>
    <tfoot>
    <td colspan="2" style="text-align: left;">Total</td>
    <td style="text-align: left;"><?= number_format($totalSumOsPokok); ?></td>
    <td style="text-align: left;"><?= ROUND($totalSumPersen,2)."%" ?></td>
    </tfoot>
</table>
</div>
</div>
<br>
<div class="row">
    <table class="table-sm table-bordered" id="table3">
        <thead class="secondary-color text-center">
            <tr>
                <th style="text-align: left; background-color: #F7F7FC;">No.</th>
                <th style="text-align: left;background-color: #F7F7FC;">Bucket Cif</th>
                <th style="text-align: left;background-color: #F7F7FC;">Account</th>
                <th style="text-align: left;background-color: #F7F7FC;">SUM of EAD</th>
                <th style="text-align: left;background-color: #F7F7FC;">EAD</th>
                <th style="text-align: left;background-color: #F7F7FC;">UPSIDE</th>
                <th style="text-align: left;background-color: #F7F7FC;">BASELINE</th>
                <th style="text-align: left;background-color: #F7F7FC;">DOWNSIDE</th>
                <th style="text-align: left;background-color: #F7F7FC;">ECL ADJUST</th>
                <th style="text-align: left;background-color: #F7F7FC;">thd ead</th>
                <th style="text-align: left;background-color: #F7F7FC;">thd total</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $no = 1;
            $query3 = mssql_query("SELECT bucketPerCif,count(noAccount) as countNorekNopin,
            SUM(EAD) as sumEad,
            sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl') * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePV), sumEclAcc = SUM(eclAcc),
            thdEas='',thdTotal='',totalUpside = (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl') 
            FROM ckpn_ecl 
            WHERE thbl='$thbl' AND bucketPerCif!='Close'
            GROUP BY bucketPerCif ORDER BY bucketPerCif"); 
            while($data3= mssql_fetch_assoc($query3)){ 
                $totalAccount += $data3['countNorekNopin'];
                $totalSumEad += $data3['sumEad'];  
                $totalSumEadPersen += $data3['sumEADpersen']; 
                $totalSumEclUpsiden += $data3['sumEclUpside']; 
                $totalSumEclBaseline += $data3['sumEclBaseline']; 
                $totalSumEclDownside += $data3['sumEclDownside']; 
                $totalSumEclAcc += $data3['sumEclAcc']; 
                $totalThdEad +=  $data3['sumEclUpside']/$data3['sumEad'];
                $totalThdTotal += $data3['sumEclUpside']/$data3['totalUpside'];
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;"><?php echo $data3['bucketPerCif']; ?></td>
            <td style="text-align: left;"><?php echo $data3['countNorekNopin']; ?></td>
            <td style="text-align: left;"><?php echo number_format($data3['sumEad']); ?></td>
            <td style="text-align: left;"><?php echo ROUND($data3['sumEADpersen'],2)."%"; ?></td>
            <td style="text-align: left;"><?php echo number_format($data3['sumEclUpside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data3['sumEclBaseline']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data3['sumEclDownside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data3['sumEclAcc']); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data3['sumEclUpside']/$data3['sumEad'],4)); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data3['sumEclUpside']/$data3['totalUpside'],4)); ?></td>
            </tr>
            <?php } ?>
            </tbody>
            <tfoot style="background-color: #ADD8E6;">
                <td colspan="2" style="text-align: left;"><b>Grand Total</b></td>
                <td style="text-align: left;"><b><?= $totalAccount ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEad) ?></b></td>
                <td style="text-align: left;"><b><?= ROUND($totalSumEadPersen,2)."%" ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclDownside) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclAcc) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden/$totalSumEad,4)) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden/$totalSumEclUpsiden,4)) ?></b></td>
            </tfoot>
    <br>
</table>
</div>
</div>