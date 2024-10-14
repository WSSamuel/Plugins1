<?php
/**
 * @var $usePlaceholders bool
 * @var $sidebars        array
 * @var $itemsByArea     array
 */

use glxtm\scriptsControl\admin\widgets\header\Header;
use glxtm\scriptsControl\admin\widgets\itemRow\ItemRow;
use glxtm\scriptsControl\core\admin\helpers\AdminHtml;
use glxtm\scriptsControl\core\admin\helpers\AdminUrl;
use glxtm\scriptsControl\core\helpers\ArrayHelper;
use glxtm\scriptsControl\plugin\entities\Area;

?>
<style>
    .glxtmGrid {
        display: grid;
        grid-template-columns: 2fr 1fr;
    }

    .glxtmGrid .glxtmLayoutSidebars {
        padding-left: 20px;
    }

    .glxtmSidebar {
        border: 1px solid #aaa;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 20px;
    }
</style>
<script>
    jQuery(function () {
        var sidebarsCtx = jQuery('.glxtmLayoutSidebars');
        sidebarsCtx.on("click", ".glxtmBtnShowSidebars", function () {
            var expire = new Date(Date.now() + 600e3); // 10 minutes
            document.cookie = '__expose_sidebars=1;expires=' + expire.toGMTString() + ';path=/';
            document.location = '<?php echo htmlspecialchars(get_site_url()); ?>';
            return false;
        });
        sidebarsCtx.on("click", ".glxtmSidebarRemove", function () {
            var sidebarCtx = jQuery(this).closest(".glxtmSidebar");
            var items = jQuery('.glxtmManage_item', sidebarCtx);
            if (items.length > 0) {
                alert("<?= esc_html__('You should remove all items from sidebar before unregistering it', 'galaksion-tag-manager') ?>");
                return false;
            }
        });
    })
</script>

