<?php 
    include 'config.php';
    include 'dumper.php';

    $world_dumper = Shuttle_Dumper::create(array(
        'host' => DB_HOST,
        'username' => DB_USER,
        'password' => DB_PASS,
        'db_name' => DB_NAME,
    ));
    // dump the database to plain text file
    $file_url = 'db_backups/'.DB_NAME.'_'.gmdate('Y_m_d_h_i_s_A').'.sql';
    $world_dumper->dump($file_url);

    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary"); 
    header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
    readfile($file_url); 
    unlink($file_url);
?>