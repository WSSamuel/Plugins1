<?php
/*
 * Plugin Name:       Delete Old Posts and Pictures
 * Plugin URI:        https://plugins.wizehawk.com/delete-old-posts/
 * Description:       This plugin allows you to delete either posts or media defined by the number of months old.
 * Version:           2.1.4
 * Requires at least: 6.2
 * Requires PHP:      8.1
 * Author:            WizeHawk Plugins
 * Update URI:        https://wordpress.org/plugins/delete-old-posts-and-pictures
 */

add_action('admin_menu', 'delete_old_posts_pictures_menu');

function delete_old_posts_pictures_menu() {
    add_menu_page('Delete Old Posts and Pictures', 'Delete Old Posts and Pictures', 'manage_options', 'delete-old-posts-pictures', 'delete_old_posts_pictures_page');
}

function delete_old_posts_pictures_page() {
    if (isset($_POST['delete_old_posts']) || isset($_POST['delete_old_pictures'])) {
        // Verify the nonce
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'delete_old_posts_nonce')) {
            wp_die('Invalid nonce.');
        }
    }
    ?>
    <div class="wrap">
        <h2>Delete Old Posts and Pictures</h2>
        <div style="background-color: white; color:red; display: inline-block; padding: 10px;">
            <center><strong>WARNING</strong><br> This process <strong>CAN NOT</strong> be reversed. The deletion of posts/media files is <strong>PERMANENT</strong>. <br>Make sure to do a <strong>BACKUP before proceeding.</strong></center>
        </div>

        <form method="post">
            <?php wp_nonce_field('delete_old_posts_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="months">Delete Entries that are:</label></th>
                    <td><input type="number" name="months" id="months" value="6" min="1" max="999" > <B>Months Old and Older</B></td>
                </tr>
            </table>

            <?php submit_button('Delete Old Posts', 'primary', 'delete_old_posts'); ?>
            <?php submit_button('Delete Old Pictures', 'primary', 'delete_old_pictures'); ?>

        </form>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete these old posts or pictures? This process cannot be reversed.");
        }

        const deletePostButton = document.getElementById('delete_old_posts');
        deletePostButton.addEventListener('click', (event) => {
            if (!confirmDelete()) {
                event.preventDefault();
            }
        });

        const deletePictureButton = document.getElementById('delete_old_pictures');
        deletePictureButton.addEventListener('click', (event) => {
            if (!confirmDelete()) {
                event.preventDefault();
            }
        });
    </script>
    <?php
    if (isset($_POST['delete_old_posts'])) {
        $months = intval($_POST['months']);
        if ($months > 0) {
            global $wpdb;
            $wpdb->query("DELETE FROM $wpdb->posts WHERE post_type = 'post' AND post_date < DATE_SUB(NOW(), INTERVAL $months MONTH)");
            echo '<div class="updated"><p>Old posts deleted.</p></div>';
        }
    }
    if (isset($_POST['delete_old_pictures'])) {
        $months = intval($_POST['months']);
        if ($months > 0) {
            global $wpdb;
            $wpdb->query("DELETE FROM $wpdb->posts WHERE post_type = 'attachment' AND post_date < DATE_SUB(NOW(), INTERVAL $months MONTH)");
            echo '<div class="updated"><p>Old pictures deleted.</p></div>';
        }
    }
}
?>
