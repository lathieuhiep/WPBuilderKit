<?php
use SimpleUserCRM\Admin\MenuPage;
use SimpleUserCRM\Constants\PluginConstants;

?>

<aside class="su-crm-sidebar">
    <h2 class="logo">Simple User CRM</h2>

    <nav class="nav-main">
        <ul>
            <?php
            foreach ( MenuPage::crm_pages() as $value ):
                $is_active = ( $_GET['page'] ?? '' ) === $value['slug'] ? 'active' : '';
            ?>
                <li class="<?= esc_attr($is_active) ?>">
                    <a href="<?php echo admin_url('admin.php?page=' . $value['slug']); ?>">
                        <?= esc_html__( $value['title'], PluginConstants::TEXT_DOMAIN ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <div class="action-box">
        <a class="back-to-admin" href="<?= esc_url(admin_url()) ?>">
            ← Trở về bảng quản trị WP
        </a>
    </div>
</aside>