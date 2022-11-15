<?php

$kasutaja='topolja';//d113373_timofei
$server='localhost';//d113373.mysql.zonevs.eu
$andmebaas='linnad';//d113373_bass
$salasona='123456';//ainult mina tean!

//teeme käsk mis ühendab

$yhendus=new mysqli($server, $kasutaja, $salasona, $andmebaas);
$yhendus->set_charset('UTF8');


/*
CREATE TABLE loomad
(
id int PRIMARY key AUTO_INCREMENT,
loomanimi varchar(50) UNIQUE,
vanus int,
pilt varchar(200)
);
*/
?>