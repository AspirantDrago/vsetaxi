<?php
session_start();

if(!isset($_SESSION['street1'])) {
    $_SESSION['street1'] = 'Худайбердина';
}
if(!isset($_SESSION['home1'])) {
    $_SESSION['home1'] = '198';
}
if(!isset($_SESSION['entrance1'])) {
    $_SESSION['entrance1'] = '';
}
if(!isset($_SESSION['street2'])) {
    $_SESSION['street2'] = 'проспект Ленина';
}
if(!isset($_SESSION['home2'])) {
    $_SESSION['home2'] = '49';
}
if(!isset($_SESSION['entrance2'])) {
    $_SESSION['entrance2'] = '';
}

if(isset($_POST['start_street'])) {
    $_SESSION['street1'] = trim($_POST['start_street']);
}
if(isset($_POST['start_home'])) {
    $_SESSION['home1'] = trim($_POST['start_home']);
}
if(isset($_POST['start_entrance'])) {
    $_SESSION['entrance1'] = trim($_POST['start_entrance']);
}
if(isset($_POST['finish_street'])) {
    $_SESSION['street2'] = trim($_POST['finish_street']);
}
if(isset($_POST['finish_home'])) {
    $_SESSION['home2'] = trim($_POST['finish_home']);
}
if(isset($_POST['finish_entrance'])) {
    $_SESSION['entrance2'] = trim($_POST['finish_entrance']);
}
