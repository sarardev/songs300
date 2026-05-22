<?php
/* 
 *Yemen Sounds 2026 
 */

// Require the class code...
if (!defined('ALLOMANI_SESSION_NAME')) {
    define('ALLOMANI_SESSION_NAME', 'allomani_admin_sid');
}
require ('includes/class_security_img.php'); 

// Initialize class
$gd = new sec_img_verification(150, 35, ALLOMANI_SESSION_NAME);

// Output image
$gd->output_image();
?>
