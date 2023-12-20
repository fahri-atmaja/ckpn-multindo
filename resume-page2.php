<div class="card" style="width: 18rem;">
  <!-- <img class="card-img-top" src="<?php echo hostname(); ?>/module/ckpn/asset/star.svg" alt="Card image cap"> -->
  <div class="card-body">
    <h5 class="card-title">Print Report 2</h5>
    <p class="card-text">Jika blank klik cancel, max screen kemudian klik kanan print.</p>
    <input type="button" class="button btn-primary" value="Print" onclick="PrintElem2()" />
  </div>
</div>
<hr>
<div id="mydiv2">
    <!-- LINK REL -->
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

<div class="row">
    <table class="table-sm table-bordered" id="table4">
        <thead class="secondary-color text-center">
            <tr>
                <th style="text-align: left; background-color: #F7F7FC;">Tujuan Pembiayaan</th>
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
            $query4 = mssql_query("SELECT 
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
                ELSE (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl' AND jenisPembiayaan='INVESTASI')
            END AS totalUpside
            FROM 
            ckpn_bucket a
            LEFT JOIN 
            ckpn_ecl b ON a.bucketPerCif = b.bucketPerCif AND b.thbl='$thbl' AND b.jenisPembiayaan='INVESTASI'
            GROUP BY 
            a.bucketPerCif ORDER BY a.bucketPerCif"); 


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
                $tujuan = 'INVESTASI';
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $tujuan; ?></td>
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
    
    <tr style="background-color: #ADD8E6;">
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
        <?php
            $query5 = mssql_query("SELECT 
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
                ELSE (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl' AND jenisPembiayaan='MULTIGUNA')
            END AS totalUpside
            FROM 
            ckpn_bucket a
            LEFT JOIN 
            ckpn_ecl b ON a.bucketPerCif = b.bucketPerCif AND b.thbl='$thbl' AND b.jenisPembiayaan='MULTIGUNA'
            GROUP BY 
            a.bucketPerCif ORDER BY a.bucketPerCif");
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
                $tujuan = 'MULTIGUNA';
                
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $tujuan; ?></td>
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
    <tr style="background-color: #ADD8E6;">
    <td colspan="2" style="text-align: left; background-color: #ADD8E6;"><b>Sub Total</b></td>
    <td style="text-align: left;"><b><?= $totalAccount5 ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEad5) ?></b></td>
    <td style="text-align: left;"><b><?= ROUND($totalSumEadPersen5,2)."%" ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclUpsiden5) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclBaseline5) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclDownside5) ?></b></td>
    <td style="text-align: left;"><b><?= number_format($totalSumEclAcc5) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden5/$totalSumEad5,4)) ?></b></td>
    <td style="text-align: left;"><b><?= komaKePersen(round($totalSumEclUpsiden5/$totalSumEclUpsiden5,4)) ?></b></td>
    </tr>
        <?php 
            $no = 1;
            $query6 = mssql_query("SELECT 
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
                ELSE (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl' AND jenisPembiayaan='MULTIGUNA FASILITAS DANA')
            END AS totalUpside
            FROM 
            ckpn_bucket a
            LEFT JOIN 
            ckpn_ecl b ON a.bucketPerCif = b.bucketPerCif AND b.thbl='$thbl' AND b.jenisPembiayaan='MULTIGUNA FASILITAS DANA'
            GROUP BY 
            a.bucketPerCif ORDER BY a.bucketPerCif"); 
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
                $tujuan6 = 'MULTIGUNA FASILITAS DANA';
                
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $tujuan6; ?></td>
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
    <tr style="background-color: #ADD8E6;">
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
        <?php 
            $query7 = mssql_query("SELECT 
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
                ELSE (SELECT SUM(eclUpsidePV) FROM ckpn_ecl WHERE thbl='$thbl' AND jenisPembiayaan='MODAL KERJA FASILITAS MODAL USAHA')
            END AS totalUpside
            FROM 
            ckpn_bucket a
            LEFT JOIN 
            ckpn_ecl b ON a.bucketPerCif = b.bucketPerCif AND b.thbl='$thbl' AND b.jenisPembiayaan='MODAL KERJA FASILITAS MODAL USAHA'
            GROUP BY 
            a.bucketPerCif ORDER BY a.bucketPerCif"); 
            
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
                $tujuan7 = 'MODAL KERJA';
                
            ?>
            <tr>
            <td style="text-align: left;"><?php echo $tujuan7; ?></td>
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
    
    <tr style="background-color: #ADD8E6;">
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
    </tbody>
</table>
</div>
</div>