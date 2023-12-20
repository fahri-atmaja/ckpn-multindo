<?php
include "../../../include/fungsi.php";
include "../../../include/dbconfig.php";

$nik = $_SESSION['nik'];

$query = mssql_query("SELECT thbl FROM ckpn_index GROUP BY thbl ORDER BY thbl DESC");


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
    #loadingOverlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999; /* Menetapkan z-index yang tinggi */
}

#progressBarContainer {
  width: 200px;
  background: #ccc;
  border-radius: 10px;
  padding: 5px;
}

#progressBar {
  width: 0;
  height: 20px;
  background: #7B68EE;;
  border-radius: 5px;
}

#progressText {
  text-align: center;
  font-weight: bold;
  color: #333;
}

</style>
<body>
    <div id="loadingOverlay" style="display:none;">
        <div id="progressBarContainer">
            <div id="progressBar"></div>
            <div id="progressText">0%</div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="filter-wrapper d-flex" style="margin-top: 20px;">
            <div class="d-flex flex-row align-items-center justify-content-start w-100">
                <div class="filter-title d-flex">
                    <div class="title">
                        <h5>Kelola Laporan CKPN</h5>
                    </div>
                </div>

            </div>
        </div>
        <hr>
        <div class="input-container d-flex">
            <div class="d-flex flex-row align-items-center justify-content-start w-100">
            <button class="btn " id="create" name="create" data-toggle="modal" data-target="#inputThblCkpn" style="width: 130px; background-color: #111F82;color: white; height: 40px; display: inline-block;">
                    <img src="<?php echo hostname(); ?>/module/rutinitas/asset/plus.svg" alt="plus" style="margin-bottom: 3px;"> Tambah
                </button>
            </div>
        </div>


<div style="margin-left: 20px; margin-right: 30px;">
<table class="table  table-borderless" id="tableCkpn">
<thead class="secondary-color text-center">
    <tr>
        <th style="text-align: left; background-color: #F7F7FC;">THBL</th>
        <th style="text-align: left;background-color: #F7F7FC;">Aksi</th>
    </tr>
</thead>
<tbody>

    <?php while ($data = mssql_fetch_assoc($query)) { ?>
        <tr>
            <td style="text-align: left;"><?php echo "CKPN ". konversi_tahun_bulan($data['thbl']) ?></td>
            <td style='white-space: nowrap; text-align: left;'>
            <?php
                $d   = mssql_query("SELECT sts FROM ckpn_index WHERE thbl='$data[thbl]'");
                $dat = mssql_fetch_assoc($d);
                if($dat['sts']=="dibuat"){
            ?>
                <button style="background-color: #111F82; color: white;" type="button" class="btn btn-sm btn-secondary" name="updateCkpn" mappingThbl="<?php echo $data['thbl'] ?>" id="updateCkpn" data-toggle="modal" data-target="#ModalMapping">
                        <img src="<?php echo hostname(); ?>/module/ckpn/asset/play.svg" alt="list"> Update CKPN
                </button>
            <?php
                }elseif($dat['sts']=="diupdate"){
            ?>
                <button style="background-color: #85200B; color: white;" type="button" class="btn btn-sm btn-secondary" name="buatCkpn" mappingThbl="<?php echo $data['thbl'] ?>" id="buatCkpn" data-toggle="modal" data-target="#ModalMapping">
                        <img src="<?php echo hostname(); ?>/module/ckpn/asset/circle_select.svg" alt="list"> Buat Laporan
                </button>
                <?php
                }else{
                ?>
                <a href="http://192.168.1.196/sismaf/isi.php?pid=1869&thbl=<?= $data['thbl'] ?>">
                <button style="background-color: #0B7415; color: white;" type="button" class="btn btn-sm btn-secondary">
                        <img src="<?php echo hostname(); ?>/module/ckpn/asset/eye.svg" alt="list"> Lihat Laporan
                </button>
                </a>
                <?php    
                }
                ?>
            </td>
        </tr>
    <?php } ?>
</tbody>
<br>
</table>

</div>

</div>

