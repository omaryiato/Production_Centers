<?php

namespace App\Helper;


use Illuminate\Support\Facades\DB;
use phpseclib3\Net\SFTP;

class UploadDocumnetAcrchive
{

    public function upload($employeeNumber, $outputFileName_local_word_readyOnly, $file_output_name)
    {
        try {
            $currentDomain = request()->getHost();
            if ($currentDomain == "127.0.0.1") {
                $FTP_HOST_ARCHIVE = "192.168.15.245";
                $FTP_USER_ARCHIVE = "appwls";
                $FTP_PASS_ARCHIVE = "appwls123";
            } else {
                $FTP_HOST_ARCHIVE = "192.168.15.44";
                $FTP_USER_ARCHIVE = "selfservice";
                $FTP_PASS_ARCHIVE = "selfservice";
            }
            // Initialize an SFTP connection
            $sftp = new SFTP($FTP_HOST_ARCHIVE);

            // Authenticate with the server using a username and password
            if (!$sftp->login($FTP_USER_ARCHIVE, $FTP_PASS_ARCHIVE)) {
                echo "Login failed.";
                return;
            }

            $localFilePath = $outputFileName_local_word_readyOnly;
            $fileSizeInMB = round(filesize($localFilePath) / (1024 * 1024), 2); // Convert bytes to megabytes (1 megabyte = 1024 kilobytes)

            $compressedSizeInMB = $fileSizeInMB * 0.5; // Adjust the compression factor as needed

            $compressedSizeInKB = $compressedSizeInMB * 1024; // Convert megabytes to kilobytes

            $compressedSizeInKB = round($compressedSizeInKB, 2);
            $check_found_dire_archive =  DB::select("
          select count(*) as check_count
            from apps.XXARCH_EBS_CONTEXT_RECORDS
            where context ='EMP'
            and record = '$employeeNumber'
        ")[0]->check_count;
            if ($check_found_dire_archive == 0) {
                DB::statement("BEGIN xxajmi_sshr_emp_absence.xxajmi_archive_file_head_sshr ('$employeeNumber', '$file_output_name', $compressedSizeInKB); END;");
                DB::statement("BEGIN xxajmi_sshr_emp_absence.XXAJMI_ARCHIVE_FILE_SSHR ('$employeeNumber', '$file_output_name', $compressedSizeInKB); END;");
            } else if ($check_found_dire_archive == 1) {
                DB::statement("BEGIN xxajmi_sshr_emp_absence.XXAJMI_ARCHIVE_FILE_SSHR ('$employeeNumber', '$file_output_name', $compressedSizeInKB); END;");
            }

            $path_url =  DB::select("select '/u02/temp/DocumentArchivingSystem/EMP/'||substr(arc_tran_code,instr(arc_tran_code,'-',1,2)+1,6)||'/'||arc_tran_code as path
            from TRAN_ARCHIVING_HEADER@DOCARCH_ARCHSRV.ALAJMI.COM.SA
            where ebs_record_no ='$employeeNumber'and arc_tran_code like 'EMP%' ");
            $tranc_code = DB::select("select arc_tran_code from TRAN_ARCHIVING_HEADER@DOCARCH_ARCHSRV.ALAJMI.COM.SA where ebs_record_no ='$employeeNumber' and arc_tran_code like 'EMP%'");


            if (isset($path_url[0])) {
                $remoteBaseDir = $path_url[0]->path;
                if (isset($tranc_code[0])) {
                    $remoteEmployeeDir = "{$remoteBaseDir}";
                    if (!$sftp->is_dir($remoteEmployeeDir)) {
                        if (!$sftp->mkdir($remoteEmployeeDir, 0777, true)) {
                            $sftp->disconnect();
                            return;
                        }
                    }


                    $remoteFilePath = "{$remoteEmployeeDir}/" . basename($localFilePath);
                    if ($sftp->put($remoteFilePath, $localFilePath, SFTP::SOURCE_LOCAL_FILE)) {
                    }
                    $sftp->disconnect();
                }
            }
        } catch (\Exception $exception) {
            // dd($exception->getMessage());
        }
    }
}
