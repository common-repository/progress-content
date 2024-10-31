<?php
/*
 * Plugin Name: Progress Content
 * Description: Add a progress bar on the top of each posts/pages/custom content
 * Author: Rémi DUPLE
 * Text Domain : progress-content
 * Domain Path: /languages
 * Version: 1.2
 * License: GPL v3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Author URI: https://lesvlogsdundev.com/
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once ('progress.class.php');
new progcontent_Progress();
?>