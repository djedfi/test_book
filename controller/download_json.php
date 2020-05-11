<?php
require('../config/db.conf.php');
require('../class/connection.class.php');
require('../class/addressbook.class.php');
$obj_addrbook       =       new Addressbook();

$data               =   $obj_addrbook->select_addrbook(0);


header('Content-Encoding: utf-8');
header('Content-Type:  application/json; charset=utf-8');
header('Content-Disposition: attachment; filename="people_json.json";');
echo json_encode($data);