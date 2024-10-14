<?php

namespace Filkers\Blocks;

require_once('AbstractServerSideRenderedBlock.php');
require_once('controls/ClickControls.php');
require_once('controls/PlaybackControls.php');
require_once('controls/SliderControls.php');
require_once('controls/SizeControls.php');
require_once('controls/UidControls.php');

use Filkers\Blocks\SliderControls;

class FolderPlayerBlock extends AbstractServerSideRenderedBlock {

    private $uidControls;
    private $clickControls;
    private $playbackControls;
    private $sliderControls;
    private $sizeControls;

    public function __construct() {
        parent::__construct('folder-player');

        $this->uidControls = new UidControls();
        $this->mergeAttributes($this->uidControls);

        $this->clickControls = new ClickControls();
        $this->mergeAttributes($this->clickControls);

        $this->playbackControls = new PlaybackControls();
        $this->mergeAttributes($this->playbackControls);

        $this->sliderControls = new SliderControls();
        $this->mergeAttributes($this->sliderControls);

        $this->sizeControls = new SizeControls();
        $this->mergeAttributes($this->sizeControls);
    }

    // Override
    protected function parse_attributes($attributes) {
        $this->uidControls->parse_attributes($attributes);
        $this->clickControls->parse_attributes($attributes);
        $this->playbackControls->parse_attributes($attributes);
        $this->sliderControls->parse_attributes($attributes);
        $this->sizeControls->parse_attributes($attributes);
    }

    // Override
    protected function render($attributes=array(), $content = '') {
        $output = '<div class="filkers-block" >';
        $output .= '<filkers-folder';
            $output .= ' uid="'.$this->uidControls->uid.'"';
            $output .= $this->preview ? 'edition' : '';
            $output .= $this->clickControls->renderHTMLAttributes();
            $output .= $this->playbackControls->renderHTMLAttributes();
            $output .= $this->sizeControls->renderHTMLAttributes();
            $output .= $this->sliderControls->renderHTMLAttributes();

        $output .= '/>';
        $output .= '</div>';

        return $output;
    }

}