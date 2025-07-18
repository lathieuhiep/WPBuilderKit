<?php

use SimpleUserCRM\Admin\Layout;
use SimpleUserCRM\Constants\PluginConstants;
use SimpleUserCRM\Repositories\UserRepository;
use SimpleUserCRM\Support\Helpers;
use SimpleUserCRM\Support\UserStatus;

// get filter inputs
$filter_input = [
    'full_name' => trim($_GET['full_name'] ?? ''),
    'email' => trim($_GET['email'] ?? ''),
    'phone' => trim($_GET['phone'] ?? ''),
    'created_from' => trim($_GET['created_from'] ?? ''),
    'created_to' => trim($_GET['created_to'] ?? ''),
    'status' => trim($_GET['status'] ?? ''),
];

// parameters for filtering users
$filters = [];
$filter_labels = [];

// filter by full name
if ($filter_input['full_name'] !== '') {
    $filters[] = ['column' => 'full_name', 'op' => 'LIKE', 'value' => '%' . $filter_input['full_name'] . '%'];

    $filter_labels[] = [
        'label' => esc_html__('Họ tên', PluginConstants::TEXT_DOMAIN),
        'value' => $filter_input['full_name'],
        'remove_url' => remove_query_arg('full_name'),
    ];
}

// filter by email
if ($filter_input['email'] !== '') {
    $filters[] = ['column' => 'email', 'op' => 'LIKE', 'value' => '%' . $filter_input['email'] . '%'];

    $filter_labels[] = [
        'label' => esc_html__('Email', PluginConstants::TEXT_DOMAIN),
        'value' => $filter_input['email'],
        'remove_url' => remove_query_arg('email'),
    ];
}

// filter by phone
if ($filter_input['phone'] !== '') {
    $filters[] = ['column' => 'phone', 'op' => 'LIKE', 'value' => '%' . $filter_input['phone'] . '%'];

    $filter_labels[] = [
        'label' => esc_html__('Số điện thoại', PluginConstants::TEXT_DOMAIN),
        'value' => $filter_input['phone'],
        'remove_url' => remove_query_arg('phone'),
    ];
}

// filter by created date
if ($filter_input['created_from'] && $filter_input['created_to']) {
    $filters[] = [
        'column' => 'created_at',
        'op' => 'BETWEEN',
        'value' => [$filter_input['created_from'], $filter_input['created_to']],
    ];

    $filter_labels[] = [
        'label' => esc_html__('Từ ngày', PluginConstants::TEXT_DOMAIN),
        'value' => Helpers::format_date($filter_input['created_from']) . ' - ' . Helpers::format_date($filter_input['created_to']),
        'remove_url' => remove_query_arg(['created_from', 'created_to']),
    ];
} elseif ($filter_input['created_from']) {
    $filters[] = [
        'column' => 'created_at',
        'op' => '>=',
        'value' => $filter_input['created_from'],
    ];

    $filter_labels[] = [
        'label' => esc_html__('Sau ngày', PluginConstants::TEXT_DOMAIN),
        'value' => Helpers::format_date($filter_input['created_from']),
        'remove_url' => remove_query_arg('created_from'),
    ];
} elseif ($filter_input['created_to']) {
    $filters[] = [
        'column' => 'created_at',
        'op' => '<=',
        'value' => $filter_input['created_to'],
    ];

    $filter_labels[] = [
        'label' => esc_html__('Trước ngày', PluginConstants::TEXT_DOMAIN),
        'value' => Helpers::format_date($filter_input['created_to']),
        'remove_url' => remove_query_arg('created_to'),
    ];
}

// filter by status
if ($filter_input['status'] !== '') {
    $filters[] = ['column' => 'status', 'op' => '=', 'value' => $filter_input['status']];

    $filter_labels[] = [
        'label' => esc_html__('Trạng thái', PluginConstants::TEXT_DOMAIN),
        'value' => UserStatus::get_label($filter_input['status']),
        'remove_url' => remove_query_arg('status'),
    ];
}

// get total users
$total = UserRepository::count($filters);

// get pagination data
$pagination = Helpers::get_pagination_data($total);

// get list of users
$users = UserRepository::list($pagination['offset'], $filters);
?>

    <header class="content-header">
        <h1 class="page-title">
            <?php esc_html_e('Danh sách người đăng ký', PluginConstants::TEXT_DOMAIN); ?>
        </h1>

        <div class="actions">
            <a href="#" class="btn btn-primary">+ <?php esc_html_e('Thêm mới', PluginConstants::TEXT_DOMAIN); ?></a>
        </div>
    </header>

<?php
$view_base = 'partials/user/';

Layout::render_partial($view_base . 'list-filters', [
    'input' => $filter_input,
    'statuses' => UserStatus::all(),
    'filter_labels' => $filter_labels,
]);

Layout::render_partial($view_base . 'list-table', [
    'users' => $users,
    'pagination' => $pagination,
]);