<?php
include('App/app.includes.php');

$db = new \mystats\Database();
$player = new \mystats\Player(76561198044219921);
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
        print_r($player->getInv());
        ?>
    </pre>
</body>
</html>
