<?php

namespace SimpleUserCRM\Support;

use SimpleUserCRM\Constants\PluginConstants;

class Messages
{
    public string $msg_register_success;

    public function __construct()
    {
        $this->msg_register_success = __('Đăng ký thành công', PluginConstants::TEXT_DOMAIN);
    }
}