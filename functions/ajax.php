<?php

add_action('wp_ajax_nopriv_signup_form_submit', 'signup_form_submit');
add_action('wp_ajax_signup_form_submit', 'signup_form_submit');

function signup_form_submit() {
  check_ajax_referer('signup_form_submit', 'signup_form_security_check');

  $endpoint = 'https://clckson-api.com/api/v1/signups/add.php';
  $api_key = '26323938-CDE1-9A69-DC39-3AFB7C3C2207';

  $firstName = sanitize_text_field($_POST['firstName']);
  $lastName = sanitize_text_field($_POST['lastName']);
  $email = sanitize_email($_POST['email']);
  $phone = sanitize_text_field($_POST['phone']);
  $ipAddress = sanitize_text_field($_POST['ipAddress']);
  $offerName = sanitize_text_field($_POST['offerName'] ?? '');

  $pageId = (int)$_POST['pageid'];

  if ($firstName && $lastName && $email && $phone && $ipAddress) {
    $args = [
      'timeout' => 15,
      'headers' => [
        'Api-Key' => $api_key
      ],
      'body' => [
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'password' => '123Abc',
        'phone' => $phone,
        'ip' => $ipAddress,
        'comment' => '',
        'offerName' => $offerName,
        'offerWebsite' => 'bright-investments.com'
      ]
    ];
    if (isset($_POST['source']) && $_POST['source']) {
      $source = sanitize_text_field($_POST['source']);
      $args['body']['custom1'] = strtolower($source);
    }
    $resp = wp_remote_post($endpoint, $args);
    if (!is_wp_error($resp)) {
      $body = json_decode(wp_remote_retrieve_body($resp));

      if (isset($body->statusCode) && $body->statusCode !== 200) {
        $message = current($body->messages);
        wp_send_json_error(['message' => $message, 'redirect' => false]);
      } else {
        $message = current($body->messages);
        $useProductionAPI = get_field('use_production_api', $pageId);
        if ($useProductionAPI) {
          $redirect = $body->data->redirect->url;
        } else {
          $redirect = get_field('redirect_url', 'option');
        }
        wp_send_json_success(['message' => $message, 'redirect' => $redirect, 'response' => json_encode($body), 'request' => json_encode($args)]);
      }
    } else {
      wp_send_json_error(['message' => 'Server error, try again later', 'redirect' => false]);
    }
  } else {
    wp_send_json_error(['message' => 'Incorrect data', 'redirect' => false]);
  }
  die();
}

add_action('wp_ajax_ixx_register_form_submit_test', 'register_form_submit_test');
add_action('wp_ajax_nopriv_ixx_register_form_submit_test', 'register_form_submit_test');

function register_form_submit_test() {
  wp_send_json_success([
    'message' => 'OK',
    'redirect' => get_field('redirect_url', 'option')
  ]);
  die();
}