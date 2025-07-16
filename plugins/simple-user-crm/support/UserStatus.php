<?php
namespace SimpleUserCRM\Support;

use SimpleUserCRM\Constants\PluginConstants;

defined('ABSPATH') || exit;

class UserStatus
{
    public const PENDING   = 'pending';
    public const APPROVED  = 'approved';
    public const CONVERTED = 'converted';
    public const REJECTED  = 'rejected';
    public const ARCHIVED  = 'archived';

    public static function getLabel(string $status): string
    {
        return match ($status) {
            self::PENDING   => esc_html__('Chờ duyệt', PluginConstants::TEXT_DOMAIN),
            self::APPROVED  => esc_html__('Đã duyệt', PluginConstants::TEXT_DOMAIN),
            self::CONVERTED => esc_html__('Đã tạo tài khoản', PluginConstants::TEXT_DOMAIN),
            self::REJECTED  => esc_html__('Từ chối', PluginConstants::TEXT_DOMAIN),
            self::ARCHIVED  => esc_html__('Lưu trữ', PluginConstants::TEXT_DOMAIN),
            default         => esc_html__('Không xác định', PluginConstants::TEXT_DOMAIN),
        };
    }

    public static function getBadgeClass(string $status): string
    {
        return match ($status) {
            self::PENDING   => 'secondary',
            self::APPROVED  => 'primary',
            self::CONVERTED => 'success',
            self::REJECTED  => 'danger',
            self::ARCHIVED  => 'dark',
            default         => 'light',
        };
    }

    public static function all(): array
    {
        return [
            self::PENDING   => self::getLabel(self::PENDING),
            self::APPROVED  => self::getLabel(self::APPROVED),
            self::CONVERTED => self::getLabel(self::CONVERTED),
            self::REJECTED  => self::getLabel(self::REJECTED),
            self::ARCHIVED  => self::getLabel(self::ARCHIVED),
        ];
    }
}