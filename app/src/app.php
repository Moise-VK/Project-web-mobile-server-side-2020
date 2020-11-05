<?php

/**
 * Our entry point of the application
 */


// Are we in need of any common variables or implementations?
$basePath = __DIR__ . '/../';



// Any configuration that is needed before our bootstrap



// What route is used?
$script = $_SERVER['REQUEST_URI'] === '/' ? '/index' : $_SERVER['REQUEST_URI'];



// Load models



// Load repositories



// Load services and other stuff



// Route to script mapper
// In the end we are looking for some output
require_once __DIR__ . '/scripts' . $script . '.php';
