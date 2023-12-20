
<style>
* {
  box-sizing: border-box;
}

.row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  width: 50%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
tr:last-child td {
            border: none;
        }

/* Tata letak responsif - membuat dua kolom bertumpuk, bukan bersebelahan pada layar yang lebih kecil dari 600 piksel */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
  }
}
<?php
function komaKePersen($angka) {
    return $angka * 100 . '%';
}
?>
</style>
<div class="row">
  <div class="column">
<h5>Bucket Per Norek</h5>
    <table class="table  table-border" id="table1">
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
            WHERE thbl='$thbl'
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
            <td style="text-align: left;"><?php echo $data1['sumOsPokok']; ?></td>
            <td style="text-align: left;"><?php echo ROUND($data1['sumPersen'],2)."%"; ?></td>
            <td style="text-align: left;"><b><?php echo $sum5baris; ?></b></td>
            </tr>
            <?php } ?>
    </tbody>
    <tfoot>
    <td colspan="2" style="text-align: left;">Total</td>
    <td style="text-align: left;"><?= $totSumOsPokok ?></td>
    <td style="text-align: left;"><?= ROUND($totSumPersen,2)."%" ?></td>
    </tfoot>
    <br>
</table>
</div>
<div class="column">
<h5>Bucket Per Cif</h5>
    <table class="table  table-border" id="table2">
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
            WHERE thbl='$thbl'
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
            <td style="text-align: left;"><?php echo $data2['sumOsPokok']; ?></td>
            <td style="text-align: left;"><?php echo ROUND($data2['sumPersen'],2)."%"; ?></td>
            <td style="text-align: left;"><b><?php echo $sum5baris2; ?></b></td>
            </tr>
            <?php } ?>
    </tbody>
    <tfoot>
    <td colspan="2" style="text-align: left;">Total</td>
    <td style="text-align: left;"><?= $totalSumOsPokok ?></td>
    <td style="text-align: left;"><?= ROUND($totalSumPersen,2)."%" ?></td>
    </tfoot>
    <br>
</table>
</div>
</div>
<hr>
<div class="row">
<h5>ECL <?= $thbl ?></h5>
    <table class="table  table-border" id="table3">
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
            WHERE thbl='$thbl' 
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
<br>
<hr>
<div class="row">
<h5>Tujuan Pembiayaan : INVESTASI | ECL <?= $thbl ?></h5>
    <table class="table  table-border" id="table4">
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
            $query4 = mssql_query("SELECT bucketPerCif,count(noAccount) as countNorekNopin,
            SUM(EAD) as sumEad,
            sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl') * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePv), 
            sumEclAcc = SUM(eclAcc),totalUpside = (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl' AND jenisPembiayaan='INVESTASI') 
            FROM ckpn_ecl 
            WHERE thbl='$thbl' AND jenisPembiayaan='INVESTASI' 
            GROUP BY bucketPerCif ORDER BY bucketPerCif"); 
            while($data4= mssql_fetch_assoc($query4)){ 
                $totalAccount4 += $data4['countNorekNopin'];
                $totalSumEad4 += $data4['sumEad'];  
                $totalSumEadPersen4 += $data4['sumEADpersen']; 
                $totalSumEclUpsiden4 += $data4['sumEclUpside']; 
                $totalSumEclBaseline4 += $data4['sumEclBaseline']; 
                $totalSumEclDownside4 += $data4['sumEclDownside']; 
                $totalSumEclAcc4 += $data4['sumEclAcc']; 
                //$totalThdEas = '';
                $totalThdTotal4 += $data4['sumEclUpside']/$data4['totalUpside'];
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;"><?php echo $data4['bucketPerCif']; ?></td>
            <td style="text-align: left;"><?php echo $data4['countNorekNopin']; ?></td>
            <td style="text-align: left;"><?php echo number_format($data4['sumEad']); ?></td>
            <td style="text-align: left;"><?php echo ROUND($data4['sumEADpersen'],2)."%"; ?></td>
            <td style="text-align: left;"><?php echo number_format($data4['sumEclUpside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data4['sumEclBaseline']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data4['sumEclDownside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data4['sumEclAcc']); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data4['sumEclUpside']/$data4['sumEad'],4)); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data4['sumEclUpside']/$data4['totalUpside'],4)); ?></td>
            </tr>
            <?php } ?>
    </tbody>
    <tfoot style="background-color: #ADD8E6;">
    <tr>
    <td colspan="2" style="text-align: left;"><b>Sub Total</b></td>
    <td style="text-align: left;"><b><?= $totalAccount4 ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEad4) ?></b></td>
    <td style="text-align: left;"><b><?= ROUND($totalSumEadPersen4,2)."%" ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden4) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline4) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclDownside4) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclAcc4) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden4/$totalSumEad4,4)) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden4/$totalSumEclUpsiden4,4)) ?></b></td>
    </tr>
    <tr style="background-color: #ADD8E6;">
    <td colspan="2" style="text-align: left;"><b>Total Investasi</b></td>
    <td style="text-align: left;"><b><?= $totalAccount4 ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEad4) ?></b></td>
    <td style="text-align: left;"><b><?= ROUND($totalSumEadPersen4,2)."%" ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden4) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline4) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclDownside4) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclAcc4) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden4/$totalSumEad4,4)) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden4/$totalSumEclUpsiden4,4)) ?></b></td>
    </tr>
    </tfoot>
    <br>
