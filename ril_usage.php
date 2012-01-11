<?php

require_once('ReadItLater.php');
// please enter correct username and password
$ril = new ReadItLater("","");

// add single
$ril->addSingle("http://blog.kiranruth.com","Amazing Read");

$new = array();
$obj['url'] = 'http://www.google.com';
$obj['title'] = 'Google ';
$new[] = $obj;
$obj['url'] = 'http://www.yahoo.com';
$obj['title'] = 'yahoo ';
$new[] = $obj;

$read = array();
$obj = array();
$obj['url'] = 'http://www.yahoo.com';
$read[] = $obj;

$updateTitle = array();
$obj = array();
$obj['url'] = 'http://www.yahoo.com';
$obj['title'] = 'Yahoooooooo';
$updateTitle[] = $obj;

$updateTags = array();
$obj = array();
$obj['url'] = 'http://www.yahoo.com';
$obj['tags'] = 'Ya,hooo,oooo,o,oooooooooooohhhh';
$updateTags[] = $obj;

// bulk chnages
$ril->sendChanges($new,$read,$updateTitle,$updateTags);
// get list
$ril->retreiveUsersList();

?>