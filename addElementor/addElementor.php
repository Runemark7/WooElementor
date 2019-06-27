<?php
/**
 * @package addElementor
 */
/*
Plugin Name: addElementor
Plugin URI: https://www.worryless.com
Description: This is a addon for Elementor, adds more widgets to the elementor builder
Version: 1.0.0
Author: Alexander Runemark
Author URI: https://www.anyola.com
License: MIT
Text domain: localhost/RuneTheme
 */

defined('ABSPATH') || die();

require plugin_dir_path( __FILE__ ) . 'customWidgets/my-widgets.php';

\Elementwoo\Base::instance();