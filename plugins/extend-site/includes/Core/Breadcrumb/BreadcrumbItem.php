<?php

namespace ExtendSite\Core\Breadcrumb;

defined('ABSPATH') || exit;

final class BreadcrumbItem
{
    public string $label;
    public ?string $url;
    public ?int $id;
    public string $type;

    /**
     * Khởi tạo một mục breadcrumb mới
     *
     * @param string $label Nhãn hiển thị của mục breadcrumb
     * @param string|null $url URL liên kết (null nếu là trang hiện tại)
     * @param int|null $id ID của đối tượng liên quan (bài viết, trang, term...)
     * @param string $type Loại mục breadcrumb (page, post, term, custom...)
     */
    public function __construct(
        string  $label,
        ?string $url = null,
        ?int    $id = null,
        string  $type = 'custom'
    )
    {
        // Áp dụng filter cho phép thay đổi label (Ví dụ: Đổi "Trang chủ" thành icon home)
        $this->label = (string)apply_filters('extend_site_breadcrumb_item_label', $label, $id, $type);

        // Đảm bảo URL sạch
        $this->url = $url;
        $this->id = $id;
        $this->type = $type;
    }

    /**
     * Chuyển đổi đối tượng sang mảng
     */
    public function to_array(): array
    {
        return [
            'label' => $this->label,
            'url' => $this->url,
            'id' => $this->id,
            'type' => $this->type,
        ];
    }
}