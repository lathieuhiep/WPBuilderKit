<?php
use SimpleUserCRM\Constants\PluginConstants;
?>
<div class="su-crm-app">
    <?php include PluginConstants::path() . 'admin/view/layout/sidebar.php'; ?>

    <main class="main-warp">
        <?= $content ?? '<p>Không có nội dung.</p>'; ?>
    </main>
</div>
