<?php

function xirr($values, $dates, $guess = 0.1) {
    $x0 = $guess;
    $x1 = 0;
    $f = 0;
    $f1 = 0;
    $maxIteration = 100;
    $epsilon = 0.0000001;

    for ($i = 0; $i < $maxIteration; $i++) {
        $f = 0;
        $f1 = 0;
        for ($j = 0; $j < count($values); $j++) {
            $f += $values[$j] / pow(1 + $x0, (strtotime($dates[$j]) - strtotime($dates[0])) / (60 * 60 * 24 * 365.25));
            $f1 -= ($values[$j] * (strtotime($dates[$j]) - strtotime($dates[0]))) / (60 * 60 * 24 * 365.25 * pow(1 + $x0, (strtotime($dates[$j]) - strtotime($dates[0])) / (60 * 60 * 24 * 365.25 + 1)));
        }

        $x1 = $x0 - $f / $f1;

        if (abs($x1 - $x0) < $epsilon) {
            return $x1;
        }

        $x0 = $x1;
    }

    return null; // Jika konvergensi tidak tercapai dalam jumlah iterasi maksimum
}

?>
<?php
function roundExcel($nominal) {
    $roundFloor = floor($nominal);
    $selisih = $nominal - $roundFloor;

    if ($selisih < 0.49999999) {
        $hasilRound = $roundFloor;
    } else {
        $hasilRound = ceil($nominal);
    }

    return $hasilRound;
}
?>
<div style="margin-left: 20px; margin-right: 30px;">
    <table class="table  table-borderless" id="tableCkpnSelect">
        <thead class="secondary-color text-center">
            <tr>
                <th style="text-align: left; background-color: #F7F7FC;">No.</th>
                <th style="text-align: left; background-color: #F7F7FC;">No Account</th>
                <th style="text-align: left; background-color: #F7F7FC;">Realisasi Date</th>
                <th style="text-align: left; background-color: #F7F7FC;">Maturity Date</th>
                <th style="text-align: left;background-color: #F7F7FC;">Pokok Pinjaman</th>
                <th style="text-align: left;background-color: #F7F7FC;">Total AR</th>
                <th style="text-align: left;background-color: #F7F7FC;">Rumus</th>
                <th style="text-align: left;background-color: #F7F7FC;">EIR</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            // $query = mssql_query("exec buatLaporanCkpn '$thbl'");   
            $queryCkpn = mssql_query("SELECT * FROM ckpn_index WHERE thbl='$thbl'");  
            while($dataCkpn= mssql_fetch_assoc($queryCkpn)){ 
            $osPokok = $dataCkpn['pokokPinjaman'];
            $totalAR = $dataCkpn['totalAR'];
            $realisasiDate = date('Y-m-d', strtotime($dataCkpn['realisasiDate']));
            $maturityDate = date('Y-m-d', strtotime($dataCkpn['maturityDate']));
            $values=[$osPokok, $totalAR];
            $dates=[$realisasiDate,$maturityDate];
                ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;"><?php echo $dataCkpn['noRek'].$dataCkpn['noPin']; ?></td>
            <td style="text-align: left;"><?php echo $dataCkpn['realisasiDate']; ?></td>
            <td style="text-align: left;"><?php echo $dataCkpn['maturityDate']; ?></td>
            <td style="text-align: left;"><?php echo $dataCkpn['pokokPinjaman']; ?></td>
            <td style="text-align: left;"><?php echo $dataCkpn['totalAR']; ?></td>
            <td style="text-align: left;"><?php echo "XIRR([".$osPokok.",".$totalAR."],[".$realisasiDate.",".$maturityDate."])"; ?> </td>
            <td style="text-align: left;"><?php echo round(xirr($values,$dates)/12 * 100,2) . "%"; ?></td>
            </tr>
            <?php } ?>
    </tbody>
    <br>
</table>
</div>