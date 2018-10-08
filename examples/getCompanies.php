<?php
require dirname(__FILE__).'/../src/PhoneArena/Scraper.php';

$phone = new \PhoneArena\Scraper;
var_dump($phone->getCompany());