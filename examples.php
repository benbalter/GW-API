<?php
//Grab API
include('gw-api.php');

//init API wrapper
$gwapi = new gw_api;

//list departments
$departments = $gwapi->get_schedule();
foreach ($departments as $department)
    echo $department->departmentname . '<br />';

//get course schedule for fall 2010
$courses = $gwapi->get_schedule('2011','03','ACCY');

//Get Course Schedule for current term
$courses = $gwapi->get_schedule(null,null,'ACCY');

//Get map categories
$categories = $gwapi->get_map();

//get buildings
$buildings = $gwapi->get_maps('academic');
?>