<div class="wrap">
    <?= Header::widget(['tab' => 'scripts']) ?>

    <div class="glxtmManage">
        <div class="glxtmGrid">
            <div class="glxtmLayoutMain">
                <div class="glxtmManage_tag">
                    &lt;html&gt;
                    <br>
                    &lt;head&gt;
                </div>
                <div class="glxtmManage_area" data-id="<?= Area::HEAD ?>">
                    <div class="glxtmManage_items">
                        <?php
                        foreach (ArrayHelper::getValue($itemsByArea, Area::HEAD, []) as $item) {
                            echo ItemRow::widget(['item' => $item]);
                        }
                        ?>
                    </div>
                    <div class="glxtmManage_add">
                        <?= AdminHtml::button(esc_html__('Add Code', 'galaksion-tag-manager')) ?>
                    </div>
                </div>
                <div class="glxtmManage_tag">
                    &lt;/head&gt;
                    <br/>
                    &lt;body&gt;
                </div>
                <div class="glxtmManage_area" data-id="<?= Area::BODY_BEGIN ?>">
                    <div class="glxtmManage_items">
                        <?php
                        foreach (ArrayHelper::getValue($itemsByArea, Area::BODY_BEGIN, []) as $item) {
                            echo ItemRow::widget(['item' => $item]);
                        }
                        ?>
                    </div>
                    <div class="glxtmManage_add">
                        <?= AdminHtml::button(esc_html__('Add Code', 'galaksion-tag-manager')) ?>
                    </div>
                </div>
                <div class="glxtmManage_tag">
                    <?= esc_html__('page content', 'galaksion-tag-manager') ?> …
                    <br/>
                    &lt;article&gt;
                    <br/>
                    &lt;h1&gt;Post Title&lt;/h1&gt;
                </div>
                <div class="glxtmManage_area" data-id="<?= Area::POST_BEGIN ?>">
                    <div class="glxtmManage_items">
                        <?php
                        foreach (ArrayHelper::getValue($itemsByArea, Area::POST_BEGIN, []) as $item) {
                            echo ItemRow::widget(['item' => $item]);
                        }
                        ?>
                    </div>
                    <div class="glxtmManage_add">
                        <?= AdminHtml::button(esc_html__('Add Code', 'galaksion-tag-manager')) ?>
                    </div>
                </div>
                <div class="glxtmManage_tag">
                    &lt;p&gt;Post content&lt;/p&gt;
                </div>
                <div class="glxtmManage_area" data-id="<?= Area::POST_END ?>">
                    <div class="glxtmManage_items">
                        <?php
                        foreach (ArrayHelper::getValue($itemsByArea, Area::POST_END, []) as $item) {
                            echo ItemRow::widget(['item' => $item]);
                        }
                        ?>
                    </div>
                    <div class="glxtmManage_add">
                        <?= AdminHtml::button(esc_html__('Add Code', 'galaksion-tag-manager')) ?>
                    </div>
                </div>
                <div class="glxtmManage_tag">
                    &lt;/article&gt;
                </div>
                <?php if($usePlaceholders): ?>
                <div class="glxtmManage_tag">
                    … <?= esc_html__('page content', 'galaksion-tag-manager') ?> …
                </div>
                <div class="glxtmManage_area" data-id="<?= Area::CONTENT_PLACEHOLDER_1 ?>">
                    Inside the page content by placeholder:
                    <input readonly value="&lt;!-- glx-tag-1 --&gt;"
                           onclick="this.setSelectionRange(0, this.value.length);"/>
                    <a href="#" alt="copy" class="dashicons dashicons-admin-links" style="display: inline-block;"
                       title="copy to clipboard"
                       onclick="!!function(i){for(;i;i=i.previousSibling){if(typeof i.tagName=='string'&&i.tagName.toLowerCase()=='input') { i.focus(); i.setSelectionRange(0, i.value.length);document.execCommand('copy');return;} }}(this); return false;"></a>
                    <br/>(add this placeholder to the desired place in your template)
                    <div class="glxtmManage_items">
                        <?php
                        foreach (ArrayHelper::getValue($itemsByArea, Area::CONTENT_PLACEHOLDER_1, []) as $item) {
                            echo ItemRow::widget(['item' => $item]);
                        }
                        ?>
                    </div>
                    <div class="glxtmManage_add">
                        <?= AdminHtml::button(esc_html__('Add Code', 'galaksion-tag-manager')) ?>
                    </div>
                </div>
                <div class="glxtmManage_tag">
                    … <?= esc_html__('page content', 'galaksion-tag-manager') ?> …
                </div>
                <div class="glxtmManage_area" data-id="<?= Area::CONTENT_PLACEHOLDER_2 ?>">
                    Inside the page content by placeholder:
                    <input readonly value="&lt;!-- glx-tag-2 --&gt;"
                           onclick="this.setSelectionRange(0, this.value.length);"/>
                    <a href="#" alt="copy" class="dashicons dashicons-admin-links" style="display: inline-block;"
                       title="copy to clipboard"
                       onclick="!!function(i){for(;i;i=i.previousSibling){if(typeof i.tagName=='string'&&i.tagName.toLowerCase()=='input') { i.focus(); i.setSelectionRange(0, i.value.length);document.execCommand('copy');return;} }}(this); return false;"></a>
                    <br/>(add this placeholder to the desired place in your template)
                    <div class="glxtmManage_items">
                        <?php
                        foreach (ArrayHelper::getValue($itemsByArea, Area::CONTENT_PLACEHOLDER_2, []) as $item) {
                            echo ItemRow::widget(['item' => $item]);
                        }
                        ?>
                    </div>
                    <div class="glxtmManage_add">
                        <?= AdminHtml::button(esc_html__('Add Code', 'galaksion-tag-manager')) ?>
                    </div>
                </div>
                <div class="glxtmManage_tag">
                    … <?= esc_html__('page content', 'galaksion-tag-manager') ?> …
                </div>
                <div class="glxtmManage_area" data-id="<?= Area::CONTENT_PLACEHOLDER_3 ?>">
                    Inside the page content by placeholder:
                    <input readonly value="&lt;!-- glx-tag-3 --&gt;"
                           onclick="this.setSelectionRange(0, this.value.length);"/>
                    <a href="#" alt="copy" class="dashicons dashicons-admin-links" style="display: inline-block;"
                       title="copy to clipboard"
                       onclick="!!function(i){for(;i;i=i.previousSibling){if(typeof i.tagName=='string'&&i.tagName.toLowerCase()=='input') { i.focus(); i.setSelectionRange(0, i.value.length);document.execCommand('copy');return;} }}(this); return false;"></a>
                    <br/>(add this placeholder to the desired place in your template)
                    <div class="glxtmManage_items">
                        <?php
                        foreach (ArrayHelper::getValue($itemsByArea, Area::CONTENT_PLACEHOLDER_3, []) as $item) {
                            echo ItemRow::widget(['item' => $item]);
                        }
                        ?>
                    </div>
                    <div class="glxtmManage_add">
                        <?= AdminHtml::button(esc_html__('Add Code', 'galaksion-tag-manager')) ?>
                    </div>
                </div>
                <?php else: ?>
                <?php endif; ?>
                <div class="glxtmManage_tag">
                    … <?= esc_html__('page content', 'galaksion-tag-manager') ?>
                </div>
                <div class="glxtmManage_area" data-id="<?= Area::BODY_END ?>">
                    <div class="glxtmManage_items">
                        <?php
                        foreach (ArrayHelper::getValue($itemsByArea, Area::BODY_END, []) as $item) {
                            echo ItemRow::widget(['item' => $item]);
                        }
                        ?>
                    </div>
                    <div class="glxtmManage_add">
                        <?= AdminHtml::button(esc_html__('Add Code', 'galaksion-tag-manager')) ?>
                    </div>
                </div>
                <div class="glxtmManage_tag">
                    &lt;/body&gt;
                    <br>
                    &lt;/html&gt;
                </div>
            </div>
            <div class="glxtmLayoutSidebars">
                <h2><?= esc_html__('Registered sidebars:', 'galaksion-tag-manager') ?></h2>
                <?php
                if (count($sidebars) > 0) {
                    foreach ($sidebars as $sidebar) {
                        ?>
                        <div class="glxtmSidebar">
                            <form method="post" action="<?= AdminUrl::toOptions('scripts', 'removeSidebar') ?>"
                                  style="float:right;margin:10px 0 0 20px;">
                                <?= AdminHtml::textInput('id', $sidebar->id, ['type' => 'hidden']) ?>
                                <?= AdminHtml::button(esc_html__('Unregister this sidebar', 'galaksion-tag-manager'), [
                                    'submit' => true, 'class' => 'glxtmSidebarRemove',
                                ]) ?>
                            </form>
                            <h3>
                                <a name="sidebar-<?= htmlspecialchars($sidebar->id) ?>"></a><?= htmlspecialchars($sidebar->id); ?>
                            </h3>
                            <div class="glxtmManage_area"
                                 data-id="<?= Area::SIDEBAR_FIRST_PREFIX . htmlspecialchars($sidebar->id); ?>">
                                <div class="glxtmManage_items">
                                    <?php
                                    foreach (ArrayHelper::getValue($itemsByArea, Area::SIDEBAR_FIRST_PREFIX . $sidebar->id, []) as $item) {
                                        echo ItemRow::widget(['item' => $item]);
                                    }
                                    ?>
                                </div>
                                <div class="glxtmManage_add">
                                    <?= AdminHtml::button(esc_html__('Add Code', 'galaksion-tag-manager')) ?>
                                </div>
                            </div>
                            <div class="glxtmManage_tag">
                                … <?= esc_html__('sidebar content', 'galaksion-tag-manager') ?> …
                            </div>
                            <div class="glxtmManage_area"
                                 data-id="<?= Area::SIDEBAR_LAST_PREFIX . htmlspecialchars($sidebar->id); ?>">
                                <div class="glxtmManage_items">
                                    <?php
                                    foreach (ArrayHelper::getValue($itemsByArea, Area::SIDEBAR_LAST_PREFIX . $sidebar->id, []) as $item) {
                                        echo ItemRow::widget(['item' => $item]);
                                    }
                                    ?>
                                </div>
                                <div class="glxtmManage_add">
                                    <?= AdminHtml::button(esc_html__('Add Code', 'galaksion-tag-manager')) ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="glxtmManage_tag"><?= esc_html__('-- no sidebars registered --', 'galaksion-tag-manager') ?></div><?php
                }
                ?>
                <div class="glxtmManage_tag">
                    <button class="button glxtmBtnShowSidebars" type="button"
                    ><?= esc_html__('Pick sidebar from website', 'galaksion-tag-manager') ?></button>
                </div>
            </div>
        </div>
    </div>
</div>