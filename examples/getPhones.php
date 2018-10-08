<?php
require dirname(__FILE__).'/../src/PhoneArena/autoload.php';

$phone = new \PhoneArena\Scraper;
var_dump($phone->getPhonesByCompany('Apple'));