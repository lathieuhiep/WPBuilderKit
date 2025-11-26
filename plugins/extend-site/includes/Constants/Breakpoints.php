<?php

namespace ExtendSite\Constants;

defined('ABSPATH') || exit;

class Breakpoints
{
    public const SM = 576;
    public const MD = 768;
    public const LG = 992;
    public const XL = 1200;

    public static function map(): array
    {
        return [
            'sm' => self::SM,
            'md' => self::MD,
            'lg' => self::LG,
            'xl' => self::XL
        ];
    }
}