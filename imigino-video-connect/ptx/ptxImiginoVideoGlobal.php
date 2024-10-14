<?php

    namespace PTI\ptx;

    use JsonException;

    if (!defined('ABSPATH')) {
        exit();
    }

    /**
     * Global usage class.
     *
     * This class is used to load functions that are global (Admin and Frontend) used.
     *
     * @since      1.0.0
     * @package    PublishersToolboxImiginoVideo
     * @subpackage PublishersToolboxImiginoVideo/ptx
     * @author     Johan Pretorius <johan.pretorius@afrozaar.com>
     */
    class ptxImiginoVideoGlobal {

        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $pluginName The ID of this plugin.
         */
        private $pluginName;

        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $pluginVersion The current version of this plugin.
         */
        private $pluginVersion;

        /**
         * Initialize the collections used to maintain backend and frontend functions.
         *
         * @param string $pluginName The name of this plugin.
         * @param string $pluginVersion The version of this plugin.
         *
         * @since 1.0.0
         */
        public function __construct(string $pluginName, string $pluginVersion) {
            $this->pluginName    = $pluginName;
            $this->pluginVersion = $pluginVersion;
        }

        /**
         * Return the plugin options.
         *
         * @since 1.0.0
         */
        public function getPluginOptions() {
            return get_option($this->pluginName, []);
        }

        /**
         * The settings page link for reuse.
         *
         * @return string
         *
         * @since 1.0.0
         */
        public function getSettingsLink() {
            return '<a href="' . admin_url('admin.php?page=' . $this->pluginName) . '">' . __('Settings', $this->pluginName) . '</a>';
        }

        /**
         * Test the inserted settings.
         *
         * @param $outputOptions
         *
         * @return string
         * @throws JsonException
         *
         * @since 1.0.0
         */
        public function ptxTestUrl($outputOptions): string {
            return ptxImiginoVideoRequests::request($outputOptions['settings']['base_url'], '/video/1/test', '', 'response', 'GET');
        }

        /**
         * Limit titles to a specific length,
         *
         * @param $input
         * @param $length
         * @param bool $ellipses
         * @param bool $stripHtml
         *
         * @return false|string
         *
         * @since 1.0.8
         */
        public function limitStringLength($input, $length, $ellipses = true, $stripHtml = true) {
            /**
             * Strip tags, if desired.
             */
            if ($stripHtml) {
                $input = strip_tags($input);
            }

            /**
             * No need to trim, already shorter than trim length.
             */
            if (strlen($input) <= $length) {
                return $input;
            }

            /**
             * Find last space within length.
             */
            $last_space = strrpos(substr($input, 0, $length), ' ');
            if ($last_space !== false) {
                $trimmedText = substr($input, 0, $last_space);
            } else {
                $trimmedText = substr($input, 0, $length);
            }

            /**
             * Add ellipses.
             */
            if ($ellipses) {
                $trimmedText .= '...';
            }

            return $trimmedText;
        }

        /**
         * Create a notice if any of the fields are empty.
         *
         * @since 1.0.0
         */
        public function adminNoticeSetup(): void {
            $settingsLink = $this->getSettingsLink(); ?>
            <div class="notice notice-info is-dismissible">
                <p><?php _e('Please enter your Imigino information. Go to ' . $settingsLink . ' page to complete the setup.', $this->pluginName); ?></p>
            </div>
            <?php
        }
    }
