<?php
use SimpleUserCRM\Admin\Layout;
use SimpleUserCRM\Constants\PluginConstants;
use SimpleUserCRM\Repositories\UserRepository;
use SimpleUserCRM\Support\Helpers;
use SimpleUserCRM\Support\UserStatus;

// get filter inputs
$filter_input = [
    'full_name' => trim($_GET['full_name'] ?? ''),
    'email'     => trim($_GET['email'] ?? ''),
    'phone'     => trim($_GET['phone'] ?? ''),
    'created_from' => trim($_GET['created_from'] ?? ''),
    'created_to'   => trim($_GET['created_to'] ?? ''),
    'status'    => trim($_GET['status'] ?? ''),
];

// parameters for filtering users
$filters = [];

if ($filter_input['full_name'] !== '') {
    $filters[] = ['column' => 'full_name', 'op' => 'LIKE', 'value' => '%' . $filter_input['full_name'] . '%'];
}

if ($filter_input['email'] !== '') {
    $filters[] = ['column' => 'email', 'op' => 'LIKE', 'value' => '%' . $filter_input['email'] . '%'];
}

if ($filter_input['phone'] !== '') {
    $filters[] = ['column' => 'phone', 'op' => 'LIKE', 'value' => '%' . $filter_input['phone'] . '%'];
}

if ($filter_input['created_from'] && $filter_input['created_to']) {
    $filters[] = [
        'column' => 'created_at',
        'op'     => 'BETWEEN',
        'value'  => [$filter_input['created_from'], $filter_input['created_to']],
    ];
} elseif ($filter_input['created_from']) {
    $filters[] = [
        'column' => 'created_at',
        'op'     => '>=',
        'value'  => $filter_input['created_from'],
    ];
} elseif ($filter_input['created_to']) {
    $filters[] = [
        'column' => 'created_at',
        'op'     => '<=',
        'value'  => $filter_input['created_to'],
    ];
}

if ($filter_input['status'] !== '') {
    $filters[] = ['column' => 'status', 'op' => '=', 'value' => $filter_input['status']];
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
    'statuses' => UserStatus::all()
]);

Layout::render_partial($view_base . 'list-table', [
    'users' => $users,
    'pagination' => $pagination,
]);