</table>
</div>
<br>
<hr>
<div class="row">
<h5>Tujuan Pembiayaan : MULTIGUNA PEMBELIAN</h5>
    <table class="table  table-border" id="table5">
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
            $query5 = mssql_query("SELECT bucketPerCif,count(noAccount) as countNorekNopin,
            SUM(EAD) as sumEad,
            sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl') * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePv), sumEclAcc = SUM(eclAcc)
            ,totalUpside = (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl' AND jenisPembiayaan='MULTIGUNA')
            FROM ckpn_ecl 
            WHERE thbl='$thbl' AND jenisPembiayaan='MULTIGUNA' 
            GROUP BY bucketPerCif ORDER BY bucketPerCif"); 
            while($data5= mssql_fetch_assoc($query5)){ 
                $totalAccount5 += $data5['countNorekNopin'];
                $totalSumEad5 += $data5['sumEad'];  
                $totalSumEadPersen5 += $data5['sumEADpersen']; 
                $totalSumEclUpsiden5 += $data5['sumEclUpside']; 
                $totalSumEclBaseline5 += $data5['sumEclBaseline']; 
                $totalSumEclDownside5 += $data5['sumEclDownside']; 
                $totalSumEclAcc5 += $data5['sumEclAcc']; 
                //$totalThdEas = '';
                $totalThdTotal5 += $data5['sumEclUpside']/$data5['totalUpside'];
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;"><?php echo $data5['bucketPerCif']; ?></td>
            <td style="text-align: left;"><?php echo $data5['countNorekNopin']; ?></td>
            <td style="text-align: left;"><?php echo number_format($data5['sumEad']); ?></td>
            <td style="text-align: left;"><?php echo ROUND($data5['sumEADpersen'],2)."%"; ?></td>
            <td style="text-align: left;"><?php echo number_format($data5['sumEclUpside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data5['sumEclBaseline']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data5['sumEclDownside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data5['sumEclAcc']); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data5['sumEclUpside']/$data5['sumEad'],4)); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data5['sumEclUpside']/$data5['totalUpside'],4)); ?></td>
            </tr>
            <?php } ?>
    </tbody>
    <tfoot style="background-color: #ADD8E6;">
    <td colspan="2" style="text-align: left;"><b>Sub Total</b></td>
    <td style="text-align: left;"><b><?= $totalAccount5 ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEad5) ?></b></td>
    <td style="text-align: left;"><b><?= ROUND($totalSumEadPersen5,2)."%" ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden5) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline5) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclDownside5) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclAcc5) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden5/$totalSumEad5,4)) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden5/$totalSumEclUpsiden5,4)) ?></b></td>
    </tfoot>
    <br>
