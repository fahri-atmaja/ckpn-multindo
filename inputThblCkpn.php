<?php
include("../../../include/fungsi.php");
include("../../../include/dbconfig.php");
$nik = $_SESSION['nik'];
?>

<style>
    .hrtop {
        border: 2px solid #111F82;
        margin: 0 30px;
    }

    .btn-more {
        border-radius: 20px;
        padding: 10px;

    }

    .btn-more:hover,
    .active {

        color: #fff;
    }

    .pilih {
        background-color: #007ADF;
        color: white;
    }

    #durasiDinamis {
        padding: 5px;
        padding-left: 8px;
    }

    #durasiStatis {
        padding: 5px;
        padding-left: 8px;
    }

    .opacity:hover {
        background-color: #f2f2f2;
        color: black;

    }
</style>

<div class="modal-dialog modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="" name="" method="POST" enctype="">

        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-11 col-lg-11">
                        <h2 class="modal-title" style="font-weight: 700; color:#0D062D">Tambah Tahun Bulan CKPN</h2>
                    </div>

                </div>
                <hr class="hrtop">
                <div class="row" style="padding-top: 15px;">
                    <div class=" col-xl-12 col-lg-12">
                        <div style="font-size: 16px;"> <b> Ambil Tahun Bulan</b></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                    <select name="tahun" id="tahun" class="form-control no-shadow">
                        <?php
                        $tahun_sekarang = date("Y");
                        for ($i = $tahun_sekarang; $i >= 1950; $i--) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                    <select name="bulan" id="bulan" class="form-control no-shadow">
                        <?php
                        $bulan_sekarang = date("m");
                        for ($i = 1; $i <= 12; $i++) {
                            $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                            $selected = ($bulan == $bulan_sekarang) ? "selected" : "";
                            echo "<option value='$bulan' $selected>$bulan</option>";
                        }
                        ?>
                    </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer text-center">
                <div class="container">
                    <div class="row">



                        <div class="col text-center d-flex justify-content-center">
                            <button type="button" class="btn  btn-outline-dark" data-dismiss="modal" onClick="window.location.reload()">Batal</button>
                            <button type="button" class="btn  btn-success ml-3 text-white" name="SimpanThbl" id="SimpanThbl">Ambil Tahun</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {

        ////////////////////////////////////////////

        let circle = "http://192.168.1.26/sismaf/module/ckpn/asset/circle.svg";
        let circle_select = "http://192.168.1.26/sismaf/module/ckpn/asset/circle_select.svg";

        $("button[name='SimpanThbl']").click(function(e) {
            e.preventDefault();
            let tahun = $("#tahun").val();
            let bulan = $("#bulan").val();

            if (tahun == '') {
                alert('Tahun harus diisi');
                return;
            }
            if (bulan == '') {
                alert('Bulan harus diisi');
                return;
            }
            console.log(tahun,bulan);
            let formData = new FormData()
            formData.append("tahun", tahun);
            formData.append("bulan", bulan);
            // formData.append("buttondurasi", buttondurasi);
            formData.append("action","input_thbl_ckpn");

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Anda Menambah Pekerjaan ini !",
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
                            if (obj.status == "OK") {
                                Swal.fire(
                                    'Sukses!',
                                    obj.message,
                                    'success'
                                ).then(() => {
                                    // window.location.reload();
                                    window.location.reload();

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
        })
</script>