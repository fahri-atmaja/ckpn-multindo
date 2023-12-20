<div class="card" style="width: 18rem;">
  <!-- <img class="card-img-top" src="<?php echo hostname(); ?>/module/ckpn/asset/star.svg" alt="Card image cap"> -->
  <div class="card-body">
    <h5 class="card-title">Print Report 3</h5>
    <p class="card-text">Jika blank klik cancel, max screen kemudian klik kanan print.</p>
    <input type="button" class="button btn-primary" value="Print" onclick="PrintElem3()" />
  </div>
</div>
<hr>
<div id="mydiv3">
<link rel="stylesheet" href="<?php echo HOSTNAME(); ?>/assets/bootstrap-4.6.0/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo hostname(); ?>/assets/datatables-1.11.0/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo hostname(); ?>/assets/fontawesome-5.15.4/css/all.css">
    <link rel="stylesheet" href="<?php echo hostname(); ?>/assets/jquery-confirm/jquery-confirm.min.css">
    <link rel="stylesheet" href="<?php echo hostname(); ?>/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo hostname(); ?>/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo hostname(); ?>/module/rutinitas/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cooltipz-css@2.2.0/cooltipz.min.css" />
    <link rel="stylesheet" href="<?php echo HOSTNAME(); ?>/assets/clock_picker/clockpicker.css">
    <link rel="stylesheet" href="<?php echo HOSTNAME(); ?>/assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">
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
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/assets/clock_picker/clockpicker.js"></script>
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
        padding: 8px 6px;
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
<label>BY CIF <?= $thbl ?></label>
<div class="row">

    <table class="table-sm table-bordered" id="table8">
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
            $query8 = mssql_query("SELECT 
            a.bucketPerCif, 
            SUM(CASE 
                    WHEN b.noAccount IS NOT NULL THEN 1
                    ELSE 0
                END) AS countNorekNopin,
                SUM(EAD) as sumEad,
            sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl') * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePv), sumEclAcc = SUM(eclAcc),
            CASE 
                WHEN SUM(CASE 
                            WHEN b.noAccount IS NOT NULL THEN 1
                            ELSE 0
                        END) = 0 THEN 0
                ELSE (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl' AND collIndi='Collective')
            END AS totalUpside
            FROM 
            ckpn_bucket a
            LEFT JOIN 
            ckpn_ecl b ON a.bucketPerCif = b.bucketPerCif AND b.thbl='$thbl' AND b.collIndi='Collective'
            GROUP BY 
            a.bucketPerCif ORDER BY a.bucketPerCif"); 
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
            <tr style="background-color: #ADD8E6;">
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
            </tr>
            <!-- INDIVIDUAL -->
        <?php 
            $no = 1;
            $query9 = mssql_query("SELECT 
            a.bucketPerCif, 
            SUM(CASE 
                    WHEN b.noAccount IS NOT NULL THEN 1
                    ELSE 0
                END) AS countNorekNopin,
                SUM(EAD) as sumEad,
            sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl') * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePv), sumEclAcc = SUM(eclAcc),
            CASE 
                WHEN SUM(CASE 
                            WHEN b.noAccount IS NOT NULL THEN 1
                            ELSE 0
                        END) = 0 THEN 0
                ELSE (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl' AND collIndi='Individual')
            END AS totalUpside
            FROM 
            ckpn_bucket a
            LEFT JOIN 
            ckpn_ecl b ON a.bucketPerCif = b.bucketPerCif AND b.thbl='$thbl' AND b.collIndi='Individual'
            GROUP BY 
            a.bucketPerCif ORDER BY a.bucketPerCif"); 
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
            
            <tr style="background-color: #ADD8E6;">
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
            </tbody>
</table>
</div>
<br>
<!-- BY NOREK -->
<label>BY NOREK <?= $thbl ?></label>
<div class="row">

    <table class="table-sm table-bordered" id="table9">
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
            $query10 = mssql_query("SELECT 
            a.bucketPerCif, 
            SUM(CASE 
                    WHEN b.noAccount IS NOT NULL THEN 1
                    ELSE 0
                END) AS countNorekNopin,
                SUM(EAD) as sumEad,
            sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl') * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePv), sumEclAcc = SUM(eclAcc),
            CASE 
                WHEN SUM(CASE 
                            WHEN b.noAccount IS NOT NULL THEN 1
                            ELSE 0
                        END) = 0 THEN 0
                ELSE (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl' AND collIndi='Collective')
            END AS totalUpside
            FROM 
            ckpn_bucket a
            LEFT JOIN 
            ckpn_ecl b ON a.bucketPerCif = b.bucketPerNorek AND b.thbl='$thbl' AND b.collIndi='Collective'
            GROUP BY 
            a.bucketPerCif ORDER BY a.bucketPerCif");
            
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
                if($data10['bucketPerCif']=='<= 0'){
                    $bucket10 = 'Lancar';
                }else{
                    $bucket10 = $data10['bucketPerCif'];
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
            
            <tr style="background-color: #ADD8E6;">
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
            </tr>
            <!-- </tbody> -->
            <!-- </table><br> -->
            <!-- <hr> -->
            <!-- <table class="table-sm table-bordered" id="table10"> -->
            <!-- INDIVIDUAL -->
            <!-- <tbody> -->
        <?php 
            $no = 1;
            $query11 = mssql_query("SELECT 
            a.bucketPerCif, 
            SUM(CASE 
                    WHEN b.noAccount IS NOT NULL THEN 1
                    ELSE 0
                END) AS countNorekNopin,
                SUM(EAD) as sumEad,
            sumEADpersen=SUM(EAD) / (SELECT SUM(EAD) FROM ckpn_ecl WHERE thbl='$thbl') * 100,
            sumEclUpside = SUM(eclUpsidePV), sumEclBaseline = SUM(eclFix), sumEclDownside = SUM(eclBottomsidePv), sumEclAcc = SUM(eclAcc),
            CASE 
                WHEN SUM(CASE 
                            WHEN b.noAccount IS NOT NULL THEN 1
                            ELSE 0
                        END) = 0 THEN 0
                ELSE (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl' AND collIndi='Individual')
            END AS totalUpside
            FROM 
            ckpn_bucket a
            LEFT JOIN 
            ckpn_ecl b ON a.bucketPerCif = b.bucketPerNorek AND b.thbl='$thbl' AND b.collIndi='Individual'
            GROUP BY 
            a.bucketPerCif ORDER BY a.bucketPerCif");
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
                if($data11['bucketPerCif']=='<= 0'){
                    $bucket11 = 'Lancar';
                }else{
                    $bucket11 = $data11['bucketPerCif'];
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
            
            <tr style="background-color: #ADD8E6;">
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
            </tbody>
    <br>
</table>
</div>
</div>