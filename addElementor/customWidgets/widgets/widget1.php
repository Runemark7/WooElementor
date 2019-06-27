<?php
/**
 * Product widget class
 *
 * @package Elementwoo
 */
namespace Elementwoo\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class widget1 extends Widget_Base {

    public function get_name() {
        return 'elementwoo-products';
    }

    public function get_title() {
        return 'WooPlugin - Products';
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function get_keywords() {
        return ['products', 'product', 'woocommerce', 'ecommerce'];
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'query',
            [
                'label' => __( 'Query', 'elementwoo' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => __( 'Query Type', 'elementwoo' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'all'  => __( 'All', 'elementwoo' ),
                    'featured' => __( 'Featured', 'elementwoo' ),
                    'best_selling' => __( 'Best Selling', 'elementwoo' ),
                    'on_sale'  => __( 'On Sale', 'elementwoo' ),
                    'top_rated' => __( 'Top Rated', 'elementwoo' ),
                    'custom' => __( 'Custom', 'elementwoo' ),
                ],
                'default' => 'all',
                'description' => __( 'Select query type first and based on query type you will get more query settings to fine tune your query.', 'elementwoo' ),
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => __( 'Products Per Page', 'elementwoo' ),
                'type' => Controls_Manager::TEXT,
                'default' => 6,
                'description' => __( 'Set number of products you want to show per page. For all products set -1.', 'elementwoo' ),
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'type',
                            'operator' => '!=',
                            'value' => 'ids',
                        ],
                    ],
                ]
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => __( 'Categories', 'elementwoo' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => false,
                'multiple' => true,
                'description' => __( 'Select categories by typing category name. You can select multiple categories.', 'elementwoo' ),
                'options' => elementwoo_get_product_categories(),
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'type',
                            'operator' => '!in',
                            'value' => [ 'all', 'ids' ]
                        ],
                    ],
                ]
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label' => __( 'Category Rule', 'elementwoo' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'AND' => [
                        'title' => __( 'AND (Will display products that belong in all of the chosen categories).', 'elementwoo' ),
                        'icon' => 'fa fa-asterisk',
                    ],
                    'IN' => [
                        'title' => __( 'IN (Will display products within the chosen category).', 'elementwoo' ),
                        'icon' => 'fa fa-circle-o',
                    ],
                    'NOT IN' => [
                        'title' => __( 'NOT IN (Will display products that are not in the chosen category).', 'elementwoo' ),
                        'icon' => 'fa fa-minus',
                    ],
                ],
                'default' => 'IN',
                'description' => __( 'Mouse over on the rule icon to see the rule details.', 'elementwoo' ),
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'type',
                            'operator' => '!in',
                            'value' => [ 'all', 'ids' ]
                        ],
                        [
                            'name' => 'category',
                            'operator' => '!=',
                            'value' => ''
                        ],
                    ],
                ]
            ]
        );

        $this->add_control(
            'tag',
            [
                'label' => __( 'Tags', 'elementwoo' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => false,
                'multiple' => true,
                'description' => __( 'Select tags by typing tags name. You can select multiple tags.', 'elementwoo' ),
                'options' => elementwoo_get_product_tags(),
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'type',
                            'operator' => '=',
                            'value' => 'custom'
                        ],
                    ],
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'query_advance',
            [
                'label' => __( 'Advance', 'elementwoo' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __( 'Order By', 'elementwoo' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'date'  => __( 'Date', 'elementwoo' ),
                    'id' => __( 'Product ID', 'elementwoo' ),
                    'menu_order' => __( 'Menu Order', 'elementwoo' ),
                    'popularity' => __( 'Popularity', 'elementwoo' ),
                    'rand' => __( 'Random', 'elementwoo' ),
                    'rating' => __( 'Rating', 'elementwoo' ),
                    'title' => __( 'Title', 'elementwoo' ),
                ],
                'default' => 'title',
                'description' => __( 'Select how you want to order your product, based on title or something else.', 'elementwoo' ),
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __( 'Order', 'elementwoo' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'ASC' => [
                        'title' =>  __( 'Ascending', 'elementwoo' ),
                        'icon' => 'fa fa-sort-alpha-asc',
                    ],
                    'DESC' => [
                        'title' => __( 'Descending', 'elementwoo' ),
                        'icon' => 'fa fa-sort-alpha-desc',
                    ],
                ],
                'default' => 'ASC',
                'description' => __( 'Select an order, either ascending or descending.', 'elementwoo' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'layout',
            [
                'label' => __( 'Layout', 'elementwoo' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __( 'Columns', 'elementwoo' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 6,
                'step' => 1,
                'default' => wc_get_default_products_per_row(),
                'description' => __( 'Set number of columns for products layout.', 'elementwoo' ),
            ]
        );

        $this->add_control(
            'paginate',
            [
                'label' => __( 'Pagination', 'elementwoo' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'no' => [
                        'title' => __( 'Disable pagination', 'elementwoo' ),
                        'icon' => 'fa fa-close',
                    ],
                    'yes' => [
                        'title' => __( 'Enable pagination', 'elementwoo' ),
                        'icon' => 'fa fa-check',
                    ],
                ],
                'default' => 'no',
                'description' => __( 'Enable pagination for products, pagination depends on Limit.', 'elementwoo' ),
            ]
        );

        $this->end_controls_section();

    }

    protected function parse_query_args() {
        $args = $this->get_settings_for_display();
        $query_args = [];
        $VALID_ARGS = [
            'type',
            'limit',
            'columns',
            'paginate',
            'orderby',
            'order',
            'category',
            'cat_operator',
            'tag',
            'ids',
        ];

        foreach ( $VALID_ARGS as $ARG_KEY ) {
            if ( empty( $args[ $ARG_KEY ] ) ) {
                continue;
            }

            switch( $ARG_KEY ) {
                case 'type':
                    if ( in_array( $args[ $ARG_KEY ], [ 'best_selling', 'on_sale', 'top_rated' ] ) ) {
                        $query_args[ $args[ $ARG_KEY ] ] = 'true';
                    } elseif ( $args[ $ARG_KEY ] === 'featured' ) {
                        $query_args['visibility'] = 'featured';
                    }
                    break;

                case 'ids':
                case 'tag':
                case 'category':
                    $query_args[ $ARG_KEY ] = elementwoo_comma_val_from_array( $args[ $ARG_KEY ] );
                    break;

                case 'paginate':
                    $query_args[ $ARG_KEY ] = elementwoo_bool_from_yn( $args[ $ARG_KEY ] );
                    break;

                default:
                    $query_args[ $ARG_KEY ] = $args[ $ARG_KEY ];
                    break;
            }
        }

        return $query_args;
    }

    protected function render() {
        $args = $this->parse_query_args();
        echo elementwoo_do_shortcode( 'products', $args );
    }
}
