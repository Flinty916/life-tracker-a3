<?php
include('App/app.includes.php');

$db = new \mystats\Database();

$player = new \mystats\Player(76561198044219921);

$item = new \mystats\Item('14_pier_14_nav_pier_c_l');
?>

<!<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
</head>
<body>
    <pre>
        <?php
//        $split = str_split(json_decode($player->getCivStats()));
//        $array = array();
//            foreach($split as $s) {
//                if($s !== '"' && $s !== "[" && $s !== "]") {
//                    $array[] = $s;
//                }
//            }
//            print_r(explode(',', implode($array)));
        print_r($player->getInv());
        ?>
    </pre>
</body>
</html>
