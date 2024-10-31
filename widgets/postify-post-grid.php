<?php
namespace Elementor;
use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Postify_Post_Grid_Widget extends Widget_Base
{

    public function get_name()
    {
        return  'postify-post-grid-widget';
    }

    public function get_title()
    {
        return esc_html__('Grid', 'postify-for-elementor');
    }

    public function get_style_depends()
    {
        return [
            'postify-main'
        ];
    }

    public function get_icon()
    {
        return 'eicon-lightbox';
    }

    public function get_categories()
    {
        return ['postify-for-elementor'];
    }


    private function postify_get_all_post_categories($post_type)
    {

        $options = array();

        $taxonomy = 'category';

        if (!empty($taxonomy)) {
            // Get categories for post type.
            $terms = get_terms(
                array(
                    'taxonomy'   => $taxonomy,
                    'hide_empty' => false,
                )
            );
            if (!empty($terms)) {
                foreach ($terms as $term) {
                    if (isset($term)) {
                        if (isset($term->slug) && isset($term->name)) {
                            $options[$term->slug] = $term->name;
                        }
                    }
                }
            }
        }

        return $options;
    }

    public function _register_controls()
    {
        $this->postify_content_layout_options();
        $this->postify_content_query_options();

        $this->postify_style_layout_options();
        $this->postify_style_box_options();
        $this->postify_style_category_options();
        $this->postify_style_image_options();

        $this->postify_style_title_options();
        $this->postify_style_meta_options();
        $this->postify_style_content_options();
        $this->postify_style_readmore_options();
    }

    /**
     * Content Layout Options.
     */
    private function postify_content_layout_options()
    {

        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Layout', 'postify-for-elementor'),
            ]
        );

        $this->add_control(
            'grid_style',
            [
                'label' => __('Grid Style', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__('Layout 1', 'postify-for-elementor'),
                    '2' => esc_html__('Layout 2', 'postify-for-elementor'),
                    '3' => esc_html__('Layout 3', 'postify-for-elementor'),
                ],
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => __('Columns', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'prefix_class' => 'elementor-grid%s-',
                'frontend_available' => true,
                'selectors' => [
                    '.elementor-msie {{WRAPPER}} .elementor-portfolio-item' => 'width: calc( 100% / {{SIZE}} )',
                ],
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
            ]
        );

        $this->add_control(
            'show_category',
            [
                'label' => __('Category Badge', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'postify-for-elementor'),
                'label_off' => __('Hide', 'postify-for-elementor'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label' => __('Image', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'postify-for-elementor'),
                'label_off' => __('Hide', 'postify-for-elementor'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'post_thumbnail',
                'exclude' => ['custom'],
                'default' => 'full',
                'prefix_class' => 'post-thumbnail-size-',
                'condition' => [
                    'show_image' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('Title', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'postify-for-elementor'),
                'label_off' => __('Hide', 'postify-for-elementor'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => __('Title HTML Tag', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'meta_data',
            [
                'label' => __('Meta Data', 'postify-for-elementor'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => ['date', 'comments'],
                'multiple' => true,
                'options' => [
                    'author' => __('Author', 'postify-for-elementor'),
                    'date' => __('Date', 'postify-for-elementor'),
                    'categories' => __('Categories', 'postify-for-elementor'),
                    'comments' => __('Comments', 'postify-for-elementor'),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'meta_separator',
            [
                'label' => __('Separator Between', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '/',
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--meta span + span:before' => 'content: "{{VALUE}}"',
                ],
                'condition' => [
                    'meta_data!' => [],
                ],
            ]
        );


        $this->add_control(
            'show_excerpt',
            [
                'label' => __('Excerpt', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'postify-for-elementor'),
                'label_off' => __('Hide', 'postify-for-elementor'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => __('Excerpt Length', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                /** This filter is documented in wp-includes/formatting.php */
                'default' => apply_filters('excerpt_length', 25),
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'excerpt_append',
            [
                'label' => __('Excerpt Append', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '&hellip;',
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label' => __('Read More', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'postify-for-elementor'),
                'label_off' => __('Hide', 'postify-for-elementor'),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => __('Read More Text', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Read More »', 'postify-for-elementor'),
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'content_align',
            [
                'label' => __('Alignment', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'postify-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'postify-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'postify-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .postify__item' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Content Query Options.
     */
    private function postify_content_query_options()
    {

        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Query', 'postify-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Post categories
        $this->add_control(
            'post_categories',
            [
                'label'       => __('Categories', 'postify-for-elementor'),
                'label_block' => true,
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'multiple'    => true,
                'options'     => $this->postify_get_all_post_categories('post'),

            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => __('Advanced', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post_date',
                'options' => [
                    'post_date' => __('Date', 'postify-for-elementor'),
                    'post_title' => __('Title', 'postify-for-elementor'),
                    'rand' => __('Random', 'postify-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'postify-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc' => __('ASC', 'postify-for-elementor'),
                    'desc' => __('DESC', 'postify-for-elementor'),
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Style Layout Options.
     */
    private function postify_style_layout_options()
    {

        // Layout.
        $this->start_controls_section(
            'section_layout_style',
            [
                'label' => __('Layout', 'postify-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Columns margin.
        $this->add_control(
            'grid_style_columns_margin',
            [
                'label'     => __('Columns margin', 'postify-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 15,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}',

                ],
            ]
        );

        // Row margin.
        $this->add_control(
            'grid_style_rows_margin',
            [
                'label'     => __('Rows margin', 'postify-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 30,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Style Box Options.
     */
    private function postify_style_box_options()
    {

        // Box.
        $this->start_controls_section(
            'section_box',
            [
                'label' => __('Box', 'postify-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Image border radius.
        $this->add_control(
            'grid_box_border_width',
            [
                'label'      => __('Border Widget', 'postify-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .postify-grid-container .postify__item' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        // Border Radius.
        $this->add_control(
            'grid_style_border_radius',
            [
                'label'     => __('Border Radius', 'postify-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 0,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        // Box internal padding.
        $this->add_responsive_control(
            'grid_items_style_padding',
            [
                'label'      => __('Padding', 'postify-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .postify-grid-container .postify__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->start_controls_tabs('grid_button_style');

        // Normal tab.
        $this->start_controls_tab(
            'grid_button_style_normal',
            [
                'label'     => __('Normal', 'postify-for-elementor'),
            ]
        );

        // Normal background color.
        $this->add_control(
            'grid_button_style_normal_bg_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Background Color', 'postify-for-elementor'),
                'separator' => '',
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Normal border color.
        $this->add_control(
            'grid_button_style_normal_border_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Border Color', 'postify-for-elementor'),
                'separator' => '',
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        // Normal box shadow.
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'grid_button_style_normal_box_shadow',
                'selector'  => '{{WRAPPER}} .postify-grid-container .postify__item',
            ]
        );

        $this->end_controls_tab();

        // Hover tab.
        $this->start_controls_tab(
            'grid_button_style_hover',
            [
                'label'     => __('Hover', 'postify-for-elementor'),
            ]
        );

        // Hover background color.
        $this->add_control(
            'grid_button_style_hover_bg_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Background Color', 'postify-for-elementor'),
                'separator' => '',
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Hover border color.
        $this->add_control(
            'grid_button_style_hover_border_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Border Color', 'postify-for-elementor'),
                'separator' => '',
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        // Hover box shadow.
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'grid_button_style_hover_box_shadow',
                'selector'  => '{{WRAPPER}} .postify-grid-container .postify__item:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }



    /**
     * Style > Category Badge.
     */
    private function postify_style_category_options()
    {
        // Tab.
        $this->start_controls_section(
            'section_grid_category_style',
            [
                'label' => __('Category Badge', 'postify-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        // Category typography.
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'      => 'grid_category_style_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector'  => '{{WRAPPER}} .postify-grid-container .postify__item .postify__item--category a',
            ]
        );

        $this->start_controls_tabs('grid_category_color_style');

        // Normal tab.
        $this->start_controls_tab(
            'grid_category_style_normal',
            array(
                'label' => esc_html__('Normal', 'postify-for-elementor'),
            )
        );

        // Category color.
        $this->add_control(
            'grid_category_style_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Color', 'postify-for-elementor'),
                'global' => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item--category a' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Category background color.
        $this->add_control(
            'grid_category_style_background_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Background Color', 'postify-for-elementor'),
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item--category a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Category border color.
        $this->add_control(
            'grid_category_style_border_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Border Color', 'postify-for-elementor'),
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item--category a' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover tab.
        $this->start_controls_tab(
            'grid_category_style_color_hover_tab',
            array(
                'label' => esc_html__('Hover', 'postify-for-elementor'),
            )
        );

        // Category hover color.
        $this->add_control(
            'grid_category_style_hover_color',
            array(
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => esc_html__('Color', 'postify-for-elementor'),
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => array(
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item--category a:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        // Category hover background color.
        $this->add_control(
            'grid_category_style_hover_background_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Background Color', 'postify-for-elementor'),
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item--category a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Category hover border color.
        $this->add_control(
            'grid_category_style_hover_border_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Border Color', 'postify-for-elementor'),
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item--category a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Category border width.
        $this->add_control(
            'grid_category_style_border_width',
            [
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'label'      => __('Border Width', 'postify-for-elementor'),
                'separator'  => 'before',
                'size_units' => array('px'),
                'selectors'  => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item--category a' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        // Category border radius.
        $this->add_control(
            'grid_category_style_border_radius',
            array(
                'label'     => esc_html__('Border Radius', 'postify-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'default'   => array(
                    'size' => 0,
                ),
                'range'     => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item--category a' => 'border-radius: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        // Category button padding.
        $this->add_responsive_control(
            'grid_category_style_button_padding',
            array(
                'label'      => esc_html__('Padding', 'postify-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px'),
                'selectors'  => array(
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item--category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ),
            )
        );

        // Category margin.
        $this->add_responsive_control(
            'grid_category_style_margin',
            [
                'label'      => __('Margin', 'postify-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item--category a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Style Image Options.
     */
    private function postify_style_image_options()
    {

        // Box.
        $this->start_controls_section(
            'section_image',
            [
                'label' => __('Image', 'postify-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Image border radius.
        $this->add_control(
            'grid_image_border_radius',
            [
                'label'      => __('Border Radius', 'postify-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .postify__item .postify__item--thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid_style_image_margin',
            [
                'label'      => __('Margin', 'postify-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .postify__item .postify__item--thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Style > Title.
     */
    private function postify_style_title_options()
    {
        // Tab.
        $this->start_controls_section(
            'section_grid_title_style',
            [
                'label'     => __('Title', 'postify-for-elementor'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Title typography.
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'grid_title_style_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--title, {{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--title a',
            ]
        );

        $this->start_controls_tabs('grid_title_color_style');

        // Normal tab.
        $this->start_controls_tab(
            'grid_title_style_normal',
            array(
                'label' => esc_html__('Normal', 'postify-for-elementor'),
            )
        );

        // Title color.
        $this->add_control(
            'grid_title_style_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Color', 'postify-for-elementor'),
                'global' => [
                    'default' => Global_Colors::COLOR_SECONDARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .title, {{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover tab.
        $this->start_controls_tab(
            'grid_title_style_hover',
            array(
                'label' => esc_html__('Hover', 'postify-for-elementor'),
            )
        );

        // Title hover color.
        $this->add_control(
            'grid_title_style_hover_color',
            array(
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => esc_html__('Color', 'postify-for-elementor'),
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => array(
                    '{{WRAPPER}} .postify-grid-container .postify__item .title, {{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--title a:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Title margin.
        $this->add_responsive_control(
            'grid_title_style_margin',
            [
                'label'      => __('Margin', 'postify-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .title, {{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--title a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Style > Meta.
     */
    private function postify_style_meta_options()
    {
        // Tab.
        $this->start_controls_section(
            'section_grid_meta_style',
            [
                'label'     => __('Meta', 'postify-for-elementor'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Meta typography.
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'grid_meta_style_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selector' => '{{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--meta span',
            ]
        );

        // Meta color.
        $this->add_control(
            'grid_meta_style_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Color', 'postify-for-elementor'),
                'global' => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--meta span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--meta span a' => 'color: {{VALUE}};',
                ],
            ]
        );

        

        // Meta margin.
        $this->add_responsive_control(
            'grid_meta_style_margin',
            [
                'label'      => __('Margin', 'postify-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Style > Content.
     */
    private function postify_style_content_options()
    {
        // Tab.
        $this->start_controls_section(
            'section_grid_content_style',
            [
                'label' => __('Content', 'postify-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Content typography.
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'      => 'grid_content_style_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selector'  => '{{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--description p',
            ]
        );

        // Content color.
        $this->add_control(
            'grid_content_style_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Color', 'postify-for-elementor'),
                'global' => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--description p' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Content margin
        $this->add_responsive_control(
            'grid_content_style_margin',
            [
                'label'      => __('Margin', 'postify-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__item__content--description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Style > Readmore.
     */
    private function postify_style_readmore_options()
    {
        // Tab.
        $this->start_controls_section(
            'section_grid_readmore_style',
            [
                'label' => __('Read More', 'postify-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        // Readmore typography.
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'      => 'grid_readmore_style_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector'  => '{{WRAPPER}} .postify-grid-container .postify__item .postify__btn a',
            ]
        );

        $this->start_controls_tabs('grid_readmore_color_style');

        // Normal tab.
        $this->start_controls_tab(
            'grid_readmore_style_normal',
            array(
                'label' => esc_html__('Normal', 'postify-for-elementor'),
            )
        );

        // Readmore color.
        $this->add_control(
            'grid_readmore_style_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Color', 'postify-for-elementor'),
                'global' => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__btn a' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Readmore background color.
        $this->add_control(
            'grid_readmore_style_background_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Background Color', 'postify-for-elementor'),
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__btn a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Readmore border color.
        $this->add_control(
            'grid_readmore_style_border_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Border Color', 'postify-for-elementor'),
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__btn a' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover tab.
        $this->start_controls_tab(
            'grid_readmore_style_color_hover_tab',
            array(
                'label' => esc_html__('Hover', 'postify-for-elementor'),
            )
        );

        // Readmore hover color.
        $this->add_control(
            'grid_readmore_style_hover_color',
            array(
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => esc_html__('Color', 'postify-for-elementor'),
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => array(
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__btn a:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        // Readmore hover background color.
        $this->add_control(
            'grid_readmore_style_hover_background_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Background Color', 'postify-for-elementor'),
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__btn a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Readmore hover border color.
        $this->add_control(
            'grid_readmore_style_hover_border_color',
            [
                'type'      => \Elementor\Controls_Manager::COLOR,
                'label'     => __('Border Color', 'postify-for-elementor'),
                'selectors' => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__btn a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Readmore border width.
        $this->add_control(
            'grid_readmore_style_border_width',
            [
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'label'      => __('Border Width', 'postify-for-elementor'),
                'separator'  => 'before',
                'size_units' => array('px'),
                'selectors'  => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__btn a' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        // Readmore border radius.
        $this->add_control(
            'grid_readmore_style_border_radius',
            array(
                'label'     => esc_html__('Border Radius', 'postify-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'default'   => array(
                    'size' => 0,
                ),
                'range'     => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__btn a' => 'border-radius: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        // Readmore button padding.
        $this->add_responsive_control(
            'grid_readmore_style_button_padding',
            array(
                'label'      => esc_html__('Padding', 'postify-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px'),
                'selectors'  => array(
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__btn a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ),
            )
        );

        // Readmore margin.
        $this->add_responsive_control(
            'grid_readmore_style_margin',
            [
                'label'      => __('Margin', 'postify-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .postify-grid-container .postify__item .postify__btn a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }



    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="postify-grid">
            <?php

            $grid_style = $settings['grid_style'];

            switch ($grid_style) {
                case "1":
                    $poatify_layout_class = 'postify1 ';
                    break;
                case "2":
                    $poatify_layout_class = 'postify2 ';
                    break;
                case "3":
                    $poatify_layout_class = 'postify3 ';
                    break;
                default:
            }

            ?>
            <div class="postify-grid-container elementor-grid <?php echo esc_attr($poatify_layout_class); ?>">
                <?php
                $posts_per_page = (!empty($settings['posts_per_page']) ?  $settings['posts_per_page'] : 3);
                $cats = is_array($settings['post_categories']) ? implode(',', $settings['post_categories']) : $settings['post_categories'];

                $query_args = array(
                    'posts_per_page'         => absint($posts_per_page),
                    'no_found_rows'          => true,
                    'post_status'             => 'publish',
                    'ignore_sticky_posts'   => true,
                    'category_name'         => $cats
                );

                // Order by.
                if (!empty($settings['orderby'])) {
                    $query_args['orderby'] = $settings['orderby'];
                }

                // Order .
                if (!empty($settings['order'])) {
                    $query_args['order'] = $settings['order'];
                }

                $all_posts = new \WP_Query($query_args);

                if ($all_posts->have_posts()) :
                    if (3 == $grid_style) {
                        include(__DIR__ . '/layouts/grid/layout-3.php');
                    } elseif (2 == $grid_style) {
                        include(__DIR__ . '/layouts/grid/layout-2.php');
                    } else {
                        include(__DIR__ . '/layouts/grid/layout-1.php');
                    }
                endif; ?>

            </div>
        </div>
        <?php
    }

    protected function render_thumbnail()
    {

        $settings = $this->get_settings();

        $show_image = $settings['show_image'];

        if ('yes' !== $show_image) {
            return;
        }

        $post_thumbnail_size = $settings['post_thumbnail_size'];

        if (has_post_thumbnail()) :  ?>
            <div class="postify__item--thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail($post_thumbnail_size); ?>
                </a>
            </div>
        <?php endif;
    }

    protected function render_title()
    {
        $settings = $this->get_settings();

        $show_title = $settings['show_title'];

        if ('yes' !== $show_title) {
            return;
        }

        $title_tag = $settings['title_tag'];

        ?>
        <div class="postify__item__content--title">
            <<?php echo esc_html($title_tag); ?>>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </<?php echo esc_html($title_tag); ?>>
        </div>
    <?php
    }



    protected function render_meta()
    {

        $settings = $this->get_settings();

        $meta_data = $settings['meta_data'];

        if (empty($meta_data)) {
            return;
        }

    ?>
        <div class="postify__item__content--meta">
            <?php
            if (in_array('author', $meta_data)) { ?>

                <span class="post-author"><?php the_author(); ?></span>

            <?php
            }

            if (in_array('date', $meta_data)) { ?>
                <span class="post-date"><time datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>"><?php echo esc_html(get_the_date(get_option('date_format'))); ?></time></span>

            <?php
            }

            if (in_array('categories', $meta_data)) {

                $categories_list = get_the_category_list(esc_html__(', ', 'postify-for-elementor'));

                if ($categories_list) {
                    printf('<span class="post-categories">%s</span>', wp_kses_post($categories_list)); // WPCS: XSS OK.
                }
            }

            if (in_array('comments', $meta_data)) { ?>

                <span class="post-comments"><?php comments_number(); ?></span>

            <?php
            }
            ?>
        </div>
    <?php

    }

    public function render_category()
    {
        $settings = $this->get_settings();
        $show_category = $settings['show_category'];
        if ('yes' !== $show_category) {
            return;
        }
        $categories = get_the_category();
        if ($categories) {
            echo '<div class="postify__item--category"><a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a></div>';
        }
    }


    public function postify_filter_excerpt_length($length)
    {
        $settings = $this->get_settings();
        $excerpt_length = (!empty($settings['excerpt_length'])) ? absint($settings['excerpt_length']) : 25;
        return absint($excerpt_length);
    }

    public function postify_filter_excerpt_more($more)
    {
        $settings = $this->get_settings();
        return $settings['excerpt_append'];
    }

    protected function render_excerpt()
    {
        $settings = $this->get_settings();
        $show_excerpt = $settings['show_excerpt'];
        if ('yes' !== $show_excerpt) {
            return;
        }

        add_filter('excerpt_more', [$this, 'postify_filter_excerpt_more'], 20);
        add_filter('excerpt_length', [$this, 'postify_filter_excerpt_length'], 9999);
    ?>
        <div class="postify__item__content--description">
            <?php the_excerpt(); ?>
        </div>
    <?php
        remove_filter('excerpt_length', [$this, 'postify_filter_excerpt_length'], 9999);
        remove_filter('excerpt_more', [$this, 'postify_filter_excerpt_more'], 20);
    }

    protected function render_readmore()
    {
        $settings = $this->get_settings();
        $show_read_more = $settings['show_read_more'];
        $read_more_text = $settings['read_more_text'];
        if ('yes' !== $show_read_more) {
            return;
        }
    ?>
        <div class="postify__btn">
            <a class="read-more-btn" href="<?php the_permalink(); ?>"><?php echo esc_html($read_more_text); ?></a>
        </div>
<?php
    }

   
}
Plugin::instance()->widgets_manager->register_widget_type(new Postify_Post_Grid_Widget());
