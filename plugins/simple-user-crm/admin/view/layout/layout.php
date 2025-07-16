<?php
use SimpleUserCRM\Constants\PluginConstants;
?>
<div class="su-crm-app-layout">
    <?php include PluginConstants::path() . 'admin/view/layout/sidebar.php'; ?>

    <main class="main-content">
        <?= $content ?? '<p>Không có nội dung.</p>'; ?>
    </main>
</div>
