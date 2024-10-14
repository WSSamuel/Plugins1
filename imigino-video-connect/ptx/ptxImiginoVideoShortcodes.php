<?php
    
    namespace PTI\ptx;
    
    use JsonException;
    
    if (!defined('ABSPATH')) {
        exit();
    }
    
    /**
     * Video shortcodes class.
     *
     * This class is used to build the shortcodes used to display videos.
     *
     * @since      1.0.8
     * @package    PublishersToolboxImiginoVideo
     * @subpackage PublishersToolboxImiginoVideo/ptx
     * @author     Johan Pretorius <johan.pretorius@afrozaar.com>
     */
    class ptxImiginoVideoShortcodes {
        
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
         * Sets up your shortcode.
         * [imigino_video url="" cid=""]
         *
         * @param $attributes
         *
         * @return string
         * @throws JsonException
         *
         * @since 1.0.0
         */
        public function ptxImiginoVideo($attributes): string {
            $ptxOptions = (new ptxImiginoVideoGlobal($this->pluginName, $this->pluginVersion))->getPluginOptions();
            
            $shortcodeAttributes = shortcode_atts([
                'url'   => '',
                'cid'   => '',
                'title' => '',
            ], $attributes);
            
            $externalAction = '/video/1/buildEnvelope?'
                              . 'cid=' . ($shortcodeAttributes['cid'] ?: esc_attr($ptxOptions['settings']['cid']))
                              . ($shortcodeAttributes['url'] ? '&videoUrl=' . esc_attr($shortcodeAttributes['url']) : '')
                              . '&v=' . $this->pluginVersion
                              . (isset($ptxOptions['settings']['caching']) ? '&cache=' . $ptxOptions['settings']['caching'] : '');
            // If the title attribute has a value, add it
            if (get_the_title() || isset($shortcodeAttributes['title']) && !empty($shortcodeAttributes['title'])) {
                $externalAction .= '&title=' . urlencode(get_the_title() ?: $shortcodeAttributes['title']);
            }
            
            return ptxImiginoVideoRequests::request($ptxOptions['settings']['base_url'], $externalAction, '', 'full', 'GET');
        }
        
        /**
         * Sets up your shortcode.
         * [imigino_video_live_auth cid=""]
         *
         * @param $attributes
         *
         * @return string
         * @throws JsonException
         *
         * @since 1.0.5
         */
        public function ptxImiginoVideoLive($attributes): string {
            $ptxOptions = (new ptxImiginoVideoGlobal($this->pluginName, $this->pluginVersion))->getPluginOptions();
            
            $shortcodeAttributes = shortcode_atts([
                'cid' => '',
            ], $attributes);
            
            $externalAction = '/video/1/buildAuthenticatedEnvelope?'
                              . 'cid=' . ($shortcodeAttributes['cid'] ?: esc_attr($ptxOptions['settings']['cid']))
                              . '&v=' . $this->pluginVersion . (isset($ptxOptions['settings']['caching']) ? '&cache=' . $ptxOptions['settings']['caching'] : '');
            
            /**
             * Authenticate using user email.
             */
            $email = '';
            if (is_user_logged_in()) {
                $user = wp_get_current_user();
                if ($user !== NULL) {
                    $email = $user->data->user_email;
                }
            }
            
            return ptxImiginoVideoRequests::request($ptxOptions['settings']['base_url'], $externalAction, '', 'full', 'GET', ['emailAddress' => $email]);
        }
        
        /**
         * Get the carousel rest api details.
         *
         * Theme: standard or featured
         * [imigino_carousel sectionid="1324567" title="Events" theme="standard"]
         *
         * @param $attributes
         *
         * @return string
         * @throws JsonException
         *
         * @since 1.0.8
         */
        public function ptxImiginoVideoCarousel($attributes): string {
            $ptxOptions = (new ptxImiginoVideoGlobal($this->pluginName, $this->pluginVersion))->getPluginOptions();
            
            $shortcodeAttributes = shortcode_atts([
                'sectionid' => '',
                'title'     => '',
                'theme'     => '',
            ], $attributes);
            
            $externalAction = '/video/1/getSectionPlaylist' .
                              '?sectionId=' . $shortcodeAttributes['sectionid'] .
                              '&v=' . $this->pluginVersion
                              . (isset($ptxOptions['settings']['caching']) ? '&cache=' . $ptxOptions['settings']['caching'] : '');
            
            $carouselList = ptxImiginoVideoRequests::request($ptxOptions['settings']['base_url'], $externalAction, '', 'array', 'GET');
            
            if (is_array($carouselList) && !empty($carouselList)) {
                return $this->ptxCarouselHtml($carouselList, $shortcodeAttributes, $ptxOptions);
            }
            
            return '';
        }
        
        /**
         * Setup the html for the carousel shortcode.
         *
         * @param array $carouselList
         * @param array $shortcodeAttributes
         * @param $ptxOptions
         *
         * @return string
         *
         * @since 1.0.8
         */
        public function ptxCarouselHtml(array $carouselList, array $shortcodeAttributes, $ptxOptions): string {
            
            $carouselOptions = (isset($ptxOptions['carousel']) && is_array($ptxOptions['carousel']) ? $ptxOptions['carousel'] : []);
            
            /**
             * Setup display options.
             */
            $showTitle     = isset($carouselOptions['display']['title']);
            $showPlay      = isset($carouselOptions['display']['play']);
            $showHeader    = isset($carouselOptions['display']['header']);
            $showTimestamp = isset($carouselOptions['display']['timestamp']);
            $showMeta      = isset($carouselOptions['display']['meta']);
            
            /**
             * Setup carousel options.
             */
            $infinite      = $carouselOptions['options']['infinite'] ?: 'false';
            $chevron       = $carouselOptions['options']['chevron'] ?: '';
            $speed         = $carouselOptions['options']['speed'] ?: '300';
            $show          = $carouselOptions['options']['show'] ?: '5';
            $limit         = $carouselOptions['options']['limit'] ?: 10;
            $lazy          = $carouselOptions['options']['lazy'] ?? false;
            $scroll        = $carouselOptions['options']['scroll'] ?: '1';
            $width         = $carouselOptions['options']['width'] ?: '300';
            $height        = $carouselOptions['options']['height'] ?: '203';
            $overflow      = $carouselOptions['options']['overflow'] ?? false;
            $crop          = $carouselOptions['options']['crop'] ?? false;
            $zoom          = $carouselOptions['options']['zoom'] ?? false;
            $horizontal    = $carouselOptions['options']['horizontal'] ?: false;
            $sliderOptions = 'data-infinite="' . $infinite . '" data-speed="' . $speed . '" data-slides="' . $show . '"  data-scroll="' . $scroll . '"  data-chevron="' . $chevron . '"';
            
            /**
             * Lightbox options.
             */
            $lightboxWidth  = $carouselOptions['lightbox']['width'] ?: '800';
            $lightboxHeight = $carouselOptions['lightbox']['height'] ?: '600';
            
            /**
             * Colours
             */
            $header               = $carouselOptions['colours']['header'] ?: '#FFFFFF';
            $headerUnderline      = $carouselOptions['colours']['underline'] ?: '#000000';
            $iconPlayColor        = $carouselOptions['colours']['icon'] ?: '#FFFFFF';
            $iconPlayBgColor      = $carouselOptions['colours']['icon_background'] ?: '#000000';
            $iconPlayBgHoverColor = $carouselOptions['colours']['icon_hover'] ?: '#000000';
            $navigationColor      = $carouselOptions['colours']['navigation'] ?: '#000000';
            $textColor            = $carouselOptions['colours']['text'] ?: '#ffffff';
            $metaColor            = $carouselOptions['colours']['meta'] ?: 'rgba(0, 0, 0, 1)';
            $metaHoverColor       = $carouselOptions['colours']['meta_hover'] ?: 'rgba(0, 0, 0, 1)';
            $lightboxColor        = $carouselOptions['colours']['lightbox'] ?: 'rgba(0, 0, 0, 0.6)';
            
            /**
             * Start HTML build.
             */
            $html = '';
            
            /**
             * Setup styling overwrites.
             */
            $playStyle = '';
            if ((!$showHeader) || !$showMeta) {
                $playStyle = '.imigino-carousel-content .imigino-carousel.standard .slick-active .imigino-carousel-item a .play-button{top: 50%;}';
            }
            
            $overflowStyle = '';
            if ($overflow) {
                $overflowStyle = '@media only screen and (min-width: 1367px) {.slick-list {overflow: visible !important;}}';
            }
            
            $bodyStyle = '';
            if ($infinite === '1') {
                $bodyStyle = 'body{overflow-x:hidden;}';
            }
            
            $html .= '<style>' . $bodyStyle . ' .imigino-carousel-content .imigino-carousel.standard .imigino-carousel-item a .imigino-carousel-meta{background: ' . $metaColor . ';} .imigino-carousel-content .imigino-carousel.standard .slick-active .imigino-carousel-item a:hover .imigino-carousel-meta{background: ' . $metaHoverColor . ';} .imigino-carousel-content .imigino-carousel.standard .imigino-carousel-item a .imigino-carousel-meta h4,.imigino-carousel-content .imigino-carousel.standard .imigino-carousel-item a .imigino-carousel-meta .imigino-carousel-timestamp{color: ' . $textColor . ';}.imigino-carousel-content .imigino-carousel.standard .slick-active .imigino-carousel-item a .play-button{background:' . $iconPlayBgColor . ';} .imigino-carousel-content .imigino-carousel.standard .slick-active .imigino-carousel-item a:hover .play-button{background:' . $iconPlayBgHoverColor . ';} .imigino-carousel-content .imigino-carousel.standard .slick-active .imigino-carousel-item a .play-button .play-button-inner{border-color: transparent transparent transparent' . $iconPlayColor . ';}.imigino-carousel-content .imigino-carousel .chevron:before{border-color:' . $navigationColor . ';}.slick-prev:before, .slick-next:before{color:' . $navigationColor . ';} .imigino-carousel-content .imigino-carousel-header{color:' . $header . ';} .imigino-carousel-content .imigino-carousel-header::before, .imigino-carousel-content .imigino-carousel-header::after{background:' . $headerUnderline . ';} ' . $playStyle . ' ' . $overflowStyle . ' ' . ($zoom ? '.imigino-carousel-content .imigino-carousel .slick-active a:hover {transform: scale(1.5);z-index: 999;}' : '') . '</style>';
            
            $html .= '<div class="imigino-carousel-content">';
            
            /**
             * H3 Title above carousel.
             */
            if ($showTitle) {
                $html .= '<h3 class="imigino-carousel-header">' . $shortcodeAttributes['title'] . '</h3>';
            }
            
            switch ($shortcodeAttributes['theme']) {
                case 'standard':
                    $theme = 'standard';
                    break;
                case 'featured':
                    $theme = 'featured';
                    break;
                default:
                    $theme = 'standard';
            }
            
            $html .= '<div class="imigino-carousel ' . $theme . '" ' . $sliderOptions . '>';
            
            /**
             * Setup Imigino call.
             */
            $ptxOptions     = (new ptxImiginoVideoGlobal(PTX_IMIGINO_VIDEO_NAME, PTX_IMIGINO_VIDEO_VERSION))->getPluginOptions();
            $externalAction = '/video/1/buildEnvelope?cid=' . ($shortcodeAttributes['cid'] ?? esc_attr($ptxOptions['settings']['ccid']));
            
            /**
             * Handle cropping.
             *
             * Make the images slightly bigger before we crop it to the exact size.
             */
            if ($crop) {
                $width  = ((int)$width) + 50;
                $height = (int)$height + 50;
            }
            
            if ($limit !== 0) {
                $carouselList = array_slice($carouselList, 0, $limit);
            }
            foreach ($carouselList as $item) {
                $encode   = $this->encodeName($item['title']);
                $videoUrl = $ptxOptions['settings']['base_url'] . $externalAction . '&videoUrl=' . esc_attr($item['url']);
                
                /**
                 * Clean up the timestamp.
                 */
                $timeStamp = explode(':', $item['duration']);
                $timeSec   = explode('.', $timeStamp[2]);
                
                if ($timeStamp[0] === '00') {
                    $duration = $timeStamp[1] . ':' . $timeSec[0];
                } else {
                    $duration = $item['duration'];
                }
                
                /**
                 * Run the image through the resizer and cropper.
                 */
                $image = $ptxOptions['settings']['base_url'] . '/image/1/process/' . $width . 'x' . $height . '?source=' . $item['image'];
                if ($crop) {
                    $first  = $ptxOptions['settings']['base_url'] . '/image/1/process/' . $width . 'x' . $height;
                    $second = '?source=' . $ptxOptions['settings']['base_url'] . '/image/1/process/' . $width . 'x' . ($horizontal ? 1000 : $height);
                    $third  = '?source=' . $item['image'] . '&operation=CROP&resize=' . $width . 'x' . $height;
                    $image  = $first . $second . $third;
                }
                
                /**
                 * Lightbox data string.
                 */
                $lightBoxData = 'data-video="' . $encode . '" data-width="' . $lightboxWidth . '" data-height="' . $lightboxHeight . '" data-imigino="' . $videoUrl . '" data-background="' . $metaColor . '" data-text="' . $textColor . '" data-lightbox="' . $lightboxColor . '" data-caption="' . $item['title'] . '"';
                
                /**
                 * Put it all together.
                 */
                $html .= '<div class="imigino-carousel-item">';
                $html .= '<a href="' . $videoUrl . '" title="' . $item['title'] . '" class="big-picture" ' . $lightBoxData . '>';
                
                /**
                 * Lazy loader.
                 */
                if ($lazy) {
                    $src = 'data-lazy="' . $image . '" loading="lazy"';
                } else {
                    $src = 'src="' . $image . '"';
                }
                
                $html .= '<img ' . $src . ' alt="' . $item['title'] . '">';
                
                if ($showMeta) {
                    $html .= '<div class="imigino-carousel-meta" ' . (!$showHeader && !$showHeader ? 'style="display:none;";' : '') . '>';
                    if ($showHeader) {
                        $html .= '<h4>' . (new ptxImiginoVideoGlobal($this->pluginName, $this->pluginVersion))->limitStringLength($item['title'], 60) . '</h4>';
                    }
                    if ($showTimestamp) {
                        $html .= '<span class="imigino-carousel-timestamp">' . $duration . '</span>';
                    }
                    $html .= '</div>';
                }
                
                if ($showPlay) {
                    $html .= '<div class="play-button"><div class="play-button-inner"></div></div>';
                }
                
                $html .= '</a>';
                $html .= '</div>';
            }
            
            $html .= '</div>';
            $html .= '</div>';
            
            return $html;
        }
        
        /**
         * Use to encode a string.
         *
         * @param $input
         *
         * @return string
         *
         * @since 1.1.3
         */
        public function encodeName($input): string {
            return base64_encode(gzdeflate($input));
        }
        
        /**
         * Use to decode a string.
         *
         * @param $input
         *
         * @return false|string
         *
         * @since 1.1.3
         */
        public function decodeName($input) {
            return gzinflate(base64_decode($input));
        }
    }
