<?php
/**
 * Plugin Name: Team Popup for Elementor
 * Plugin URI: https://movuent.com
 * Description: This is a Popup elements for Elementor website
 * Version: 1.0.0
 * Author: Alvin Novian
 * Author URI: http://movuent.com
 */

/**
 * Checking the set ups and the environment
 */

if( !function_exists('add_action') ) {
    // if WordPress not installed kill the page.
	die('WordPress not Installed');
}

if( !defined( 'ABSPATH' ) ) exit; // No access of directly access

define( 'MY_TEXT_DOMAIN', 'kcte' );

class Elementor_Test_Widget extends \Elementor\Widget_Base {

	public function get_name() {
        return "kcte_widget";
    }

	public function get_title() {
        return __("Komodo Custom Team", MY_TEXT_DOMAIN);
    }

	public function get_icon() {
        return "eicon-person";
    }

    public function get_script_depends() {
		return ["kcte_widget"];
	}

	public function get_categories() {
        return ["general"];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            "content",
            [
                "label" => __("Content", MY_TEXT_DOMAIN)
            ]
        );

        $this->add_control(
            "kcte_team_avatar",
            [
                "label" => __("Avatar", MY_TEXT_DOMAIN),
                "type" => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            "kcte_team_name",
            [
                "label" => __("Name", MY_TEXT_DOMAIN),
                "type" => \Elementor\Controls_Manager::TEXT,
                "default" => __("Alvin Novian", MY_TEXT_DOMAIN)
            ]
        );

        $this->add_control(
            "kcte_team_jobtitle",
            [
                "label" => __("Job Position", MY_TEXT_DOMAIN),
                "type" => \Elementor\Controls_Manager::TEXT,
                "default" => __("Software Engineer", MY_TEXT_DOMAIN)
            ]
        );

        $this->add_control(
            "kcte_team_description",
            [
                "label" => __("Description", MY_TEXT_DOMAIN),
                "type" => \Elementor\Controls_Manager::WYSIWYG,
                "description" => __("Add team member description here. Remove the text if not necessary.", MY_TEXT_DOMAIN)
            ]
        );

        $this->add_control(
            "kcte_team_socials",
            [
                "type" => \Elementor\Controls_Manager::REPEATER,
                "default" => [
                    [
                        'social' => 'fa fa-facebook',
                    ],
                    [
                        'social' => 'fa fa-twitter',
                    ],
                    [
                        'social' => 'fa fa-linkedin',
                    ],
                ],
                "fields" => [
                    [
                        "name" => "social",
                        "label" => __("Icon", MY_TEXT_DOMAIN),
                        "type" => \Elementor\Controls_Manager::ICON,
                        "default" => "fa fa-wordpress",
                        "include" => [
                            "fa fa-apple",
                            "fa fa-behance",
                            "fa fa-bitbucket",
                            "fa fa-codepen",
                            "fa fa-delicious",
                            "fa fa-digg",
                            "fa fa-dribbble",
                            "fa fa-envelope",
                            "fa fa-facebook",
                            "fa fa-flickr",
                            "fa fa-foursquare",
                            "fa fa-github",
                            "fa fa-google-plus",
                            "fa fa-houzz",
                            "fa fa-instagram",
                            "fa fa-jsfiddle",
                            "fa fa-linkedin",
                            "fa fa-medium",
                            "fa fa-pinterest",
                            "fa fa-product-hunt",
                            "fa fa-reddit",
                            "fa fa-shopping-cart",
                            "fa fa-slideshare",
                            "fa fa-snapchat",
                            "fa fa-soundcloud",
                            "fa fa-spotify",
                            "fa fa-stack-overflow",
                            "fa fa-tripadvisor",
                            "fa fa-tumblr",
                            "fa fa-twitch",
                            "fa fa-twitter",
                            "fa fa-vimeo",
                            "fa fa-vk",
                            "fa fa-whatsapp",
                            "fa fa-wordpress",
                            "fa fa-xing",
                            "fa fa-yelp",
                            "fa fa-youtube",
                        ],
                    ],
                    [
                        "name" => "link",
                        "label" => __("Link", MY_TEXT_DOMAIN),
                        "type" => \Elementor\Controls_Manager::URL,
                        "default" => [
                            "url" => "",
                            "is_external" => "true"
                        ],
                        "placeholder" => __("Place URL here ... ", MY_TEXT_DOMAIN)
                    ]
                ],
                'title_field' => '<i class="{{ social }}"></i> {{{ social.replace( \'fa fa-\', \'\' ).replace( \'-\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}',
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings();
        ?>

            <div class="kcte-widget">
				<div class="kcte-widget-wrapper">
					<figure>
						<img src="<?php echo $settings['kcte_team_avatar']['url']; ?>" alt="<?php echo $settings['kcte_team_name'];?>">
					</figure>
                    <div class="kcte-widget-content">
                        <h3 class="kcte-widget-name"><?php echo $settings["kcte_team_name"]; ?></h3>
                        <h4 class="kcte-widget-jobtitle"><?php echo $settings["kcte_team_jobtitle"]; ?></h4>
                        <button class="kcte-widget-button">See Detail</button>
                    </div>
                </div>
                <div class="kcte-widget-popup">
                    <div class="kcte-widget-popup-block"></div>
                    <div class="kcte-widget-popup-wrapper">
                        <div class="kcte-widget-popup-box-wrapper">
                            <div class="kcte-widget-popup-box">
                                <button class="kcte-widget-popup-close">
                                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                        <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
                                    </svg>
                                </button>
                                <h3 class="kcte-widget-popup-name"><?php echo $settings["kcte_team_name"]; ?></h3>
                                <h4 class="kcte-widget-popup-jobtitle"><?php echo $settings["kcte_team_jobtitle"]; ?></h4>
                                <div class="kcte-widget-popup-description"><?php echo $settings["kcte_team_description"]; ?></div>
                                
                                <?php if ( ! empty( $settings['kcte_team_socials'] ) ): ?>
                                    <ul class="kcte-widget-popup-socials">
                                        <?php foreach ( $settings['kcte_team_socials'] as $item ) : ?>
                                            <?php if ( ! empty( $item['social'] ) ) : ?>
                                                <?php $target = $item['link']['is_external'] ? ' target="_blank"' : ''; ?>
                                                <li>
                                                    <a href="<?php echo esc_attr( $item['link']['url'] ); ?>"<?php echo $target; ?>><i class="<?php echo esc_attr($item['social'] ); ?>"></i></a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
    }

	protected function _content_template() {}

}