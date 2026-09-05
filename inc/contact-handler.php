<?php
/**
 * Contact Form Post Handler
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

function dharmgyan_handle_contact_form() {
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'dharmgyan_contact_nonce')) {
        wp_die(esc_html__('Security check failed.', 'dharmgyan'));
    }

    $name    = isset($_POST['contact_name']) ? sanitize_text_field($_POST['contact_name']) : '';
    $phone   = isset($_POST['contact_phone']) ? sanitize_text_field($_POST['contact_phone']) : '';
    $email   = isset($_POST['contact_email']) ? sanitize_email($_POST['contact_email']) : '';
    $message = isset($_POST['contact_message']) ? sanitize_textarea_field($_POST['contact_message']) : '';

    $redirect_url = wp_get_referer() ?: home_url('/contact-us/');

    if (empty($name) || empty($email) || empty($message)) {
        wp_safe_redirect(add_query_arg('contact_status', 'error', $redirect_url));
        exit;
    }

    // Recipient: ACF configured email or admin email
    $to = get_field('email_address', 603) ?: get_option('admin_email');
    $subject = sprintf(__('[Bhaktirastore] New Contact Message from %s', 'dharmgyan'), $name);
    
    $body = "Name: $name\n";
    if (!empty($phone)) {
        $body .= "Phone: $phone\n";
    }
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$message\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8');
    if (!empty($email)) {
        $headers[] = "Reply-To: $name <$email>";
    }

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_safe_redirect(add_query_arg('contact_status', 'success', $redirect_url));
    } else {
        wp_safe_redirect(add_query_arg('contact_status', 'error', $redirect_url));
    }
    exit;
}
add_action('admin_post_dharmgyan_contact_form', 'dharmgyan_handle_contact_form');
add_action('admin_post_nopriv_dharmgyan_contact_form', 'dharmgyan_handle_contact_form');
