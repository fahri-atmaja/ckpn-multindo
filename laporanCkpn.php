<?php
include "../../../include/fungsi.php";
include "../../../include/dbconfig.php";

$nik = $_SESSION['nik'];
$thbl = $_GET['thbl'];

function konversi_tahun_bulan($tahun_bulan) {
    $tahun = substr($tahun_bulan, 0, 4);
    $bulan = substr($tahun_bulan, 4);

    $daftar_bulan = array(
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    $bulan_indonesia = $daftar_bulan[(int)$bulan - 1]; // Indeks dimulai dari 0

    return $bulan_indonesia . ' ' . $tahun;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>.: MultindoKu Web - <?php echo $field['title'] ?> :.</title>
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
    <script type="text/javascript" src="<?php echo hostname(); ?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
</head>
<style>
    .btn-more {
        border-radius: 0px;
    }

    .container-top {
        height: 140px;
    }

    .container-bottom {
        margin-top: 130px;
    }

    .my-wrapper {
        width: 100%;
        margin: 0 auto;
        padding-top: 20px;
    }



    .my-inner1 {
        /* margin-left: 820px; */
        float: right;
        display: inline-block;
        vertical-align: middle;
    }

    .my-inner2 {
        margin: 0 20px;
        float: right;
        display: inline-block;
        vertical-align: top;
    }

    .custom-select-sm {
        height: 39px;
    }
    .loader {
    text-align: center;
}

.loading-bar {
    display: inline-block;
    width: 150px;
    height: 20px;
    background-color: #ccc;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
}

.loading-bar div {
    position: absolute;
    left: 0;
    height: 100%;
    transition: width 0.5s;
}

.loading-text {
    margin-top: 10px;
    font-size: 18px;
}
</style>
<script type="text/javascript">

function PrintElem() {
    Popup1($('#mydiv1').html());
}
function Popup1(data) {
    var mywindow = window.open('', 'REPORT 1', 'height=400,width=600');
    mywindow.document.write('<html><head><title>my div</title>');
    mywindow.document.write("<link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css\" type=\"text/css\" media=\"print\" />");
    mywindow.document.write("<link rel=\"stylesheet\" href=\"assets/datatables-1.11.0/dataTables.bootstrap4.css\" type=\"text/css\"  />");
    mywindow.document.write("<link rel=\"stylesheet\" href=\"css/select2.min.css\" type=\"text/css\"  />");
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.print();
    //mywindow.close();

    return true;
}
function PrintElem2() {
    Popup2($('#mydiv2').html());
}
function Popup2(data) {
    var mywindow = window.open('', 'REPORT 2', 'height=400,width=600');
    mywindow.document.write('<html><head><title>my div</title>');
    mywindow.document.write("<link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css\" type=\"text/css\" media=\"print\" />");
    mywindow.document.write("<link rel=\"stylesheet\" href=\"assets/datatables-1.11.0/dataTables.bootstrap4.css\" type=\"text/css\"  />");
    mywindow.document.write("<link rel=\"stylesheet\" href=\"css/select2.min.css\" type=\"text/css\"  />");
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.print();
    //mywindow.close();

    return true;
}
function PrintElem3() {
    Popup2($('#mydiv3').html());
}
function Popup3(data) {
    var mywindow = window.open('', 'REPORT 3', 'height=400,width=600');
    mywindow.document.write('<html><head><title>my div</title>');
    mywindow.document.write("<link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css\" type=\"text/css\" media=\"print\" />");
    mywindow.document.write("<link rel=\"stylesheet\" href=\"assets/datatables-1.11.0/dataTables.bootstrap4.css\" type=\"text/css\"  />");
    mywindow.document.write("<link rel=\"stylesheet\" href=\"css/select2.min.css\" type=\"text/css\"  />");
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.print();
    //mywindow.close();

    return true;
}
</script>
<body>
<div class="loader">
        <div class="loading-bar"></div>
        <div class="loading-text" id="loadingText">Loading...</div>
    </div>
    <div class="container-fluid">
    <div class="filter-wrapper d-flex" style="margin-top: 20px;">
            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                <div class="filter-title d-flex">
                    <div class="title">
                        <h5>Buat Laporan CKPN</h5>
                    </div>
                </div>
            </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light ">

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <button class="btn btn-select pilih" id="harian" name="harian">
                            <b style="font-size: 1.2vw;"> PAGE 1 </b>
                        </button>
                        <hr class="hrbottom" id="hr_harian">
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-select" id="mingguan" name="mingguan">
                            <b style="font-size: 1.2vw;"> PAGE 2 </b>
                        </button>
                        <hr class="hrbottom hide" id="hr_mingguan">
                    </li>
                    <li class="nav-item">

                        <button class="btn btn-select" id="bulanan" name="bulanan">
                            <b style="font-size: 1.2vw;"> PAGE 3 </b>
                        </button>
                        <hr class="hrbottom hide" id="hr_bulanan">

                    </li>
                    <!-- <li class="nav-item">

                        <button class="btn btn-select" id="tahunan" name="tahunan">
                            <b style="font-size: 1.2vw;"> Tahunan </b>
                        </button>
                        <hr class="hrbottom hide" id="hr_tahunan">

                    </li>
                    <li class="nav-item">

                        <button class="btn btn-select" id="target_individu" name="target_individu">
                            <b style="font-size: 1.2vw;"> Target Individu </b>
                        </button>
                        <hr class="hrbottom hide" id="hr_individu">

                    </li> -->


                </ul>
            </div>
        </nav>
        <hr>
        <?php
            $halaman = $_GET['halaman'];
            switch ($halaman) {
                case 'page1':
                    include("resume-page1.php");
                break;
                case 'page2':
                    include("resume-page2.php");
                break;
                case 'page3':
                    include("resume-page3.php");
                break;
            }
        ?>
        <div class="show" id="table_harian">
            <?php //include("ckpn_ecl.php"); ?>
            <?php include("resume-page1.php"); ?>
            <?php //include("ckpn_index_select.php"); ?>
        </div>
        <div class="hide" id="table_mingguan">
            <?php include("resume-page2.php"); ?>
        </div>
        <div class="hide" id="table_bulanan">
            <?php include("resume-page3.php"); ?>
        </div>
         <div class="hide" id="table_tahunan">
            <?php //include("pekerjaan_tahunan.php"); ?>
        </div>
        <div class="hide" id="table_individu">
            <?php //include("pekerjaan_individu.php"); ?>
        </div> 
<div>
<script>
// $(document).ready(function() {

//     tableCkpn = $('#tableCkpn').DataTable(); //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
// $('#searchAll').keyup(function() {
//     tableCkpn.search($(this).val()).draw();
// })
// })
$(document).ready(function() {
    tableCkpn = $('#tableCkpn').DataTable();

    $('#searchAll').keyup(function() {
        tableCkpn.search($(this).val()).draw();
    })
});
$(document).ready(function() {
    tableCkpnSelect = $('#tableCkpnSelect').DataTable({
        "pageLength": -1 // Menampilkan semua data dalam satu halaman
    });

    $('#searchAll').keyup(function() {
        tableCkpnSelect.search($(this).val()).draw();
    })
});
 $(document).ready(function() {


            //harian
            $("button[name ='harian']").click(function(e) {
                e.preventDefault();
                $('#mingguan').removeClass('pilih');
                $('#bulanan').removeClass('pilih');
                $('#tahunan').removeClass('pilih');
                $('#target_individu').removeClass('pilih');

                $('#hr_mingguan').addClass('hide');
                $('#hr_tahunan').addClass('hide');
                $('#hr_bulanan').addClass('hide');
                $('#hr_individu').addClass('hide');

                $('#hr_harian').removeClass('hide');


                $(this).addClass('pilih');

                $('#table_harian').removeClass('hide').addClass('row');

                $('#table_mingguan').addClass('hide');
                $('#table_bulanan').addClass('hide');
                $('#table_tahunan').addClass('hide');
                $('#table_individu').addClass('hide');
            })
            //mingguan
            $("button[name ='mingguan']").click(function(e) {
                e.preventDefault();
                $('#harian').removeClass('pilih');
                $('#bulanan').removeClass('pilih');
                $('#tahunan').removeClass('pilih');
                $('#target_individu').removeClass('pilih');

                $('#hr_harian').addClass('hide');
                $('#hr_tahunan').addClass('hide');
                $('#hr_bulanan').addClass('hide');
                $('#hr_individu').addClass('hide');

                $('#hr_mingguan').removeClass('hide');


                $(this).addClass('pilih');

                $('#table_mingguan').removeClass('hide').addClass('row');

                $('#table_harian').addClass('hide');
                $('#table_bulanan').addClass('hide');
                $('#table_tahunan').addClass('hide');
                $('#table_individu').addClass('hide');
            })
            //bulanan
            $("button[name ='bulanan']").click(function(e) {
                e.preventDefault();
                $('#harian').removeClass('pilih');
                $('#mingguan').removeClass('pilih');
                $('#tahunan').removeClass('pilih');
                $('#target_individu').removeClass('pilih');

                $('#hr_harian').addClass('hide');
                $('#hr_tahunan').addClass('hide');
                $('#hr_mingguan').addClass('hide');
                $('#hr_individu').addClass('hide');

                $('#hr_bulanan').removeClass('hide');


                $(this).addClass('pilih');

                $('#table_bulanan').removeClass('hide').addClass('row');

                $('#table_mingguan').addClass('hide');
                $('#table_harian').addClass('hide');
                $('#table_tahunan').addClass('hide');
                $('#table_individu').addClass('hide');
            })

            //tahunan
            $("button[name ='tahunan']").click(function(e) {
                e.preventDefault();
                $('#harian').removeClass('pilih');
                $('#bulanan').removeClass('pilih');
                $('#mingguan').removeClass('pilih');
                $('#target_individu').removeClass('pilih');

                $('#hr_harian').addClass('hide');
                $('#hr_mingguan').addClass('hide');
                $('#hr_bulanan').addClass('hide');
                $('#hr_individu').addClass('hide');

                $('#hr_tahunan').removeClass('hide');


                $(this).addClass('pilih');

                $('#table_tahunan').removeClass('hide').addClass('row');

                $('#table_mingguan').addClass('hide');
                $('#table_bulanan').addClass('hide');
                $('#table_harian').addClass('hide');
                $('#table_individu').addClass('hide');
            })
            //target_individu
            $("button[name ='target_individu']").click(function(e) {
                e.preventDefault();
                $('#harian').removeClass('pilih');
                $('#bulanan').removeClass('pilih');
                $('#mingguan').removeClass('pilih');
                $('#tahunan').removeClass('pilih');

                $('#hr_harian').addClass('hide');
                $('#hr_mingguan').addClass('hide');
                $('#hr_bulanan').addClass('hide');
                $('#hr_tahunan').addClass('hide');

                $('#hr_individu').removeClass('hide');


                $(this).addClass('pilih');

                $('#table_individu').removeClass('hide').addClass('row');

                $('#table_mingguan').addClass('hide');
                $('#table_bulanan').addClass('hide');
                $('#table_tahunan').addClass('hide');
                $('#table_harian').addClass('hide');
            })
        })
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadingBar = document.querySelector('.loading-bar');
    const loadingText = document.getElementById('loadingText');

    let progress = 0;

    function updateProgressBar() {
        if (progress <= 100) {
            loadingBar.style.width = `${progress}%`;
            loadingText.innerText = `Loading... ${progress}%`;
            progress++;
            setTimeout(updateProgressBar, 50); // Update every 50 milliseconds
        } else {
            loadingText.innerText = 'Loading Complete!';
        }
    }

    updateProgressBar(); // Start the loading animation
});


</script>

    </body>
</html>