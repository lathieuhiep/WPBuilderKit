<?php
use SimpleUserCRM\Constants\PluginConstants;
use SimpleUserCRM\Support\Helpers;
use SimpleUserCRM\Support\UserStatus;

/**
 * @var array $users
 * @var array $pagination
 */
?>

<div class="content-table">
    <div class="table-wrapper">
        <table class="tbl tbl-user">
            <thead>
            <tr>
                <th class="stt">#</th>
                <th class="full-name"><?php esc_html_e('Họ tên', PluginConstants::TEXT_DOMAIN); ?></th>
                <th class="email"><?php esc_html_e('Email', PluginConstants::TEXT_DOMAIN); ?></th>
                <th class="phone"><?php esc_html_e('Điện thoại', PluginConstants::TEXT_DOMAIN); ?></th>
                <th class="date"><?php esc_html_e('Ngày sinh', PluginConstants::TEXT_DOMAIN); ?></th>
                <th class="address"><?php esc_html_e('Địa chỉ', PluginConstants::TEXT_DOMAIN); ?></th>
                <th class="referral-code"><?php esc_html_e('Mã giới thiệu', PluginConstants::TEXT_DOMAIN); ?></th>
                <th class="note"><?php esc_html_e('Ghi chú', PluginConstants::TEXT_DOMAIN); ?></th>
                <th class="status"><?php esc_html_e('Trạng thái', PluginConstants::TEXT_DOMAIN); ?></th>
                <th class="created-at"><?php esc_html_e('Ngày đăng ký', PluginConstants::TEXT_DOMAIN); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php
            if ( !empty( $users ) ) :
                foreach ($users as $index => $user):
                    ?>
                    <tr data-id="<?= esc_attr($user['id']); ?>">
                        <td class="su-fw"><?= esc_html($index + 1); ?></td>
                        <td><?= esc_html($user['full_name'] ?? '-') ?></td>
                        <td><?= esc_html($user['email'] ?? '-') ?></td>
                        <td><?= esc_html($user['phone'] ?? '-') ?></td>
                        <td>
                            <?= !empty($user['birth_date']) ? esc_html(date('d/m/Y', strtotime($user['birth_date']))) : '-' ?>
                        </td>
                        <td><?= esc_html($user['address'] ?? '-') ?></td>
                        <td><?= esc_html($user['referral_code'] ?? '-') ?></td>
                        <td><?= esc_html($user['note'] ?? '-') ?></td>
                        <td>
                            <span class="status-label <?= 'status-' . esc_html($user['status'] ?? '') ?>">
                                <?= esc_html( $user['status'] ? UserStatus::get_label( $user['status'] ) : '-') ?>
                            </span>
                        </td>
                        <td>
                            <?= !empty($user['created_at']) ? esc_html(date('d/m/Y', strtotime($user['created_at']))) : '-' ?>
                        </td>
                    </tr>
                <?php
                endforeach;

            else:
                ?>
                <tr>
                    <td colspan="10" class="text-align-center"><?php esc_html_e('Chưa có người đăng kí', PluginConstants::TEXT_DOMAIN); ?></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php Helpers::render_admin_pagination_links($pagination['total_pages'], $pagination['current_page']); ?>
</div>