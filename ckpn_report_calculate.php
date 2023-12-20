<div style="margin-left: 20px; margin-right: 30px;">
    <table class="table  table-borderless" id="tableCkpn">
        <thead class="secondary-color text-center">
            <tr>
                <th style="text-align: left; background-color: #F7F7FC;">No.</th>
                <th style="text-align: left;background-color: #F7F7FC;">Collective/Individual</th>
                <th style="text-align: left;background-color: #F7F7FC;">Bucket Per Norek</th>
                <th style="text-align: left;background-color: #F7F7FC;">Count of Norek-nopin</th>
                <th style="text-align: left;background-color: #F7F7FC;">SUM of EAD</th>
                <th style="text-align: left;background-color: #F7F7FC;">SUM of EAD 2</th>
                <th style="text-align: left;background-color: #F7F7FC;">SUM of ECL UPSIDE</th>
                <th style="text-align: left;background-color: #F7F7FC;">SUM of ECL BASELINE</th>
                <th style="text-align: left;background-color: #F7F7FC;">SUM of ECL DOWNSIDE</th>
                <th style="text-align: left;background-color: #F7F7FC;">SUM of ECL ACC</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            // $query = mssql_query("SELECT noRek,noPin,realisasiDate,tenor FROM ckpn_index WHERE thbl='$thbl'"); 
            $query = mssql_query("SELECT *, SUM(eclAcc) AS sumeclAcc FROM ckpn_ecl WHERE thbl='$thbl' GROUP BY bucketPerNorek");  
            // $query = mssql_query("SELECT * FROM ckpn_index WHERE thbl='$thbl'");  
            while($data= mssql_fetch_assoc($query)){ ?>
            <tr>
            <td style="text-align: left;"><?php echo $no++; ?></td>
            <td style="text-align: left;"><?php echo $data['collIndi']; ?></td>
            <td style="text-align: left;"><?php echo $data['bucketPerNorek']; ?></td>
            <td style="text-align: left;"><?php echo $data['sumeclAcc']; ?></td>

            
            
            </tr>
            <?php } ?>
    </tbody>
    <br>
</table>
</div>