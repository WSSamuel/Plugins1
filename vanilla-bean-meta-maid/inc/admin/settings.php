<?php

/* 
 * Copyright (C) 2014 Velvary Pty Ltd
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace VanillaBeans\MetaMaid;
            // If this file is called directly, abort.
            if ( ! defined( 'WPINC' ) ) {
                    die;
            }


function RegisterSettings(){
	register_setting( 'vbean-meta-maid-settings', 'vbean_meta_maid_htmlhead' );
	register_setting( 'vbean-meta-maid-settings', 'vbean_meta_maid_htmlbeforeclosebody' );
    
	register_setting( 'vbean-meta-maid-settings', 'vbean_meta_maid_mobilehtmlhead' );
	register_setting( 'vbean-meta-maid-settings', 'vbean_meta_maid_mobilehtmlbeforeclosebody' );
    
	register_setting( 'vbean-meta-maid-settings', 'vbean_meta_maid_desktophtmlhead' );
	register_setting( 'vbean-meta-maid-settings', 'vbean_meta_maid_desktophtmlbeforeclosebody' );
    
}

function SettingsPage(){
    ?>

<style>
.pixelplug{display:none;}
</style>

        <div class="wrap">
        <h2>Vanilla Bean Meta-maid Settings</h2>
        <p>This is a very simple plugin. It allows you to add your tracking code and other meta code to your header and footer sections of every page.</p>
        <p>No fuss or fancy stuff. HTML code familiarity is adviseable.</p>
        <p>To help with analytics code, substitutions available using double hashes: <ul>
            <li>##wpcatid## = category id</li>
            <li>##wpcatname## = category name</li>
            <li>##wppageid## = page or post id</li>
        </ul></p>
            <form method="post" action="options.php">

    <?php settings_fields( 'vbean-meta-maid-settings' ); ?>
    <?php do_settings_sections( 'vbean-meta-maid-settings' ); ?>
                <table class="form-table">

                    <tr valign="top">
                        <th scope="row">Header</th>
                        <td><textarea cols="60" rows="3" name="vbean_meta_maid_htmlhead" id="vbean_meta_maid_htmlhead"><?php echo esc_textarea(\VanillaBeans\vbean_setting('vbean_meta_maid_htmlhead',''))?></textarea>
                            <div class="description">Code to appear between &lt;head&gt;&lt;/head&gt;</div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">End of Page</th>
                        <td><textarea cols="60" rows="3" name="vbean_meta_maid_htmlbeforeclosebody" id="vbean_meta_maid_htmlbeforeclosebody"><?php echo esc_textarea(\VanillaBeans\vbean_setting('vbean_meta_maid_htmlbeforeclosebody',''))?></textarea>
                            <div class="description">Code to appear before &lt;/body&gt;</div>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Header (MOBILE ONLY)</th>
                        <td><textarea cols="60" rows="3" name="vbean_meta_maid_mobilehtmlhead" id="vbean_meta_maid_mobilehtmlhead"><?php echo esc_textarea(\VanillaBeans\vbean_setting('vbean_meta_maid_mobilehtmlhead',''))?></textarea>
                            <div class="description">Code to appear between &lt;head&gt;&lt;/head&gt;</div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">End of Page (MOBILE ONLY)</th>
                        <td><textarea cols="60" rows="3" name="vbean_meta_maid_mobilehtmlbeforeclosebody" id="vbean_meta_maid_mobilehtmlbeforeclosebody"><?php echo esc_textarea(\VanillaBeans\vbean_setting('vbean_meta_maid_mobilehtmlbeforeclosebody',''))?></textarea>
                            <div class="description">Code to appear before &lt;/body&gt;</div>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Header (DESKTOP ONLY)</th>
                        <td><textarea cols="60" rows="3" name="vbean_meta_maid_desktophtmlhead" id="vbean_meta_maid_desktophtmlhead"><?php echo esc_textarea(\VanillaBeans\vbean_setting('vbean_meta_maid_desktophtmlhead',''))?></textarea>
                            <div class="description">Code to appear between &lt;head&gt;&lt;/head&gt;</div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">End of Page (DESKTOP ONLY)</th>
                        <td><textarea cols="60" rows="3" name="vbean_meta_maid_desktophtmlbeforeclosebody" id="vbean_meta_maid_desktophtmlbeforeclosebody"><?php echo esc_textarea(\VanillaBeans\vbean_setting('vbean_meta_maid_desktophtmlbeforeclosebody',''))?></textarea>
                            <div class="description">Code to appear before &lt;/body&gt;</div>
                        </td>
                    </tr>

                </table>


            <?php submit_button(); ?>
            </form>
        </div>    

<?php
}



