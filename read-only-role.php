<?php
/*
Plugin Name: Read Only Role
Plugin URI: http://github.com/mehtryx/read-only-role
Description: Sets up readonly role for VIP sites
Version: 0.0.1
Author: Keith Benedict
License: MIT
*/

require_once ABSPATH . 'wp-content/themes/vip/plugins/vip-do-not-include-on-wpcom/vip-roles.php';

add_action( 'init', 'mehtryx_custom_readonly_role' );
function mehtryx_custom_readonly_role() {
    wpcom_vip_add_role( 'readonly', 'Read Only', array( 'read' => true, ) );
}