</table>
</div>
<br>
<hr>
<div class="row">
<h5>Tujuan Pembiayaan : MULTIGUNA FASILITAS</h5>
    <table class="table  table-border" id="table6">
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
            $query6 = mssql_query("SELECT bucketPerCif,count(noAccount) as countNorekNopin,
            SUM(EAD) as sumEad,
            sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl' ) * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePv), sumEclAcc = SUM(eclAcc)
            ,totalUpside = (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl'  AND jenisPembiayaan='MULTIGUNA FASILITAS DANA')
            FROM ckpn_ecl 
            WHERE thbl='$thbl' AND jenisPembiayaan='MULTIGUNA FASILITAS DANA' 
            GROUP BY bucketPerCif ORDER BY bucketPerCif"); 
            while($data6= mssql_fetch_assoc($query6)){ 
                $totalAccount6 += $data6['countNorekNopin'];
                $totalSumEad6 += $data6['sumEad'];  
                $totalSumEadPersen6 += $data6['sumEADpersen']; 
                $totalSumEclUpsiden6 += $data6['sumEclUpside']; 
                $totalSumEclBaseline6 += $data6['sumEclBaseline']; 
                $totalSumEclDownside6 += $data6['sumEclDownside']; 
                $totalSumEclAcc6 += $data6['sumEclAcc']; 
                //$totalThdEas = '';
                $totalThdTotal6 += $data6['sumEclUpside']/$data6['totalUpside'];
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;"><?php echo $data6['bucketPerCif']; ?></td>
            <td style="text-align: left;"><?php echo $data6['countNorekNopin']; ?></td>
            <td style="text-align: left;"><?php echo number_format($data6['sumEad']); ?></td>
            <td style="text-align: left;"><?php echo round($data6['sumEADpersen'],2)."%"; ?></td>
            <td style="text-align: left;"><?php echo number_format($data6['sumEclUpside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data6['sumEclBaseline']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data6['sumEclDownside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data6['sumEclAcc']); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data6['sumEclUpside']/$data6['sumEad'],4)); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data6['sumEclUpside']/$data6['totalUpside'],4)); ?></td>
            </tr>
            <?php } ?>
    </tbody>
    <tfoot style="background-color: #ADD8E6;">
    <tr>
    <td colspan="2" style="text-align: left;"><b>Sub Total</b></td>
    <td style="text-align: left;"><b><?= number_format($totalAccount6) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEad6) ?></b></td>
    <td style="text-align: left;"><b><?= round($totalSumEadPersen6,2)."%" ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden6) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline6) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclDownside6) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclAcc6) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden6/$totalSumEad6,4)) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden6/$totalSumEclUpsiden6,4)) ?></b></td>
    </tr>
    <tr style="background-color: #ADD8E6;">
    <td colspan="2" style="text-align: left;"><b>Total Multiguna</b></td>
    <td style="text-align: left;"><b><?= $totalAccount5+$totalAccount6 ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEad5+$totalSumEad6) ?></b></td>
    <td style="text-align: left;"><b><?= ROUND($totalSumEadPersen5+$totalSumEadPersen6,2)."%" ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden5+$totalSumEclUpsiden6) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline5+$totalSumEclBaseline6) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclDownside5+$totalSumEclDownside6) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclAcc5+$totalSumEclAcc6) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round(($totalSumEclUpsiden5+$totalSumEclUpsiden6)/($totalSumEad5+$totalSumEad6),4)) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round(($totalSumEclUpsiden5/$totalSumEclUpsiden5)/($totalSumEclUpsiden6/$totalSumEclUpsiden6),4)) ?></b></td>
    </tr>
    </tfoot>
    <br>
