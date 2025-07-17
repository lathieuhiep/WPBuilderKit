<?php

use SimpleUserCRM\Constants\PluginConstants;
use SimpleUserCRM\Support\Helpers;

/**
 * @var array $input
 * @var array $statuses
 */

$filter_labels = [];

// show filter labels full name
if ($input['full_name'] !== '') {
    $filter_labels[] = [
        'label' => esc_html__('Họ tên:', PluginConstants::TEXT_DOMAIN) . ' <span class="highlight-text">“' . esc_html($input['full_name']) . '”</span>',
        'remove_url' => remove_query_arg('full_name'),
    ];
}

// show filter labels email
if ($input['email'] !== '') {
    $filter_labels[] = [
        'label' => esc_html__('Email:', PluginConstants::TEXT_DOMAIN) . ' <span class="highlight-text">“' . esc_html($input['email']) . '”</span>',
        'remove_url' => remove_query_arg('email'),
    ];
}

// show filter labels phone
if ($input['phone'] !== '') {
    $filter_labels[] = [
        'label' => esc_html__('Số điện thoại:', PluginConstants::TEXT_DOMAIN) . ' <span class="highlight-text">“' . esc_html($input['phone']) . '”</span>',
        'remove_url' => remove_query_arg('phone'),
    ];
}

// show filter labels created date
$from = $input['created_from'];
$to   = $input['created_to'];

if ( $from && $to ) {
    $filter_labels[] = [
        'label' => esc_html__('Ngày tạo từ', PluginConstants::TEXT_DOMAIN) . ' <span class="highlight-text">' . esc_html(Helpers::format_date($from)) . '</span> '. esc_html__('đến', PluginConstants::TEXT_DOMAIN) .' <span class="highlight-text">' . esc_html(Helpers::format_date($to)) . '</span>',
        'remove_url' => remove_query_arg(['created_from', 'created_to']),
    ];
} elseif ( $from ) {
    $filter_labels[] = [
        'label' => esc_html__('Ngày tạo từ', PluginConstants::TEXT_DOMAIN) . ' <span class="highlight-text">' . esc_html(Helpers::format_date($from)) . '</span>',
        'remove_url' => remove_query_arg('created_from'),
    ];
} elseif ( $to ) {
    $filter_labels[] = [
        'label' => esc_html__('Ngày tạo đến', PluginConstants::TEXT_DOMAIN) . ' <span class="highlight-text">' . esc_html(Helpers::format_date($to)) . '</span>',
        'remove_url' => remove_query_arg('created_to'),
    ];
}

// show filter labels status
if ($input['status'] !== '') {
    $filter_labels[] = [
        'label' => esc_html__('Trạng thái:', PluginConstants::TEXT_DOMAIN) . ' <span class="highlight-text">“' . esc_html($statuses[$input['status']] ?? $input['status']) . '”</span>',
        'remove_url' => remove_query_arg('status'),
    ];
}
?>

<div class="content-filters grid-y-3">
    <!-- Filter form -->
    <form method="get" class="crm-form filter-form">
        <input type="hidden" name="page" value="<?php echo esc_attr($_GET['page'] ?? ''); ?>"/>

        <div class="filter-fields">
            <!-- full name -->
            <div class="field-box">
                <label for="filter_full_name">
                    <strong><?php esc_html_e('Họ tên', PluginConstants::TEXT_DOMAIN); ?></strong>
                </label>

                <input type="text"
                       id="filter_full_name"
                       class="form-control"
                       name="full_name"
                       value="<?php echo esc_attr($input['full_name'] ?? ''); ?>"
                       placeholder="<?php esc_attr_e('Nhập họ tên...', PluginConstants::TEXT_DOMAIN); ?>"
                />
            </div>

            <!-- email -->
            <div class="field-box">
                <label for="filter_email">
                    <strong><?php esc_html_e('Email', PluginConstants::TEXT_DOMAIN); ?></strong>
                </label>

                <input type="text"
                       id="filter_email"
                       class="form-control"
                       name="email"
                       value="<?php echo esc_attr($input['email'] ?? ''); ?>"
                       placeholder="<?php esc_attr_e('Nhập email...', PluginConstants::TEXT_DOMAIN); ?>"
                />
            </div>

            <!-- phone -->
            <div class="field-box">
                <label for="filter_phone">
                    <strong><?php esc_html_e('Số điện thoại', PluginConstants::TEXT_DOMAIN); ?></strong>
                </label>

                <input type="text"
                       id="filter_phone"
                       class="form-control"
                       name="phone"
                       value="<?php echo esc_attr($input['phone'] ?? ''); ?>"
                       placeholder="<?php esc_attr_e('Nhập số điện thoại...', PluginConstants::TEXT_DOMAIN); ?>"
                />
            </div>

            <!-- created to -->
            <div class="field-box field-box-between">
                <div class="item">
                    <label for="filter_created_from">
                        <strong><?php esc_html_e('Ngày tạo từ', PluginConstants::TEXT_DOMAIN); ?></strong>
                    </label>

                    <input type="date"
                           id="filter_created_from"
                           class="form-control"
                           name="created_from"
                           value="<?php echo esc_attr($input['created_from'] ?? ''); ?>"
                           placeholder="<?php esc_attr_e('Ngày bắt đầu...', PluginConstants::TEXT_DOMAIN); ?>"
                    />
                </div>

                <div class="item">
                    <label for="filter_created_to">
                        <strong><?php esc_html_e('Đến ngày', PluginConstants::TEXT_DOMAIN); ?></strong>
                    </label>

                    <input type="date"
                           id="filter_created_to"
                           class="form-control"
                           name="created_to"
                           value="<?php echo esc_attr($input['created_to'] ?? ''); ?>"
                           placeholder="<?php esc_attr_e('Đến ngày...', PluginConstants::TEXT_DOMAIN); ?>"
                    />
                </div>
            </div>

            <!-- status -->
            <div class="field-box">
                <label for="filter_status">
                    <strong><?php esc_html_e('Trạng thái', PluginConstants::TEXT_DOMAIN); ?></strong>
                </label>

                <select id="filter_status" class="form-control" name="status">
                    <option value=""><?php esc_html_e('-- Tất cả --', PluginConstants::TEXT_DOMAIN); ?></option>

                    <?php foreach ($statuses as $value => $label) : ?>
                        <option value="<?php echo esc_attr($value); ?>" <?= selected($input['status'], $value, false); ?>>
                            <?php echo esc_html($label); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="action-box">
            <button type="submit" class="btn btn-filter form-control">
                <?php esc_html_e('Tìm kiếm', PluginConstants::TEXT_DOMAIN); ?>
            </button>
        </div>
    </form>

    <!-- Filter tags -->
    <?php if (!empty($filter_labels)): ?>
        <div class="filter-tags">
            <strong><?php esc_html_e('Đang lọc theo:', PluginConstants::TEXT_DOMAIN); ?></strong>

            <div class="tag-list">
                <?php foreach ($filter_labels as $tag): ?>
                    <div class="tag">
                        <span><?= $tag['label'] ?></span>
                        <a href="<?= esc_url($tag['remove_url']) ?>" class="remove">&#10005;</a>
                    </div>
                <?php endforeach; ?>
            </div>

            <a href="<?= esc_url(remove_query_arg(array_keys($input))) ?>" class="reset-all">
                <?php esc_html_e('Xóa tất cả', PluginConstants::TEXT_DOMAIN); ?>
            </a>
        </div>
    <?php endif; ?>
</div>