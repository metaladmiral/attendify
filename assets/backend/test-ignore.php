<?php

$json = '[{"depid":"askdh81","clgLabel":"CEC","depLabel":"CSE"},{"depid":"asd12a","clgLabel":"CEC","depLabel":"Applied Science"}]';

$json = json_decode($json, true);

$json = array_values($json);

// var_dump($json);

$col = array_column($json,'depid', 'clgLabel');

// var_dump($col);

// echo array_search("askdh81", $json);

foreach ($json as $key => $value) {
    echo $value['depid'];
}

?>