</table>
</div>
<br>
<hr>
<div class="row">
<h5>Tujuan Pembiayaan : MODAL KERJA</h5>
    <table class="table  table-border" id="table7">
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
            $query7 = mssql_query("SELECT bucketPerCif,count(noAccount) as countNorekNopin,
            SUM(EAD) as sumEad,
            sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl' ) * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePv), sumEclAcc = SUM(eclAcc)
            ,totalUpside = (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl' AND jenisPembiayaan='MODAL KERJA FASILITAS MODAL USAHA')
            FROM ckpn_ecl 
            WHERE thbl='$thbl' AND jenisPembiayaan='MODAL KERJA FASILITAS MODAL USAHA' 
            GROUP BY bucketPerCif ORDER BY bucketPerCif"); 
            while($data7= mssql_fetch_assoc($query7)){ 
                $totalAccount7 += $data7['countNorekNopin'];
                $totalSumEad7 += $data7['sumEad'];  
                $totalSumEadPersen7 += $data7['sumEADpersen']; 
                $totalSumEclUpsiden7 += $data7['sumEclUpside']; 
                $totalSumEclBaseline7 += $data7['sumEclBaseline']; 
                $totalSumEclDownside7 += $data7['sumEclDownside']; 
                $totalSumEclAcc7 += $data7['sumEclAcc']; 
                //$totalThdEas = '';
                $totalThdTotal7 += $data7['sumEclUpside']/$data7['totalUpside'];
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;"><?php echo $data7['bucketPerCif']; ?></td>
            <td style="text-align: left;"><?php echo $data7['countNorekNopin']; ?></td>
            <td style="text-align: left;"><?php echo number_format($data7['sumEad']); ?></td>
            <td style="text-align: left;"><?php echo round($data7['sumEADpersen'],2)."%"; ?></td>
            <td style="text-align: left;"><?php echo number_format($data7['sumEclUpside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data7['sumEclBaseline']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data7['sumEclDownside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data7['sumEclAcc']); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data7['sumEclUpside']/$data7['sumEad'],4)); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data7['sumEclUpside']/$data7['totalUpside'],4)); ?></td>
            </tr>
            <?php } ?>
    </tbody>
    <tfoot style="background-color: #ADD8E6;">
    <tr>
    <td colspan="2" style="text-align: left;"><b>Sub Total</b></td>
    <td style="text-align: left;"><b><?= $totalAccount7 ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEad7) ?></b></td>
    <td style="text-align: left;"><b><?= round($totalSumEadPersen7,2)."%" ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden7) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline7) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclDownside7) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclAcc7) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden7/$totalSumEad7,4)) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden7/$totalSumEclUpsiden7,4)) ?></b></td>
    </tr>
    <tr style="background-color: #ADD8E6;">
    <td colspan="2" style="text-align: left;"><b>Total Modal Kerja</b></td>
    <td style="text-align: left;"><b><?= $totalAccount7 ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEad7) ?></b></td>
    <td style="text-align: left;"><b><?= round($totalSumEadPersen7,2)."%" ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden7) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline7) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclDownside7) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclAcc7) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden7/$totalSumEad7,4)) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden7/$totalSumEclUpsiden7,4)) ?></b></td> 
    </tr>
    <hr>
    <?php
        $totAccount = $totalAccount7+$totalAccount6+$totalAccount5+$totalAccount4;
        $totSumEad = $totalSumEad7+$totalSumEad6+$totalSumEad5+$totalSumEad4;
        $totSumEadPersen = $totalSumEadPersen7+$totalSumEadPersen6+$totalSumEadPersen5+$totalSumEadPersen4;
        $totSumEclUpsiden = $totalSumEclUpsiden7+$totalSumEclUpsiden6+$totalSumEclUpsiden5+$totalSumEclUpsiden4;
        $totSumEclBaseline = $totalSumEclBaseline7+$totalSumEclBaseline6+$totalSumEclBaseline5+$totalSumEclBaseline4;
        $totSumEclDownside = $totalSumEclDownside7+$totalSumEclDownside6+$totalSumEclDownside5+$totalSumEclDownside4;
        $totSumEclAcc = $totalSumEclAcc7+$totalSumEclAcc6+$totalSumEclAcc5+$totalSumEclAcc4;
        $totEclUpside = $totSumEclUpsiden/$totSumEad;
    ?>
    <tr style="background-color: #ADD8E6;">
    <td colspan="2" style="text-align: left;"><b>Grand Total</b></td>
    <td style="text-align: left;"><b><?= $totAccount ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totSumEad) ?></b></td>
    <td style="text-align: left;"><b><?= round($totSumEadPersen,2)."%" ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totSumEclUpsiden) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totSumEclBaseline) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totSumEclDownside) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totSumEclAcc) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totEclUpside,4)) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden7/$totalSumEclUpsiden7,4)) ?></b></td> 
    </tr>
    </tfoot>
    <br>
