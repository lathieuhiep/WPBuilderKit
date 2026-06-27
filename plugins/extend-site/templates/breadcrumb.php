<?php
/**
 * Breadcrumb template.
 *
 * @var array $data
 */

use ExtendSite\Core\Breadcrumb\BreadcrumbItem;

defined('ABSPATH') || exit;

$items     = $data['items'] ?? [];
$options   = $data['options'] ?? [];
$separator = $options['separator'] ?? '>';

if (empty($items)) {
    return;
}
?>
<nav class="es-breadcrumb" aria-label="Breadcrumb">
    <ol class="es-breadcrumb__list" itemscope itemtype="https://schema.org/BreadcrumbList">
        <?php
        $total = count($items);
        foreach ($items as $index => $item) :
            if (!$item instanceof BreadcrumbItem) {
                continue;
            }

            $is_last  = ($index === $total - 1);
            $position = $index + 1;
            ?>
            <li class="es-breadcrumb__item"
                itemprop="itemListElement"
                itemscope
                itemtype="https://schema.org/ListItem"
            >
                <?php if ($item->url && !$is_last) : ?>
                    <a class="es-breadcrumb__link"
                       itemprop="item"
                       href="<?php echo esc_url($item->url); ?>">
                        <span itemprop="name"><?php echo esc_html($item->label); ?></span>
                    </a>
                <?php else : ?>
                    <span class="es-breadcrumb__current"
                          itemprop="name"
                          aria-current="page">
                        <?php echo esc_html($item->label); ?>
                    </span>
                    <link itemprop="item"
                          href="<?php echo esc_url(home_url(add_query_arg([], $GLOBALS['wp']->request))); ?>" />
                <?php endif; ?>

                <meta itemprop="position" content="<?php echo (int) $position; ?>" />

                <?php if (!$is_last) : ?>
                    <span class="es-breadcrumb__separator" aria-hidden="true">
                        <?php echo esc_html($separator); ?>
                    </span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>