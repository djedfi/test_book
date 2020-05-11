<?php
require('../config/db.conf.php');
require('../class/connection.class.php');
require('../class/addressbook.class.php');
$obj_addrbook       =       new Addressbook();
$domxml             =       new DomDocument('1.0', 'UTF-8'); 

$data               =   $obj_addrbook->select_addrbook(0);
$people             =   $domxml->createElement('people');

for($i=0;$i<count($data);$i++)
{
    $person = $domxml->createElement('person');

    foreach($data[$i] as $index=> $value)
    {
        $info = $domxml->createElement($index, $value);
        $person->appendChild($info);
    }
    $people->appendChild($person);

}
$domxml->appendChild($people);
$domxml->save('../downloads/people_xml.xml'); 