</table>
</div>
<br>
<hr>
<div class="row">
<h5>BY CIF <?= $thbl ?></h5>
    <table class="table  table-border" id="table8">
        <thead class="secondary-color text-center">
            <tr>
                <th style="text-align: left; background-color: #F7F7FC;">No.</th>
                <th style="text-align: left;background-color: #F7F7FC;">Ind/Coll</th>
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
            $query8 = mssql_query("SELECT bucketPerCif, count(noAccount) as countNorekNopin,
            SUM(EAD) as sumEad, sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl') * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePv), sumEclAcc = SUM(eclAcc),
            totalUpside = (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl') 
            FROM ckpn_ecl 
            WHERE thbl='$thbl' AND collIndi='Collective'
            GROUP BY bucketPerCif ORDER BY bucketPerCif"); 
            while($data8= mssql_fetch_assoc($query8)){ 
                $totalAccount8 += $data8['countNorekNopin'];
                $totalSumEad8 += $data8['sumEad'];  
                $totalSumEadPersen8 += $data8['sumEADpersen']; 
                $totalSumEclUpsiden8 += $data8['sumEclUpside']; 
                $totalSumEclBaseline8 += $data8['sumEclBaseline']; 
                $totalSumEclDownside8 += $data8['sumEclDownside']; 
                $totalSumEclAcc8 += $data8['sumEclAcc']; 
                $totalThdEad8 +=  $data8['sumEclUpside']/$data8['sumEad'];
                $totalThdTotal8 += $data8['sumEclUpside']/$data8['totalUpside'];
                if($data8['bucketPerCif']=='<= 0'){
                    $bucket = 'Lancar';
                }else{
                    $bucket = $data8['bucketPerCif'];
                }
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;">Collective</td>
            <td style="text-align: left;"><?php echo $bucket; ?></td>
            <td style="text-align: left;"><?php echo $data8['countNorekNopin']; ?></td>
            <td style="text-align: left;"><?php echo number_format($data8['sumEad']); ?></td>
            <td style="text-align: left;"><?php echo ROUND($data8['sumEADpersen'],2)."%"; ?></td>
            <td style="text-align: left;"><?php echo number_format($data8['sumEclUpside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data8['sumEclBaseline']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data8['sumEclDownside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data8['sumEclAcc']); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data8['sumEclUpside']/$data8['sumEad'],4)); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data8['sumEclUpside']/$data8['totalUpside'],4)); ?></td>
            </tr>
            <?php } ?>
            </tbody>
            <tfoot style="background-color: #ADD8E6;">
                <td colspan="3" style="text-align: left;"><b>Collective Total</b></td>
                <td style="text-align: left;"><b><?= $totalAccount8 ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEad8) ?></b></td>
                <td style="text-align: left;"><b><?= ROUND($totalSumEadPersen8,2)."%" ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden8) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline8) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclDownside8) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclAcc8) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden8/$totalSumEad8,4)) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden8/$totalSumEclUpsiden8,4)) ?></b></td>
            </tfoot>
            </table>
            <table>
            <!-- INDIVIDUAL -->
            <tbody>
        <?php 
            $no = 1;
            $query9 = mssql_query("SELECT bucketPerCif, count(noAccount) as countNorekNopin,
            SUM(EAD) as sumEad, sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl') * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePv), sumEclAcc = SUM(eclAcc),
            totalUpside = (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl') 
            FROM ckpn_ecl 
            WHERE thbl='$thbl' AND collIndi='Individual'
            GROUP BY bucketPerCif ORDER BY bucketPerCif"); 
            while($data9= mssql_fetch_assoc($query9)){ 
                $totalAccount9 += $data9['countNorekNopin'];
                $totalSumEad9 += $data9['sumEad'];  
                $totalSumEadPersen9 += $data9['sumEADpersen']; 
                $totalSumEclUpsiden9 += $data9['sumEclUpside']; 
                $totalSumEclBaseline9 += $data9['sumEclBaseline']; 
                $totalSumEclDownside9 += $data9['sumEclDownside']; 
                $totalSumEclAcc9 += $data9['sumEclAcc']; 
                $totalThdEad9 +=  $data9['sumEclUpside']/$data9['sumEad'];
                $totalThdTotal9 += $data9['sumEclUpside']/$data9['totalUpside'];
                if($data9['bucketPerCif']=='<= 0'){
                    $bucket9 = 'Lancar';
                }else{
                    $bucket9 = $data9['bucketPerCif'];
                }
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;">Individual</td>
            <td style="text-align: left;"><?php echo $bucket9; ?></td>
            <td style="text-align: left;"><?php echo $data9['countNorekNopin']; ?></td>
            <td style="text-align: left;"><?php echo number_format($data9['sumEad']); ?></td>
            <td style="text-align: left;"><?php echo ROUND($data9['sumEADpersen'],2)."%"; ?></td>
            <td style="text-align: left;"><?php echo number_format($data9['sumEclUpside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data9['sumEclBaseline']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data9['sumEclDownside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data9['sumEclAcc']); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data9['sumEclUpside']/$data9['sumEad'],4)); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data9['sumEclUpside']/$data9['totalUpside'],4)); ?></td>
            </tr>
            <?php } ?>
            </tbody>
            <tfoot style="background-color: #ADD8E6;">
            <tr>
                <td colspan="3" style="text-align: left;"><b>Individual Total</b></td>
                <td style="text-align: left;"><b><?= $totalAccount9 ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEad9) ?></b></td>
                <td style="text-align: left;"><b><?= ROUND($totalSumEadPersen9,2)."%" ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden9) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline9) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclDownside9) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclAcc9) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden9/$totalSumEad9,4)) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden9/$totalSumEclUpsiden9,4)) ?></b></td>
            </tr>
            <tr>
                <?php
                    $totaccountcif = $totalAccount9+$totalAccount8;
                    $totSumEadCif = $totalSumEad9+$totalSumEad8;
                    $totSumEadPersenCif = $totalSumEadPersen9+$totalSumEadPersen8;
                    $totSumEclUpsideCif = $totalSumEclUpsiden9+$totalSumEclUpsiden8;
                    $totSumEclBaseCif = $totalSumEclBaseline9+$totalSumEclBaseline8;
                    $totSumEclDownCif = $totalSumEclDownside9+$totalSumEclDownside8;
                    $totSumEclAccCif = $totalSumEclAcc9+$totalSumEclAcc8;
                ?>
            <td colspan="3" style="text-align: left;"><b>Grand Total</b></td>
                <td style="text-align: left;"><b><?= $totaccountcif ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totSumEadCif) ?></b></td>
                <td style="text-align: left;"><b><?= ROUND($totSumEadPersenCif,2)."%" ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totSumEclUpsideCif) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totSumEclBaseCif) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totSumEclDownCif) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totSumEclAccCif) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totSumEclUpsideCif/$totSumEadCif,4)) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totSumEclUpsideCif/$totSumEclUpsideCif,4)) ?></b></td>
            </tr>
            </tfoot>
    <br>
