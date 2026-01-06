<?php
/**
 * View template cho trang cấu hình Breadcrumb.
 * * @var string $title       Được truyền từ BreadcrumbAdmin
 * @var string $description Được truyền từ BreadcrumbAdmin
 */

defined('ABSPATH') || exit;
?>

<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html($title); ?></h1>
    <p class="description"><?php echo esc_html($description); ?></p>
    <hr class="wp-header-end">

    <form method="post" action="options.php">
        <?php
        // Hiển thị các hidden field cần thiết cho Settings API (nonce, v.v.)
        settings_fields('es_breadcrumb_group');

        // Hiển thị các Section và Field đã đăng ký trong register_settings()
        do_settings_sections('es-breadcrumb');
        ?>

        <div>
            <?php
            // Nút lưu thay đổi mặc định của WordPress
            submit_button(esc_html__('Lưu thay đổi', 'extend-site'));
            ?>
        </div>
    </form>
</div>