<?php
/**
 * Plugin Name: Elementor Forms HubSpot Action
 * Description: Custom addon to send form data to HubSpot.
 * Plugin URI:  https://example.com/
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://example.com/
 * Text Domain: elementor-forms-hubspot-action
 *
 * Elementor tested up to: 3.x.x
 * Elementor Pro tested up to: 3.x.x
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function add_new_hubspot_action( $form_actions_registrar ) {
    include_once( __DIR__ . '/form-actions/hubspot.php' );
    $form_actions_registrar->register( new \HubSpot_Action_After_Submit() );
}
add_action( 'elementor_pro/forms/actions/register', 'add_new_hubspot_action' );
