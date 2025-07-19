<?php
use SimpleUserCRM\Constants\PluginConstants;
use SimpleUserCRM\Core\ShortcodeRegistry;
?>

<header class="content-header">
    <h1 class="page-title">
        <?php esc_html_e('Thêm mới', PluginConstants::TEXT_DOMAIN); ?>
    </h1>
</header>

<div>
    <?php echo do_shortcode('[' . ShortcodeRegistry::get_shortcode_tag( ShortcodeRegistry::SHORTCODE_FORM_REGISTER ) . ']'); ?>
</div>