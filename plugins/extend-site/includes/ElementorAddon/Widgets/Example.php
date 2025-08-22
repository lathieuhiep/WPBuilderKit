<?php

namespace ExtendSite\ElementorAddon\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

defined('ABSPATH') || exit;

class Example extends Widget_Base
{

    public function get_name()
    {
        // TODO: Implement get_name() method.
    }

    public function get_title(): string
    {
        return esc_html__('Example Widget', 'extend-site');
    }

    public function get_icon(): string
    {
        return 'eicon-code';
    }

    public function get_categories(): array
    {
        return ['extend-site-addons'];
    }

    protected function register_controls(): void
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'extend-site'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'text',
            [
                'label'   => esc_html__('Text', 'extend-site'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Hello, World!', 'extend-site'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        echo '<div class="example-widget">';
        echo esc_html($settings['text']);
        echo '</div>';
    }

    protected function _content_template(): void
    {
        ?>
        <div class="example-widget">
            {{{ settings.text }}}
        </div>
        <?php
    }
}