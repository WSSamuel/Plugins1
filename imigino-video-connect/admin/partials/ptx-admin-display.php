<?php
    /**
     * Provide a admin area view for the plugin
     *
     * This file is used to markup the admin-facing aspects of the plugin.
     *
     * @since      1.0.0
     *
     * @package    PublishersToolboxImiginoVideo/
     * @subpackage PublishersToolboxImiginoVideo/admin/partials
     */
?>
<hr class="wp-header-end">
<section class="<?php echo $this->pluginName; ?>">
    <div class="header">
        <div class="grid">
            <div class="col-1-2">
                <a href="https://www.publisherstoolbox.com/imigino/" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo plugin_dir_url(__DIR__) . 'assets/img/ptx-product.png'; ?>" alt="<?php echo esc_html(get_admin_page_title()); ?>" class="Imigino"></a>
            </div>
            <div class="col-1-2">
                <div class="is-right">
                    <p class="is-text-right">
                        Version: <?php echo $this->pluginVersion; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="wrap">
        <section class="start-page">
            <div class="grid">
                <div class="col-2-12">
                    <div class="col-1-1 menu-block">
                        <ul>
                            <?php require_once 'settings/ptx-inc-menu-settings.php' ?>
                            <?php require_once 'carousel/ptx-inc-menu-carousel.php' ?>
                        </ul>
                    </div>
                </div>
                <div class="col-10-12">
                    <div class="grid">
                        <div class="col-1-1 content-block">
                            <form class="plugin-options-form" id="plugin-options-form">
                                <input type="hidden" name="version" value="<?php echo $this->pluginVersion; ?>">
                                <?php echo $ptxFields->textField('', 'last_save', '', date('Y-m-d H:i:s'), ['type' => 'hidden']); ?>
                                <button class="btn is-secondary is-right" id="options-admin-save" form="plugin-options-form" type="submit"><?php _e('Save All', $this->pluginName); ?></button>
                                <?php require_once 'settings/ptx-inc-tabs-settings.php' ?>
                                <?php require_once 'carousel/ptx-inc-tabs-carousel.php' ?>
                            </form>
                            <div class="grid">
                                <div class="col-1-1">
                                    <button class="btn is-secondary is-right" id="options-admin-save" form="plugin-options-form" type="submit"><?php _e('Save All', $this->pluginName); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
