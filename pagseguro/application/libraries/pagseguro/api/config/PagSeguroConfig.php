<?php

/*
 ************************************************************************
 PagSeguro Config File
 ************************************************************************
 */

$PagSeguroConfig = array();

$PagSeguroConfig['environment'] = "sandbox"; // production, sandbox

$PagSeguroConfig['credentials'] = array();

$PagSeguroConfig['credentials']['email'] = ""; //Yor email pagseguro
$PagSeguroConfig['credentials']['token']['production'] = "";
$PagSeguroConfig['credentials']['token']['sandbox'] = ""; //Your token pagseguro

$PagSeguroConfig['application'] = array();
$PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

$PagSeguroConfig['log'] = array();
$PagSeguroConfig['log']['active'] = FALSE;
$PagSeguroConfig['log']['fileLocation'] = "../logs/log_pagseguro.txt";
