<!-- General -->
<div id="settings-tab-1" class="tab-content active">
    <h3><?php printf(esc_attr__('Setup Features', $this->pluginName)); ?></h3>
    <div class="card">
        <div class="card-header">
            <?php printf(esc_attr__('Application Settings', $this->pluginName)); ?>
        </div>
        <div class="card-body">
            <div class="grid">
                <div class="form-item col-1-3">
                    <?php echo $ptxFields->textField('Base Url:', 'base_url', 'settings', '', [
                        'description' => 'The base Url for the Imigino video service.',
                        'validate'    => true,
                        'placeholder' => 'https://media.site.com/',
                    ]); ?>
                </div>
                <div class="form-item col-1-3">
                    <?php echo $ptxFields->textField('CID:', 'cid', 'settings', '', [
                        'description' => 'The CID for your the Imigino video service.',
                        'placeholder' => '00',
                        'validate'    => true,
                        'api'         => 'metaDescription',
                    ]); ?>
                </div>
                <div class="form-item col-1-3">
                    <label>Test your settings:</label>
                    <button class="btn is-primary is-left has-margin-right test_settings">Test Url</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <?php printf(esc_attr__('Caching', $this->pluginName)); ?>
        </div>
        <div class="card-body">
            <div class="grid">
                <div class="form-item col-1-3">
                    <?php echo $ptxFields->textField('Cache Bust:', 'caching', 'settings', '', [
                        'description' => 'Bust the cache for the media players manually.',
                        'type'        => 'readonly',
                    ]); ?>
                </div>
                <div class="form-item col-1-2">
                    <label>Create random string:</label>
                    <button class="btn is-primary is-left has-margin-right cache_bust">Create</button>
                    <button class="btn is-primary is-left has-margin-right cache_remove">Remove</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <?php printf(esc_attr__('Shortcode Usage', $this->pluginName)); ?>
        </div>
        <div class="card-body">
            <div class="grid">
                <div class="form-item col-1-4 single">
                    <p><strong>Shortcode: (cid and title are optional)</strong></p>
                    <code class="shortcode">[imigino_video url="string" cid="" title=""]</code>
                </div>
                <div class="form-item col-1-4 single">
                    <p><strong>Legacy: (cid is optional)</strong></p>
                    <code class="shortcode">[baobab_video url="string" cid=""]</code>
                </div>
                <div class="form-item col-1-4 single">
                    <p><strong>Carousel: (*sectionid is required)</strong></p>
                    <code class="shortcode">[imigino_carousel title="" sectionid=""]</code>
                </div>
                <div class="form-item col-1-4 single">
                    <p><strong>Live Streaming: (Authenticated by user email):</strong></p>
                    <code class="shortcode">[imigino_video_live_auth]</code>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About Imigino -->
<div id="settings-tab-2" class="tab-content">
    <h3><?php printf(esc_attr__('About Imigino', $this->pluginName)); ?></h3>
    <div class="card">
        <div class="card-header">
            <?php printf(esc_attr__('Powerful video streaming and analyses', $this->pluginName)); ?>
        </div>
        <div class="card-body">
            <div class="grid">
                <div class="form-item col-1-1">
                    <h3>A single, light and flexible API</h3>
                    <p>Gain access to a single API service layer that can aggregate and merge the most powerful video
                        and image analysis services offered by Google and Amazon. Don’t get locked in to a single player
                        and its respective video archive facility. Our video API services are light and flexible when it
                        comes to changing players, or branding and customising video experiences for a viewer.</p>
                    <h3>Video Services</h3>
                    <p>We have included a combination of Amazon and Google Cloud Video Intelligence APIs that assist in
                        making videos searchable and discoverable by extracting metadata, identifying key nouns and
                        annotating the content of the video. By calling an easy-to-use REST API, you can now search
                        every moment of every video file in your catalogue and find each occurrence of key nouns as well
                        as its significance. Separate signal from noise by retrieving relevant information in video,
                        shot, or frame.</p>
                    <h3>Image Services</h3>
                    <p>We have extended and merged the well-known Google Cloud Vision API and Amazon Image Rekognition
                        deep learning into our Imigino offering, enabling you to extract metadata and understand the
                        content of an image by encapsulating powerful machine learning models in an easy-to-use REST
                        API. Imigino can quickly classify bulk sets of images into thousands of categories (eg, “train”,
                        “pyramid”), detect individual objects and faces within images, and find and read printed words
                        contained within images.</p>
                    <a href="https://www.publisherstoolbox.com/imigino/" class="btn is-secondary is-center" target="_blank" rel="noopener noreferrer">Visit
                        Imigino Website</a>
                </div>
            </div>
        </div>
    </div>
</div>
