<?php
require('../config/db.conf.php');
require('../class/connection.class.php');
require('../class/addressbook.class.php');
$obj_addrbook       =       new Addressbook();

$data               =   $obj_addrbook->select_addrbook(0);


$fh = fopen("../downloads/people_json.json", 'w+');
fwrite($fh, json_encode($data));
fclose($fh);


