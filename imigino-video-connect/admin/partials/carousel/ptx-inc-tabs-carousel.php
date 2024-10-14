<div id="design-tab-1" class="tab-content">
    <h3><?php printf(esc_attr__('Options', $this->pluginName)); ?></h3>
    <div class="card">
        <div class="card-header">
            <?php printf(esc_attr__('Carousel Options', $this->pluginName)); ?>
        </div>
        <div class="card-body">
            <div class="grid">
                <div class="form-item col-1-3 single">
                    <?php echo $ptxFields->textField('CID:', 'ccid', 'settings', '', [
                        'description' => 'The CID for your the Imigino carousel video service.',
                        'placeholder' => '00',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <?php printf(esc_attr__('Carousel Setup', $this->pluginName)); ?>
        </div>
        <div class="card-body">
            <div class="grid">
                <div class="form-item col-1-6 single">
                    <?php echo $ptxFields->checkboxField('Infinite Scroll', 'infinite', 'carousel', 1, [
                        'description' => 'Switch on infinite scroll.',
                        'sub'         => 'options',
                    ]); ?>
                </div>
                <div class="form-item col-1-6 single">
                    <?php echo $ptxFields->checkboxField('Replace Nav Icon', 'chevron', 'carousel', 1, [
                        'description' => 'Replace Nav icons with Chevron.',
                        'sub'         => 'options',
                    ]); ?>
                </div>
                <div class="form-item col-1-6 single">
                    <?php echo $ptxFields->checkboxField('Display Overflow', 'overflow', 'carousel', 1, [
                        'description' => 'Show carousel overflow.',
                        'sub'         => 'options',
                    ]); ?>
                </div>
                <div class="form-item col-1-6 single">
                    <?php echo $ptxFields->checkboxField('Crop Image', 'crop', 'carousel', 1, [
                        'description' => 'Crop the image to the desired size.',
                        'sub'         => 'options',
                    ]); ?>
                </div>
                <div class="form-item col-1-6 single">
                    <?php echo $ptxFields->checkboxField('Horizontal Crop', 'horizontal', 'carousel', 1, [
                        'description' => 'Crop portrait images horizontally to fit.',
                        'sub'         => 'options',
                    ]); ?>
                </div>
                <div class="form-item col-1-6 single">
                    <?php echo $ptxFields->checkboxField('Zoom Image', 'zoom', 'carousel', 1, [
                        'description' => 'Zoom the image on hover.',
                        'sub'         => 'options',
                    ]); ?>
                </div>
                <div class="form-item col-1-6 single">
                    <?php echo $ptxFields->checkboxField('Lazy Load', 'lazy', 'carousel', 1, [
                        'description' => 'Lazy load images.',
                        'sub'         => 'options',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <?php printf(esc_attr__('Display Options', $this->pluginName)); ?>
        </div>
        <div class="card-body">
            <div class="grid">
                <div class="form-item col-1-5 single">
                    <?php echo $ptxFields->checkboxField('Show Header', 'title', 'carousel', 1, [
                        'description' => 'Hide the header title above carousel.',
                        'sub'         => 'display',
                    ]); ?>
                </div>
                <div class="form-item col-1-5 single">
                    <?php echo $ptxFields->checkboxField('Show Play Button', 'play', 'carousel', 1, [
                        'description' => 'Hide the play button.',
                        'sub'         => 'display',
                    ]); ?>
                </div>
                <div class="form-item col-1-5 single">
                    <?php echo $ptxFields->checkboxField('Show Slide Header', 'header', 'carousel', 1, [
                        'description' => 'Hide the title on slider item.',
                        'sub'         => 'display',
                    ]); ?>
                </div>
                <div class="form-item col-1-5 single">
                    <?php echo $ptxFields->checkboxField('Show Timestamp', 'timestamp', 'carousel', 1, [
                        'description' => 'Hide the timestamp.',
                        'sub'         => 'display',
                    ]); ?>
                </div>
                <div class="form-item col-1-5 single">
                    <?php echo $ptxFields->checkboxField('Show Meta Data', 'meta', 'carousel', 1, [
                        'description' => 'Hide the thumbnail title and timestamp.',
                        'sub'         => 'display',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <?php printf(esc_attr__('Slider Options', $this->pluginName)); ?>
        </div>
        <div class="card-body">
            <div class="grid">
                <div class="form-item col-1-3">
                    <?php echo $ptxFields->sliderField('Limit Slides', 'limit', 'carousel', 10, [
                        'description' => 'Limits the amount of slides to load into slider.',
                        'min'         => 0,
                        'max'         => 50,
                        'step'        => 1,
                        'sub'         => 'options',
                    ]); ?>
                </div>
                <div class="form-item col-1-3">
                    <?php echo $ptxFields->sliderField('Slides to show', 'show', 'carousel', 3, [
                        'description' => 'The amount of slides to show.',
                        'min'         => 1,
                        'max'         => 20,
                        'step'        => 1,
                        'sub'         => 'options',
                    ]); ?>
                </div>
                <div class="form-item col-1-3">
                    <?php echo $ptxFields->sliderField('Thumbnail Width', 'width', 'carousel', 300, [
                        'description' => 'The width of the thumbnail for the carousel.',
                        'min'         => 50,
                        'max'         => 1200,
                        'step'        => 1,
                        'sub'         => 'options',
                    ]); ?>
                </div>
                <div class="form-item col-1-3">
                    <?php echo $ptxFields->sliderField('Thumbnail Height', 'height', 'carousel', 203, [
                        'description' => 'The height of the thumbnail for the carousel.',
                        'min'         => 50,
                        'max'         => 1200,
                        'step'        => 1,
                        'sub'         => 'options',
                    ]); ?>
                </div>
                <div class="form-item col-1-3">
                    <?php echo $ptxFields->sliderField('Scroll Speed', 'speed', 'carousel', 300, [
                        'description' => 'The speed to scroll the carousel items.',
                        'min'         => 100,
                        'max'         => 10000,
                        'step'        => 100,
                        'append'      => ' ms',
                        'sub'         => 'options',
                    ]); ?>
                </div>

                <div class="form-item col-1-3">
                    <?php echo $ptxFields->sliderField('Slides to scroll', 'scroll', 'carousel', 3, [
                        'description' => 'The amount of slides to scroll on next and previous.',
                        'min'         => 1,
                        'max'         => 20,
                        'step'        => 1,
                        'sub'         => 'options',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <?php printf(esc_attr__('Lightbox Options', $this->pluginName)); ?>
        </div>
        <div class="card-body">
            <div class="grid">
                <div class="form-item col-1-2">
                    <?php echo $ptxFields->sliderField('Lightbox Width', 'width', 'carousel', 800, [
                        'description' => 'The width of the lightbox video player.',
                        'min'         => 200,
                        'max'         => 2800,
                        'step'        => 1,
                        'sub'         => 'lightbox',
                    ]); ?>
                </div>
                <div class="form-item col-1-2">
                    <?php echo $ptxFields->sliderField('Lightbox Height', 'height', 'carousel', 457, [
                        'description' => 'The height of the lightbox video player.',
                        'min'         => 200,
                        'max'         => 2800,
                        'step'        => 1,
                        'sub'         => 'lightbox',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <?php printf(esc_attr__('Colours', $this->pluginName)); ?>
        </div>
        <div class="card-body">
            <div class="grid">
                <div class="form-item col-1-2">
                    <?php echo $ptxFields->colorPickerField('Header', 'header', 'carousel', '#FFFFFF', [
                        'description' => 'The carousel header colour.',
                        'sub'         => 'colours',
                    ]); ?>
                </div>
                <div class="form-item col-1-2">
                    <?php echo $ptxFields->colorPickerField('Header Underline', 'underline', 'carousel', '#000000', [
                        'description' => 'The carousel header underline colour.',
                        'sub'         => 'colours',
                    ]); ?>
                </div>

                <div class="form-item col-1-2">
                    <?php echo $ptxFields->colorPickerField('Play Icon', 'icon', 'carousel', '#FFFFFF', [
                        'description' => 'The play icon colour.',
                        'sub'         => 'colours',
                    ]); ?>
                </div>
                <div class="form-item col-1-2">
                    <?php echo $ptxFields->colorPickerField('Play Icon Background', 'icon_background', 'carousel', '#000000', [
                        'description' => 'The play icon background block colour.',
                        'sub'         => 'colours',
                        'opacity'     => true,
                    ]); ?>
                </div>
                <div class="form-item col-1-2">
                    <?php echo $ptxFields->colorPickerField('Play Icon Background Hover', 'icon_hover', 'carousel', '#FFFFFF', [
                        'description' => 'The play icon background block colour on hover.',
                        'sub'         => 'colours',
                        'opacity'     => true,
                    ]); ?>
                </div>
                <div class="form-item col-1-2">
                    <?php echo $ptxFields->colorPickerField('Next/Prev Icon', 'navigation', 'carousel', '#000000', [
                        'description' => 'The navigation icons colour.',
                        'sub'         => 'colours',
                    ]); ?>
                </div>
                <div class="form-item col-1-2">
                    <?php echo $ptxFields->colorPickerField('Thumbnail Meta Text', 'text', 'carousel', '#000000', [
                        'description' => 'The text colour that appears on the thumbnail.',
                        'sub'         => 'colours',
                    ]); ?>
                </div>
                <div class="form-item col-1-2">
                    <?php echo $ptxFields->colorPickerField('Thumbnail Meta Box', 'meta', 'carousel', '#FFFFFF', [
                        'description' => 'The background colour for the header text that appears on the thumbnail.',
                        'sub'         => 'colours',
                        'opacity'     => true,
                    ]); ?>
                </div>
                <div class="form-item col-1-2">
                    <?php echo $ptxFields->colorPickerField('Thumbnail Meta Box Hover', 'meta_hover', 'carousel', '#000000', [
                        'description' => 'The background colour for the header text that appears on the thumbnail on hover.',
                        'sub'         => 'colours',
                        'opacity'     => true,
                    ]); ?>
                </div>
                <div class="form-item col-1-2">
                    <?php echo $ptxFields->colorPickerField('Lightbox Background', 'lightbox', 'carousel', '#000000', [
                        'description' => 'The lightbox video player background colour.',
                        'sub'         => 'colours',
                        'opacity'     => true,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
