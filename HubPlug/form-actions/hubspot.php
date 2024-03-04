<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class HubSpot_Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base {

    public function get_name() {
        return 'hubspot';
    }

    public function get_label() {
        return esc_html__( 'HubSpot', 'elementor-forms-hubspot-action' );
    }

    public function run( $record, $ajax_handler ) {
        $raw_fields = $record->get( 'fields' );
        $fields = [];
        foreach ( $raw_fields as $id => $field ) {
            $fields[$id] = $field['value'];
        }

        $data = [
            'properties' => [
                'email' => $fields['email'],
                'firstname' => $fields['name'],
                'lastname' => 'Doe',
                'phone' => $fields['field_9ac823a'],
                'when_would_you_like_to_sell_your_home_' => $fields['field_c2dc93d'],
                'do_you_own_the_property_' => $fields['field_9899c5b'],
                'why_are_you_selling_' => $fields['field_50a943d'],
                'best_time_to_discuss_situation' => $fields['field_cde68ce'],
                'subject_property_address' => $fields['field_64659ab'],
                'subject_property_zip_code' => $fields['field_c524206'],
                'contact_method' => 'Form'
            ]
        ];

        $response = wp_remote_post('https://api.hubapi.com/crm/v3/objects/contacts', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer pat-na1-b3b86827-6542-4e95-9c26-ca79e0b67acd'
            ],
            'body' => json_encode($data),
            'method' => 'POST',
            'data_format' => 'body'
        ]);

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            $ajax_handler->add_error_message("API request failed: $error_message");
        } else {
            $body = wp_remote_retrieve_body($response);
            // Optionally process the response
        }
    }

    public function register_settings_section( $widget ) {}
    public function on_export( $element ) {}
}