<!-- <div class="modal" id="FilterPekerjaan" role="dialog" aria-labelledby="" aria-hidden="true" data-keyboard="false"></div> -->
<div class="modal" id="inputThblCkpn" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-keyboard="false"></div>
<!-- <div class="modal" id="ModalDetail" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-keyboard="false"></div>
<div class="modal" id="ModalEditPekerjaan" role="dialog" aria-labelledby="" aria-hidden="true" data-keyboard="false"></div> -->
<script>
$(document).ready(function() {

    tableCkpn = $('#tableCkpn').DataTable();
    $('#searchAll').keyup(function() {
    tableCkpn.search($(this).val()).draw();
})

$("#create").click(function(e) {
e.preventDefault();

let bulan = $("input[name=bulan]").val();
let tahun = $("input[name=tahun]").val();


$.ajax({
    url: "module/ckpn/inputThblCkpn.php",
    method: "POST",
    data: {
        bulan: bulan,
        tahun: tahun,
    },
    cache: false,
    success: function(response) {
        $("#inputThblCkpn").modal({
            backdrop: 'static',
            show: true,
            keyboard: false,

        });
        $("#inputThblCkpn").html(response);
    }
})
})
})
        $(document).on("click", "#buatCkpn", function(e) {
            e.preventDefault();

            let mappingThbl = $(this).attr('mappingThbl')
            let formData = new FormData()
            const today = new Date();

            formData.append("mappingThbl", mappingThbl);
            formData.append("action", "mulaiBuatLaporan");
            // console.log(MappingThbl);

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Mulai Pekerjaan ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "module/ckpn/script.php",
                        method: "POST",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: () => {
                            $.LoadingOverlay("show");
                        },
                        complete: () => {
                            $.LoadingOverlay("hide");
                        },
                        success: (response) => {
                            let obj = JSON.parse(response);
                            let mappingThbl = obj.mappingThbl;
                            console.log(obj);
                            console.log(mappingThbl);

                            if (obj.status == "OK") {
                                Swal.fire(
                                    'Sukses!',
                                    obj.message,
                                    'success'
                                ).then(() => {
                                    // window.location.reload();
                                    window.location.href = `http://192.168.1.196/sismaf/isi.php?pid=1869&thbl=${mappingThbl}`;

                                })
                            } else {
                                Swal.fire(
                                    'Oops!',
                                    obj.message,
                                    'error'
                                )
                            }
                        }
                    })
                }
            })

        })

        $(document).on("click", "#updateCkpn", function(e) {
            e.preventDefault();

            let mappingThbl = $(this).attr('mappingThbl')
            let formData = new FormData()
            const today = new Date();

            formData.append("mappingThbl", mappingThbl);
            formData.append("action", "updateCkpn");
            // console.log(MappingThbl);

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Mulai Pekerjaan ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let percent = 0;
                    let interval = setInterval(function() {
                        percent += 1; // Meningkatkan persentase sebanyak 1
                        $('#progressBar').css('width', percent + '%');
                        $('#progressText').text(percent + '%');

                        if (percent >= 100) {
                            clearInterval(interval); // Menghentikan interval saat mencapai 100%
                        }
                    }, 500); 
                    $.ajax({
                        url: "module/ckpn/script.php",
                        method: "POST",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: () => {
                            $('#loadingOverlay').show();
                        },
                        complete: () => {
                            $('#loadingOverlay').hide();
                        },
                        success: (response) => {
                            let obj = JSON.parse(response);
                            let mappingThbl = obj.mappingThbl;
                            console.log(obj);
                            console.log(mappingThbl);

                            if (obj.status == "OK") {
                                Swal.fire(
                                    'Sukses!',
                                    obj.message,
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                    // window.location.href = `http://192.168.1.196/sismaf/isi.php?pid=1868&thbl=${mappingThbl}`;

                                })
                            } else {
                                Swal.fire(
                                    'Oops!',
                                    obj.message,
                                    'error'
                                ).then(() => {
                                    window.location.reload();
                                })
                            }
                        }
                    })
                }
            })

        })
</script>
</body>

</html>
