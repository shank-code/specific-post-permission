<?php

/**
 * Plugin Name: Specific Post Permission
 * Plugin URI: https://www.yourwebsiteurl.com/
 * Description: This is the specific post permission I ever created.
 * Version: 1.0
 * Author: Excellence
 * Author URI: http://yourwebsiteurl.com/
 **/
function mypo_parse_query_useronly($wp_query)
{
    if (strpos($_SERVER['REQUEST_URI'], '/wp-admin/edit.php') !== false) {
        if (!current_user_can('activate_plugins')) {
            add_action('views_edit-post', 'child_remove_some_post_views');
            global $current_user;
            $wp_query->set('author', $current_user->id);
        }
    }
}

add_filter('parse_query', 'mypo_parse_query_useronly');

/**
 * Remove All, Published and Trashed posts views.
 *
 * Requires WP 3.1+.
 * @param array $views
 * @return array
 */
function child_remove_some_post_views($views)
{
    unset($views['all']);
    unset($views['publish']);
    unset($views['trash']);
    unset($views['draft']);
    unset($views['pending']);
    return $views;
}
?>
