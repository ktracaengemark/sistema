<?php

$record[0]["title"] = "Test 1";
$record[1]["title"] = "Test 2";
#$record[2]["title"]="Test 3";

$record[0]["start_date"] = "2015-08-25";
$record[1]["start_date"] = "2015-08-26T19:30:00";
#$record[2]["start_date"]="1333976402";

$record[0]["end_date"] = "2015-08-26";
$record[1]["end_date"] = "2015-08-27T12:30:00";
#$record[2]["end_date"]="1333980002";

$record[0]["id"] = "1";
$record[1]["id"] = "2";
#$record[2]["id"]="3";

for ($i = 0; $i < 2; $i++) {

    $event_array[] = array(
        'id' => $record[$i]['id'],
        'title' => $record[$i]['title'],
        'start' => $record[$i]['start_date'],
        'end' => $record[$i]['end_date'],
        'allDay' => false,
        'url' => 'http://google.com/',
        'tip' => 'Personal tip 1 \n teste 123 <br> okok'

    );
}

echo json_encode($event_array);
exit;
?>