</table>
</div>
<br>
<!-- BY NOREK -->
<div class="row">
<h5>BY NOREK <?= $thbl ?></h5>
    <table class="table  table-border" id="table9">
        <thead class="secondary-color text-center">
            <tr>
                <th style="text-align: left; background-color: #F7F7FC;">No.</th>
                <th style="text-align: left;background-color: #F7F7FC;">Ind/Coll</th>
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
            $query10 = mssql_query("SELECT bucketPerNorek, count(noAccount) as countNorekNopin,
            SUM(EAD) as sumEad, sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl') * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePv), sumEclAcc = SUM(eclAcc),
            totalUpside = (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl') 
            FROM ckpn_ecl 
            WHERE thbl='$thbl' AND collIndi='Collective'
            GROUP BY bucketPerNorek ORDER BY bucketPerNorek"); 
            
            while($data10= mssql_fetch_assoc($query10)){ 
                $totalAccount10 += $data10['countNorekNopin'];
                $totalSumEad10 += $data10['sumEad'];  
                $totalSumEadPersen10 += $data10['sumEADpersen']; 
                $totalSumEclUpsiden10 += $data10['sumEclUpside']; 
                $totalSumEclBaseline10 += $data10['sumEclBaseline']; 
                $totalSumEclDownside10 += $data10['sumEclDownside']; 
                $totalSumEclAcc10 += $data10['sumEclAcc']; 
                $totalThdEad8 +=  $data10['sumEclUpside']/$data10['sumEad'];
                $totalThdTotal8 += $data10['sumEclUpside']/$data10['totalUpside'];
                if($data10['bucketPerNorek']=='<= 0'){
                    $bucket10 = 'Lancar';
                }else{
                    $bucket10 = $data10['bucketPerNorek'];
                }
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;">Collective</td>
            <td style="text-align: left;"><?php echo $bucket10; ?></td>
            <td style="text-align: left;"><?php echo $data10['countNorekNopin']; ?></td>
            <td style="text-align: left;"><?php echo number_format($data10['sumEad']); ?></td>
            <td style="text-align: left;"><?php echo ROUND($data10['sumEADpersen'],2)."%"; ?></td>
            <td style="text-align: left;"><?php echo number_format($data10['sumEclUpside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data10['sumEclBaseline']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data10['sumEclDownside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data10['sumEclAcc']); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data10['sumEclUpside']/$data10['sumEad'],4)); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data10['sumEclUpside']/$data10['totalUpside'],4)); ?></td>
            </tr>
            <?php } ?>
            </tbody>
            <tfoot style="background-color: #ADD8E6;">
                <td colspan="3" style="text-align: left;"><b>Collective Total</b></td>
                <td style="text-align: left;"><b><?= $totalAccount10 ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEad10) ?></b></td>
                <td style="text-align: left;"><b><?= ROUND($totalSumEadPersen10,2)."%" ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden10) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline10) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclDownside10) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclAcc10) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden10/$totalSumEad10,4)) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden10/$totalSumEclUpsiden10,4)) ?></b></td>
            </tfoot>
            </table>
            <table>
            <!-- INDIVIDUAL -->
            <tbody>
        <?php 
            $no = 1;
            $query11 = mssql_query("SELECT bucketPerNorek, count(noAccount) as countNorekNopin,
            SUM(EAD) as sumEad, sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl') * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePv), sumEclAcc = SUM(eclAcc),
            totalUpside = (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl') 
            FROM ckpn_ecl 
            WHERE thbl='$thbl' AND collIndi='Individual'
            GROUP BY bucketPerNorek ORDER BY bucketPerNorek"); 
            while($data11= mssql_fetch_assoc($query11)){ 
                $totalAccount11 += $data11['countNorekNopin'];
                $totalSumEad11 += $data11['sumEad'];  
                $totalSumEadPersen11 += $data11['sumEADpersen']; 
                $totalSumEclUpsiden11 += $data11['sumEclUpside']; 
                $totalSumEclBaseline11 += $data11['sumEclBaseline']; 
                $totalSumEclDownside11 += $data11['sumEclDownside']; 
                $totalSumEclAcc11 += $data11['sumEclAcc']; 
                $totalThdEad11 +=  $data11['sumEclUpside']/$data11['sumEad'];
                $totalThdTotal11 += $data11['sumEclUpside']/$data11['totalUpside'];
                if($data11['bucketPerNorek']=='<= 0'){
                    $bucket11 = 'Lancar';
                }else{
                    $bucket11 = $data11['bucketPerNorek'];
                }
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;">Individual</td>
            <td style="text-align: left;"><?php echo $bucket11; ?></td>
            <td style="text-align: left;"><?php echo $data11['countNorekNopin']; ?></td>
            <td style="text-align: left;"><?php echo number_format($data11['sumEad']); ?></td>
            <td style="text-align: left;"><?php echo ROUND($data11['sumEADpersen'],2)."%"; ?></td>
            <td style="text-align: left;"><?php echo number_format($data11['sumEclUpside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data11['sumEclBaseline']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data11['sumEclDownside']); ?></td>
            <td style="text-align: left;"><?php echo number_format($data11['sumEclAcc']); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data11['sumEclUpside']/$data11['sumEad'],4)); ?></td>
            <td style="text-align: left;"><?php echo komaKePersen(round($data11['sumEclUpside']/$data11['totalUpside'],4)); ?></td>
            </tr>
            <?php } ?>
            </tbody>
            <tfoot style="background-color: #ADD8E6;">
            <tr>
                <td colspan="3" style="text-align: left;"><b>Individual Total</b></td>
                <td style="text-align: left;"><b><?= $totalAccount11 ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEad11) ?></b></td>
                <td style="text-align: left;"><b><?= ROUND($totalSumEadPersen11,2)."%" ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden11) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline11) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclDownside11) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totalSumEclAcc11) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden11/$totalSumEad11,4)) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden11/$totalSumEclUpsiden11,4)) ?></b></td>
            </tr>
            <tr>
                <?php
                    $totaccountnorek = $totalAccount11+$totalAccount10;
                    $totSumEadNorek = $totalSumEad11+$totalSumEad10;
                    $totSumEadPersenNorek = $totalSumEadPersen11+$totalSumEadPersen10;
                    $totSumEclUpsideNorek = $totalSumEclUpsiden11+$totalSumEclUpsiden10;
                    $totSumEclBaseNorek = $totalSumEclBaseline11+$totalSumEclBaseline10;
                    $totSumEclDownNorek = $totalSumEclDownside11+$totalSumEclDownside10;
                    $totSumEclAccNorek = $totalSumEclAcc11+$totalSumEclAcc10;
                ?>
            <td colspan="3" style="text-align: left;"><b>Grand Total</b></td>
                <td style="text-align: left;"><b><?= $totaccountnorek ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totSumEadNorek) ?></b></td>
                <td style="text-align: left;"><b><?= ROUND($totSumEadPersenNorek,2)."%" ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totSumEclUpsideNorek) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totSumEclBaseNorek) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totSumEclDownNorek) ?></b></td>
                <td style="text-align: left;"><b><?= number_format($totSumEclAccNorek) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totSumEclUpsideNorek/$totSumEadNorek,4)) ?></b></td>
                <td style="text-align: left;"><b><?= komaKePersen(round($totSumEclUpsideNorek/$totSumEclUpsideNorek,4)) ?></b></td>
            </tr>
            </tfoot>
    <br>
</table>
</div>