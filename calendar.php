<?php

function display_event(array $event) {
    $date = substr($event['date'], -2) . "-" . substr($event['date'], 4, 2) . "-" . substr($event['date'], 0, 4);
    echo 'The "' . $event['name'] . '" event will take place on ' . $date . ' in ' . $event['location'] . PHP_EOL;
}

function display_events_by_month(array $event) {
    $event = mouli($event);
    static $associative_date_array = [];
    for ($i=0; $i < count($event); $i++) { 
        $date = substr($event[$i]['date'], 0, 4) . '-' . substr($event[$i]['date'], 4, 2);
        if(array_key_exists($date, $associative_date_array)){
            $mem = $associative_date_array[$date];
            unset($associative_date_array[$date]);
            $associative_date_array += [$date => $mem, $event[$i]];
        } else {
            $associative_date_array += [$date => $event[$i]];
        }
    }

    foreach ($associative_date_array as $key => $value) {
        $date = substr($value['date'], -2) . "-" . substr($value['date'], 4, 2) . "-" . substr($value['date'], 0, 4);
        if ($key > 2000){
            echo $key . PHP_EOL;
            echo '  The ' . $value['name'] . ' event will take place on ' . $date . ' in ' . $value['location'] . PHP_EOL;
        } else {
            echo '  The ' . $value['name'] . ' event will take place on ' . $date . ' in ' . $value['location'] . PHP_EOL;
        }
        // Bug de l'an 2000 :D
    }
}

function display_events_between_months(array $event, string $dateBegin, string $dateEnd) {
    $event = mouli($event);
    static $associative_date_array = [];
    for ($i=0; $i < count($event); $i++) { 
        $date = substr($event[$i]['date'], 0, 4) . '-' . substr($event[$i]['date'], 4, 2);
        if(array_key_exists($date, $associative_date_array)){
            $mem = $associative_date_array[$date];
            unset($associative_date_array[$date]);
            $associative_date_array += [$date => $mem, $event[$i]];
        } else {
            $associative_date_array += [$date => $event[$i]];
        }
    }

    foreach ($associative_date_array as $key => $value) {
        if(substr($value['date'], 0, 6) <= intval($dateEnd) && substr($value['date'], 0, 6) >= $dateBegin){
            $date = substr($value['date'], -2) . "-" . substr($value['date'], 4, 2) . "-" . substr($value['date'], 0, 4);
            if ($key > 2000){
                echo $key . PHP_EOL;
                echo '  The ' . $value['name'] . ' event will take place on ' . $date . ' in ' . $value['location'] . PHP_EOL;
            } else {
                echo '  The ' . $value['name'] . ' event will take place on ' . $date . ' in ' . $value['location'] . PHP_EOL;
            }
        }
    }
}

function mouli($event) {
    static $new_array;
    $new_array = $event; 
    for ($i=0; $i < count($event); $i++) {
        if(isset($new_array[$i - 1]) && intval($new_array[$i]['date']) < intval($new_array[$i-1]['date'])){           
            $mem = $new_array[$i];           
            $new_array[$i] = $new_array[$i - 1];           
            $new_array[$i - 1] = $mem;
            $new_array = mouli($new_array);
        }
    }
    return $new_array;
}