<?php
namespace SimpleUserCRM\Admin;

use SimpleUserCRM\Core\Constants;

defined('ABSPATH') || exit;

class MenuPage
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'register_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_menu(): void
    {
        add_menu_page(
            esc_html__('Cài đặt CRM', Constants::TEXT_DOMAIN),
            esc_html__('CRM Settings', Constants::TEXT_DOMAIN),
            'manage_options',
            'su_crm_settings',
            [$this, 'render_settings_page'],
            'dashicons-admin-users',
            56
        );
    }

    public function render_settings_page(): void
    {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Cài đặt Simple User CRM', Constants::TEXT_DOMAIN); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('su_crm_settings_group');
                do_settings_sections('su_crm_settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register_settings(): void
    {
        add_settings_section(
            'su_crm_page_section',
            esc_html__('Trang Plugin', Constants::TEXT_DOMAIN),
            '',
            'su_crm_settings'
        );

        add_settings_field(
            Constants::KEY_OPTION_REGISTER_PAGE,
            esc_html__('Trang đăng ký học viên', Constants::TEXT_DOMAIN),
            [$this, 'render_page_dropdown'],
            'su_crm_settings',
            'su_crm_page_section'
        );

        register_setting('su_crm_settings_group', Constants::KEY_OPTION_REGISTER_PAGE);
    }

    public function render_page_dropdown(): void
    {
        $selected = get_option(Constants::KEY_OPTION_REGISTER_PAGE);
        wp_dropdown_pages([
            'name'              => Constants::KEY_OPTION_REGISTER_PAGE,
            'selected'          => $selected,
            'show_option_none'  => esc_html__('— Chọn một trang —', Constants::TEXT_DOMAIN),
            'option_none_value' => '',
        ]);
    }
}