<?php
namespace Elementwoo\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class widget2 extends Widget_Base {

    public function get_name() {
        return 'title-subtitle2';
    }

    public function get_title() {
        return 'WooPlugin - link tool';
    }

    public function get_icon() {
        return 'fa fa-font';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_title',
            [
                'label' => __( 'Content', 'elementor' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter your title', 'elementor' ),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link', 'elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'elementor' ),
                'default' => [
                    'url' => '',
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        $url = $settings['link']['url'];
        echo  "<a href='$url'><div class='title'>$settings[title]</div> </a>";


    }

}