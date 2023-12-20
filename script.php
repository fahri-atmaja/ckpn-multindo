<?php
include_once("../../include/fungsi.php");
include_once("../../include/dbconfig.php");

$nik = $_SESSION['nik'];
$action = $_POST['action'];

switch ($action) {
    case 'input_thbl_ckpn':
        error_reporting(E_ALL);
        $log = "";
        $message = "";
        $status = "";
        $thisbulan = date('m');
        $thistahun = date('Y');
        $tahun = $_POST['tahun'];
        $bulan = $_POST['bulan'];
        $thbl = $tahun.$bulan;
        $thisthbl = $thistahun.$thisbulan;
        if($thisthbl <= $thbl){
            $status = "ERROR";
            $message = "THBL sama dengan atau melebihi tahun dan bulan sekarang!";
            $log .= $cekthbl;
            $response = array(
                "status" => $status,
                "message" => $message,
                "log" => $thisthbl 
            );
            echo json_encode($response);
        }else{
        $cekthbl = mssql_query("SELECT thbl FROM ckpn_index WHERE thbl=$thbl");
        if (mssql_num_rows($cekthbl) > 0) {
            $status = "ERROR";
            $message = "THBL sudah tersedia, silahkan cek pencarian!";
            $log .= $cekthbl;
            $response = array(
                "status" => $status,
                "message" => $message,
                "log" => $log
            );
            echo json_encode($response);
        }else{
            set_time_limit(300);
            $qry =  "exec insertCkpn_index '$thbl'";
            $exec = mssql_query($qry);
                if($exec){
                    $status = "OK";
                    $message = "Berhasil Input THBL CKPN !";
                    $log = $exec;
                }else {
                        $status = "ERROR";
                        $message = "Gagal Membuat Laporan !";
                        $log = mssql_get_last_message();
                    }
                    $response = array(
                        "status" => $status,
                        "message" => $message,
                        "log" => $log
                    );
                    echo json_encode($response);
        }
    }

        break;

    case 'mulaiBuatLaporan':
        error_reporting(E_ALL);
        $log = "";
        $message = "";
        $status = "";
        set_time_limit(300);
        $mappingThbl = $_POST['mappingThbl'];
        // $mappingThbl = '202308';
        $qry =  "exec ckpn_insert_ecl '$mappingThbl'"; 
        // $qry = "SELECT kosong = 'init'";
        $exec = mssql_query($qry);
        // var_dump($exec);
        // die();

            if ($exec) {
                $status = "OK";
                $message = "Berhasil Membuat Laporan !";
                $log .= $qry;

            } else {
                $status = "ERROR";
                $message = "Gagal Membuat Laporan !";
                $log .= mssql_get_last_message();
            }
            
            $response = array(
                "status" => $status,
                "message" => $message,
                "log" => $log,
                "mappingThbl" => $mappingThbl 
            );
            echo json_encode($response);
        break;
        
        case 'updateCkpn':
            error_reporting(E_ALL);
            // sleep(500);
            // $status = "OK";
            // $message = "Berhasil Update !";
            // $log = "sleep 2000";
            $log = "";
            $message = "";
            $status = "";

            set_time_limit(600);
            $mappingThbl = $_POST['mappingThbl'];
            $query="exec olahCkpn_index $mappingThbl";
            $exec = mssql_query($query); // menghasilkan bolse(false) namun terupdate
            //$vardump = var_dump($exec);
            
        if ($exec) {
            $status = "OK";
            $message = "Berhasil Update !";
            $log = $qry;

        // } else {
        //     $status = "ERROR";
        //     $message = "Gagal Update!";
        //     $log = mssql_get_last_message();
        // }

        } else {
            $status = "OK";
            $message = "Mohon tunggu sampai tombol berubah! Silahkan Refresh Browser 2-3 menit setelah notif ini.";
            $log = mssql_get_last_message();
        }
            
        $response = array(
            "status" => $status,
            "message" => $message,
            "log" => $log,
            "mappingThbl" => $mappingThbl 
        );
        echo json_encode($response);
        break;
}
