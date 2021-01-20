<?php
include_once 'connection.php';
include_once 'sessions.php';
include_once 'functions.php';

$session = new Session();
$functions = new Functions();

$months = ["1","2","3","4","5","6","7","8","9","10","11","12"];


$sql = "select *,sum(or_net_amount) as amount from orders group by month(date_time) asc";

$results = $functions->fetch_rows($functions->query($sql));

foreach ($results as $result) {
    $month_number = date('m',strtotime($result['date_time']));
    for ($i=0; $i < sizeof($months); $i++) { 
        if($months[$i] == $month_number){
            $months[$i] = $result['amount'].'D';
            break;
        }
    }
}

for ($i=0; $i < sizeof($months); $i++) { 
    if(strpos($months[$i],'D') == true){
        $months[$i] = (double) sprintf('%0.2f',str_replace('D','',$months[$i]));
    }else{
        $months[$i] = 0;
    }
}

echo json_encode($months);