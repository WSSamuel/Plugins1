<?php


function ic_add_new_display(){
    
    $categories = get_categories();
    
    ?>
    
   <script>
	jQuery(document).ready(function () {
		jQuery("#insert_in_post_after_para").hide();
    jQuery("#insert_in_post_position").change(function(){
        var op_val = jQuery(this).val();
        if (op_val == "after-para") {
            jQuery("#insert_in_post_after_para").show();
		}
    })
	});
	
	
	function ic_validate_add_new() {
        //alert("Bla Bla Bla");
        //return false;
		var j_type = document.getElementById("ic_type_select").value;
		var j_name = document.getElementById("ic_entry_name").value;
		var temp;
		
		switch(j_type){
			case "insert_in_post":
				temp = document.getElementById("insert_in_post_content").value;
				break;
			case "html":
				temp = document.getElementById("html_code_insert").value;
				break;
			case "insert_css":
				temp = document.getElementById("insert_css_css").value;
				break;
			case "insert_js":
				temp = document.getElementById("insert_js_js").value;
				break;
			case "embed":
				temp = document.getElementById("embed_content").value;
				break;
			case "css_individual":
				temp = document.getElementById("css_individual_css").value;
				break;
			case "js_individual":
				temp = document.getElementById("js_individual_js").value;
				break;
			case "pdf":
				temp = document.getElementById("pdf_content").value;
				break;
			case "youtube":
				temp = document.getElementById("youtube_link").value;
				break;
			case "php":
				temp = document.getElementById("php_code_insert").value;
				break;
		}
		
		if (temp == "" || j_name == "" || !j_type) {
            alert("Please Fill All The Required *Fields!");
			return false;
        }
		
    }
	</script>
   
   
	
	
    
    <!-- Start of the form -->
    <form id="ic_add_new_form" action="" method="post" onsubmit="return ic_validate_add_new()">
    
    <!-- Start of Main div -->
    <div class="icp_div_1">
	
    <!-- Start of Initial Components -->
        <div class="row">
            <div class="col-sm-10">	
            <?php esc_html_e('*Name:', 'insertify'); ?><input type="text" id="ic_entry_name" name="name" required><?php esc_html_e('(should be unique)', 'insertify'); ?>
            </div>
            <div class="col-sm-2">	
            <?php esc_html_e('*Active', 'insertify'); ?><br><label class="ic_switch"><input type="checkbox" name="activeness" checked><span class="ic_slider round"></span></label>
            </div>
        </div>


        <?php esc_html_e('*Type: ', 'insertify'); ?> 
        <select id="ic_type_select" name="type" required>
          <option value="insert_in_post"><?php esc_html_e('Insert Ad/Content', 'insertify'); ?></option>
		  <option value="html"><?php esc_html_e('HTML Snippet', 'insertify'); ?></option>
          <option value="insert_css"><?php esc_html_e('Insert CSS', 'insertify'); ?></option>
          <option value="insert_js"><?php esc_html_e('Insert JS', 'insertify'); ?></option>
          <option value="embed"><?php esc_html_e('Header & Footer', 'insertify'); ?></option>
          <option value="css_individual"><?php esc_html_e('CSS (individual)', 'insertify'); ?></option>
          <option value="js_individual"><?php esc_html_e('JS (individual)', 'insertify'); ?></option>
          <option value="pdf"><?php esc_html_e('Embed PDF', 'insertify'); ?></option>
          <option value="youtube"><?php esc_html_e('Youtube Video', 'insertify'); ?></option>
		  <option value="php"><?php esc_html_e('PHP Snippet', 'insertify'); ?></option>
        </select>
    <!-- End of Initial Components -->
    

    <!-- Start of Insert in Post div -->
    <div id="insert_in_post" class="ic_type">
        <div class="icp_div_2">
            <center><p><i><?php esc_html_e('Insert Ad/Contents to Posts in Different Positions Based on Categories', 'insertify'); ?></i></p></center>
            <br>
            <?php esc_html_e('Position in Post: ', 'insertify'); ?><select id="insert_in_post_position" name="insert_in_post_ex_type_1">
                        <option value="start"><?php esc_html_e('Start', 'insertify'); ?></option>
                        <option value="end"><?php esc_html_e('End', 'insertify'); ?></option>
                        <option value="middle"><?php esc_html_e('Middle', 'insertify'); ?></option>
                        <option value="one-fourth"><?php esc_html_e('One-Fourth', 'insertify'); ?></option>
                        <option value="third-fourth"><?php esc_html_e('Third-Fourth', 'insertify'); ?></option>
						<option value="after-para"><?php esc_html_e('After Specific Para', 'insertify'); ?></option>
                      </select>
			
			<div id="insert_in_post_after_para">
				<br><br><?php esc_html_e('After No. of Para: ', 'insertify'); ?><input type="number" name="insert_in_post_number_1" value="2" min="0" step="1">
			</div>
			
            
            <br><br>
            
            <?php esc_html_e('Category: ', 'insertify'); ?><select id="insert_in_post_category" name="insert_in_post_position_data_1">
                        <option value="all"><?php esc_html_e('All', 'insertify'); ?></option>
                        
                        <?php foreach($categories as $category){ ?>
                            <option value="<?php echo $category->name; ?>"> <?php echo $category->name; ?> </option>
                            
                        <?php } ?>
                        
                      </select>
            
            <br><br>
            
            <?php esc_html_e('*Content:', 'insertify'); ?>
             <?php wp_editor("Content Here!","insert_in_post_content", array('textarea_rows'=>10, 'textarea_name'=>'insert_in_post_content_1')); ?>
            
        </div>
    </div>
    <!-- End of Insert in Post div -->
	
	
	
		<!-- Start of insert html div -->
    <div id="html" class="ic_type">
        
        <div class="icp_div_2">
            <center><p><i><?php esc_html_e('Write HTML here and use it anywhere with the generated shortcode.', 'insertify'); ?></i></p></center>
            
			<br>
			
            <?php esc_html_e('*HTML: ', 'insertify'); ?><br>
			<?php wp_editor("Content Here!","html_code_insert", array('textarea_rows'=>15, 'textarea_name'=>'html_content_1')); ?>
			
			<br><br>
			
			<?php esc_html_e('Description: ', 'insertify'); ?><br>
            <textarea rows="2" cols="80" id="html_description_insert" name="html_content_2" class="ic_text_area"></textarea>
        
        
        </div>
        
    </div>
    <!-- End of insert html div -->
    
    
    
    
    <!-- Start of Insert CSS div -->
    <div id="insert_css" class="ic_type">
        
        <div class="icp_div_2">
            <center><p><i><?php esc_html_e('Insert CSS for the Whole Site or the Admin Area', 'insertify'); ?><br><?php esc_html_e('(You may need to reload after inserting CSS to admin area for the effects)', 'insertify'); ?></i></p></center>
            <br>
            <?php esc_html_e('Where To: ', 'insertify'); ?><select id="insert_css_option" name="insert_css_ex_type_1">
                        <option value="site"><?php esc_html_e('Site', 'insertify'); ?></option>
                        <option value="admin"><?php esc_html_e('Admin Area', 'insertify'); ?></option>
                      </select>
            
            <br><br>
            
            <?php esc_html_e('*CSS: ', 'insertify'); ?><br>
            <textarea rows="8" cols="80" id="insert_css_css" name="insert_css_content_1" class="ic_text_area"></textarea>
            
        </div>   
        
    </div>
    <!-- End of Insert CSS div -->
    
    
    
    
    
    <!-- Start of Insert JS div -->
    <div id="insert_js" class="ic_type">
        
        
        <div class="icp_div_2">
            <center><p><i><?php esc_html_e('Insert JS for the Whole Site or the Admin Area', 'insertify'); ?><br><?php esc_html_e('(You may need to reload after inserting JS to admin area for the effects)', 'insertify'); ?></i></p></center>
            <br>
            <?php esc_html_e('Where To: ', 'insertify'); ?><select id="insert_js_option" name="insert_js_ex_type_1">
                        <option value="site"><?php esc_html_e('Site', 'insertify'); ?></option>
                        <option value="admin"><?php esc_html_e('Admin Area', 'insertify'); ?></option>
                      </select>
            
            <br><br>
            
            <?php esc_html_e('*JavaScript: ', 'insertify'); ?><br>
            <textarea rows="8" cols="80" id="insert_js_js" name="insert_js_content_1" class="ic_text_area"></textarea>
            
        </div>
        
        
    </div>
    <!-- End of Insert JS div -->
    
    
        
    
    <!-- Start of Embed Header Footer div -->
    <div id="embed" class="ic_type">
        
        
        <div class="icp_div_2">
            <center><p><i><?php esc_html_e('Embed Script in Header or Footer Area', 'insertify'); ?></i></p></center>
            <br>
            <?php esc_html_e('Embed In: ', 'insertify'); ?><select id="embed_area" name="embed_ex_type_1">
                        <option value="head"><?php esc_html_e('Header Area', 'insertify'); ?></option>
                        <option value="foot"><?php esc_html_e('Footer Area', 'insertify'); ?></option>
                      </select>
            
            <br><br>
            
            <?php esc_html_e('*Content: ', 'insertify'); ?><br>
            <?php wp_editor("Content Here!","embed_content", array('textarea_rows'=>10, 'textarea_name'=>'embed_content_1')); ?>
            
        </div>
        
        
    </div>
    <!-- End of Embed Header Footer div -->
    
    
    
    
    <!-- Start of CSS individual div -->
    <div id="css_individual" class="ic_type">
        
        <div class="icp_div_2">
            <center><p><i><?php esc_html_e('Insert CSS in Page or Post Using Shortcode', 'insertify'); ?></i></p></center>
            
            <?php esc_html_e('*CSS: ', 'insertify'); ?><br>
            <textarea rows="8" cols="80" id="css_individual_css" name="css_individual_content_1" class="ic_text_area"></textarea>
        
        
        </div>
        
    </div>
    <!-- End of CSS individual div -->
    
    
    
    
    <!-- Start of JS individual div -->
    <div id="js_individual" class="ic_type">
        
        <div class="icp_div_2">
            <center><p><i><?php esc_html_e('Insert JavaScript in Page or Post Using Shortcode', 'insertify'); ?></i></p></center>
            
            <?php esc_html_e('*JavaScript: ', 'insertify'); ?><br>
            <textarea rows="8" cols="80" id="js_individual_js" name="js_individual_content_1" class="ic_text_area"></textarea>
        
        
        </div>
        
    </div>
    <!-- End of JS individual div -->
    
    
    
    
    <!-- Start of embed PDF div -->
    <div id="pdf" class="ic_type">
        
        <div class="icp_div_2">
            <center><p><i><?php esc_html_e('Embed PDF Anywhere Using Shortcode', 'insertify'); ?></i></p></center>
            
            <?php esc_html_e('Width: ', 'insertify'); ?><input type="text" id="pdf_width" name="pdf_data_1" value="100%" size="10" style="margin-right: 30%;">
            <?php esc_html_e('Height: ', 'insertify'); ?><input type="text" id="pdf_height" name="pdf_data_2" value="600px" size="10" >
            
            <br><br>
            
            <?php esc_html_e('*PDF (Enter PDF file link or upload with ', 'insertify'); ?><b><?php esc_html_e('Add Media', 'insertify'); ?></b>): <br><br>
            <?php wp_editor("","pdf_content", array('textarea_rows'=>3, 'textarea_name'=>'pdf_content_1', 'editor_css'=>'<style> #qt_pdf_content_toolbar, #pdf_content-tmce, #pdf_content-html{display:none;} </style>' )); ?>
            
            <br><br>
            
            <?php esc_html_e('CSS Style:', 'insertify'); ?><br>
            <textarea rows="4" cols="80" id="pdf_style" name="pdf_content_style" class="ic_text_area"></textarea>
        
        </div>
        
    </div>
    <!-- End of embed PDF div -->
    
    
    
    
    <!-- Start of Youtube video div -->
    <div id="youtube" class="ic_type">
        
        <div class="icp_div_2">
            <center><p><i><?php esc_html_e('Embed Youtube Video Anywhere Using Shortcode', 'insertify'); ?></i></p></center>
            
            <?php esc_html_e('Width: ', 'insertify'); ?><input type="text" id="youtube_width" name="youtube_data_1" value="560px" size="10" style="margin-right: 30%;">
            <?php esc_html_e('Height: ', 'insertify'); ?><input type="text" id="youtube_height" name="youtube_data_2" value="315px" size="10" >
            
            <br><br>
            
            <?php esc_html_e('*Video Link or Video ID: ', 'insertify'); ?><br>
            <textarea rows="2" cols="80" id="youtube_link" name="youtube_content_1" class="ic_text_area"></textarea>
            
            <br><br>
            
            <?php esc_html_e('CSS Style: ', 'insertify'); ?><br>
            <textarea rows="4" cols="80" id="youtube_style" name="youtube_content_style" class="ic_text_area"></textarea>
        
        </div>
        
    </div>

	<!-- End of Youtube video div -->
	
	
	
	
	
	<!-- Start of insert php div -->
    <div id="php" class="ic_type">
        
        <div class="icp_div_2">
            <center><p><i><?php esc_html_e("It's Recommended Not to Use, If You Are Not Good at It.", "insertify"); ?><br>
            <?php esc_html_e('Wrong Codes Can Break Your Site!', 'insertify'); ?><br>
            <?php esc_html_e("Don't Use PHP Start & End Tags.", "insertify"); ?></i></p></center>
            
			<br>
			<?php esc_html_e('*Use In/With: ', 'insertify'); ?><select id="use_in_with" name="php_shortcode">
                        <option value="yes"><?php esc_html_e('With Shortcode', 'insertify'); ?></option>
                      </select>
			
			<br><br>
			
            <?php esc_html_e('*PHP Code: ', 'insertify'); ?><br>
            <textarea rows="8" cols="80" id="php_code_insert" name="php_content_1" class="ic_text_area"></textarea>
			
			<br><br>
			
			<?php esc_html_e('Description: ', 'insertify'); ?><br>
            <textarea rows="3" cols="80" id="php_description_insert" name="php_content_2" class="ic_text_area"></textarea>
        
        
        </div>
        
    </div>
    <!-- End of insert php div -->
	
	
	
	
	
	
	
	
	

</div>
 <!-- End of Main div -->
 
 
    <input type="submit" value="<?php esc_html_e('Add Entry', 'insertify'); ?>" name="ic_add_new_submit" class="icp_button_1">
 
 
    </form>
 <!-- End of the form -->
    
    
    
    <?php
    
}

