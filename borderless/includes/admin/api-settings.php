<?php

if (!defined('ABSPATH')) exit;

add_action('admin_menu', 'borderless_register_settings_pages');
add_action('admin_init', 'borderless_register_api_settings');

function borderless_register_settings_pages() {
    add_menu_page(
        'Global Settings',
        'Global Settings',
        'manage_options',
        'borderless-global-settings',
        'borderless_global_settings_page_callback',
        'dashicons-admin-generic',
        80
    );

    add_submenu_page(
        null,
        'Manage OpenAI',
        'Manage OpenAI',
        'manage_options',
        'borderless-manage-openai',
        'borderless_manage_openai_page_callback'
    );

    add_submenu_page(
        null,
        'Manage Google Gemini',
        'Manage Google Gemini',
        'manage_options',
        'borderless-manage-google',
        'borderless_manage_google_page_callback'
    );
}

function borderless_register_api_settings() {
    register_setting('borderless_openai_settings_group', 'borderless_openai_settings', 'borderless_sanitize_settings');
    register_setting('borderless_google_settings_group', 'borderless_google_settings', 'borderless_sanitize_settings');

    add_settings_section('openai_main', 'OpenAI Configuration', '__return_false', 'borderless-openai-settings');
    add_settings_field('openai_api_key', 'API Key', 'borderless_openai_api_key_callback', 'borderless-openai-settings', 'openai_main');
    add_settings_field('openai_model', 'Model', 'borderless_openai_model_callback', 'borderless-openai-settings', 'openai_main');
    add_settings_field('openai_temperature', 'Temperature', 'borderless_openai_temperature_callback', 'borderless-openai-settings', 'openai_main');
    add_settings_field('openai_enable', 'Enable API', 'borderless_openai_enable_callback', 'borderless-openai-settings', 'openai_main');

    add_settings_section('google_main', 'Google Gemini Configuration', '__return_false', 'borderless-google-settings');
    add_settings_field('google_api_key', 'API Key', 'borderless_google_api_key_callback', 'borderless-google-settings', 'google_main');
    add_settings_field('google_model', 'Default Model', 'borderless_google_model_callback', 'borderless-google-settings', 'google_main');
    add_settings_field('google_temperature', 'Temperature', 'borderless_google_temperature_callback', 'borderless-google-settings', 'google_main');
    add_settings_field('google_enable', 'Enable API', 'borderless_google_enable_callback', 'borderless-google-settings', 'google_main');
}

function borderless_openai_api_key_callback() {
    $options = get_option('borderless_openai_settings');
    echo '<input type="text" name="borderless_openai_settings[openai_api_key]" value="' . esc_attr($options['openai_api_key'] ?? '') . '" size="50">';
}

function borderless_openai_model_callback() {
    $options = get_option('borderless_openai_settings');
    $current = $options['openai_model'] ?? 'gpt-4';
    $models = [
        'gpt-4' => 'GPT-4',
        'gpt-4-turbo' => 'GPT-4 Turbo',
        'gpt-4o' => 'GPT-4o',
        'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
        'gpt-3.5-turbo-16k' => 'GPT-3.5 Turbo 16k'
    ];
    echo '<select name="borderless_openai_settings[openai_model]">';
    foreach ($models as $value => $label) {
        $selected = selected($current, $value, false);
        echo "<option value=\"$value\" $selected>$label</option>";
    }
    echo '</select>';
}

function borderless_openai_temperature_callback() {
    $options = get_option('borderless_openai_settings');
    echo '<input type="number" step="0.1" min="0" max="1" name="borderless_openai_settings[openai_temperature]" value="' . esc_attr($options['openai_temperature'] ?? '0.7') . '" size="5">';
}

function borderless_openai_enable_callback() {
    $options = get_option('borderless_openai_settings');
    $checked = !empty($options['openai_enable']) ? 'checked' : '';
    echo '<label><input type="checkbox" name="borderless_openai_settings[openai_enable]" value="1" ' . $checked . '> Enable</label>';
}

function borderless_google_api_key_callback() {
    $options = get_option('borderless_google_settings');
    echo '<input type="text" name="borderless_google_settings[google_api_key]" value="' . esc_attr($options['google_api_key'] ?? '') . '" size="50">';
}

function borderless_google_model_callback() {
    $options = get_option('borderless_google_settings');
    echo '<input type="text" name="borderless_google_settings[google_model]" value="' . esc_attr($options['google_model'] ?? 'gemini-pro') . '" size="20">';
}

function borderless_google_temperature_callback() {
    $options = get_option('borderless_google_settings');
    echo '<input type="number" step="0.1" min="0" max="1" name="borderless_google_settings[google_temperature]" value="' . esc_attr($options['google_temperature'] ?? '0.7') . '" size="5">';
}

function borderless_google_enable_callback() {
    $options = get_option('borderless_google_settings');
    $checked = !empty($options['google_enable']) ? 'checked' : '';
    echo '<label><input type="checkbox" name="borderless_google_settings[google_enable]" value="1" ' . $checked . '> Enable</label>';
}

function borderless_sanitize_settings($input) {
    $output = [];
    foreach ($input as $key => $value) {
        $output[$key] = is_string($value) ? sanitize_text_field($value) : $value;
    }
    return $output;
}

function borderless_global_settings_page_callback() {
    $openai = get_option('borderless_openai_settings');
    $google = get_option('borderless_google_settings');
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'integrations';
    ?>
    <div class="wrap">
        <h1>Global Settings</h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=borderless-global-settings&tab=integrations" class="nav-tab <?php echo $active_tab == 'integrations' ? 'nav-tab-active' : ''; ?>">Integrations</a>
            <a href="#" class="nav-tab disabled">Coming Soon</a>
        </h2>

        <?php if ($active_tab == 'integrations') : ?>
            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th style="width: 30%;">App</th>
                        <th style="width: 40%;">Key</th>
                        <th style="width: 30%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>OpenAI</td>
                        <td><?php echo esc_html($openai['openai_api_key'] ?? ''); ?></td>
                        <td><a href="?page=borderless-manage-openai" class="button button-primary">Manage</a></td>
                    </tr>
                    <tr>
                        <td>Google Gemini</td>
                        <td><?php echo esc_html($google['google_api_key'] ?? ''); ?></td>
                        <td><a href="?page=borderless-manage-google" class="button button-primary">Manage</a></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}

function borderless_manage_openai_page_callback() {
    ?>
    <div class="wrap">
        <h1>Manage OpenAI</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('borderless_openai_settings_group');
                do_settings_sections('borderless-openai-settings');
            ?>
            <p class="submit">
                <?php submit_button('Save Changes', 'primary', 'submit', false); ?>
                <a href="?page=borderless-global-settings&tab=integrations" class="button">← Back to Integrations</a>
            </p>
        </form>
    </div>
    <?php
}

function borderless_manage_google_page_callback() {
    ?>
    <div class="wrap">
        <h1>Manage Google Gemini</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('borderless_google_settings_group');
                do_settings_sections('borderless-google-settings');
            ?>
            <p class="submit">
                <?php submit_button('Save Changes', 'primary', 'submit', false); ?>
                <a href="?page=borderless-global-settings&tab=integrations" class="button">← Back to Integrations</a>
            </p>
        </form>
    </div>
    <?php
}
