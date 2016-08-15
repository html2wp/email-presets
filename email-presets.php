<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://htmltowordpress.io
 * @since             1.0.0
 * @package           Email_Presets
 *
 * @wordpress-plugin
 * Plugin Name:       Email Presets
 * Plugin URI:        https://htmltowordpress.io
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            htmltowordpress.io
 * Author URI:        https://htmltowordpress.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       email-presets
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'init', 'ep_register_custom_post_type' );

function ep_register_custom_post_type() {

	// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Email Presets', 'Post Type General Name', 'email-presets' ),
		'singular_name'       => _x( 'Email Preset', 'Post Type Singular Name', 'email-presets' ),
		'menu_name'           => __( 'Email Presets', 'email-presets' ),
		'parent_item_colon'   => __( 'Parent Email Preset', 'email-presets' ),
		'all_items'           => __( 'All Email Presets', 'email-presets' ),
		'view_item'           => __( 'View Email Preset', 'email-presets' ),
		'add_new_item'        => __( 'Add New Email Preset', 'email-presets' ),
		'add_new'             => __( 'Add New', 'email-presets' ),
		'edit_item'           => __( 'Edit Email Preset', 'email-presets' ),
		'update_item'         => __( 'Update Email Preset', 'email-presets' ),
		'search_items'        => __( 'Search Email Preset', 'email-presets' ),
		'not_found'           => __( 'Not Found', 'email-presets' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'email-presets' ),
	);

	// Set other options for Custom Post Type
	$args = array(
		'label'               => __( 'Email Preset', 'email-presets' ),
		'description'         => __( 'Email Presets', 'email-presets' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'custom-fields', ),
		// You can associate this CPT with a taxonomy or custom taxonomy.
		'taxonomies'          => array( 'category' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => 'post',
	);

	// Registering your Custom Post Type
	register_post_type( 'email_preset', $args );
}

function ep_mail( $slug, $to, $subject_args = array(), $message_args = array(), $headers = '', $attachments = array() ) {
	$email_preset = get_page_by_path( $slug, 'OBJECT', 'email_preset' );
	return wp_mail( $to, vsprintf( get_post_meta( $email_preset->ID, 'ep_email_subject', true ), $subject_args ), vsprintf( $email_preset->post_content, $message_args ), $headers, $attachments );
}