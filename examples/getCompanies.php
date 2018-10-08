<?php
require dirname(__FILE__).'/../src/PhoneArena/autoload.php';

$phone = new \PhoneArena\Scraper;
try{
    var_dump($phone->getCompany());
}catch(\PhoneArena\PhoneArenaException $e) {
    var_dump($e->getMessage());
}