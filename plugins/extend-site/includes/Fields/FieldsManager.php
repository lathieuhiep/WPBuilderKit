<?php
namespace ExtendSite\Fields;

use ExtendSite\Fields\Post\SubtitleFields;

defined('ABSPATH') || exit;

class FieldsManager
{
    public static function boot(): void
    {
        // Initialize individual field groups
        SubtitleFields::boot();
        // You can add more field groups here as needed
    }
}