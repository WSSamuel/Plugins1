<?php
/*
	This file outputs part of the configuration panel
*/
?>
<style type="text/css">
	.configwidget div {
		font-family: Arial, Helvetica;
		font-size: 11px;
	}
	.configwidget div.section {
		border: 1px solid #CCCCCC;
		margin: 20px 5px;
		padding: 0px 0px 5px 0px;
		background-color: #EEEEEE;
		height: 65px;
	}
	.configwidget div#createNew {
		border: 1px solid #B9CDE5;
		margin: 30px 5px;
		padding: 0px 0px 10px 0px;
		background-color: #DCE6F2;
	}
	.configwidget div#createNew h3{
		font-size: 14px;
		padding: 2px 5px;
		margin: 0 0 10px 0;
		background-color: #B9CDE5;
		color: #FFFFFF;
		display: block;
	}
	.configwidget div.toolsection {
		border: 1px solid #CDEB8B;
		margin: 30px 5px;
		padding: 0px 0px 10px 0px;
		background-color: #DFF2B5;
		height: 160px;
	}	
	.configwidget div.toolsection h3{
		font-size: 14px;
		padding: 2px 5px;
		margin: 0 0 10px 0;
		background-color: #CDEB8B;
		color: #FFFFFF;
		display: block;
	}
	.configwidget .previewcontainer {
		text-align: center;
	}
	.configwidget .displaypreview {
		text-align: center;
		height: 140px;
		overflow: auto;
	}
	.configwidget .displaypreview p {
		margin: 10px;
		padding: 0px;
	}
	.configwidget .displaypreview img {
		width: 16px;
		height: 16px;
		margin: 2px;
		vertical-align: middle;
	}
	.configwidget div#createNew input {
		margin-left: 5px;
	}
	.configwidget div#createNew p {
		margin: 5px;
		padding: 0px;
		font-size: 14px;
	}
	.configwidget div.section h3{
		font-size: 14px;
		padding: 2px 5px;
		margin: 0 0 5px 0;
		background-color: #CCCCCC;
		display: block;
	}
	.configwidget div.section h3 {
		cursor: move;
	}
	.configwidget div.lineitem {
		margin: 3px 10px;
		padding: 2px;
		background-color: #FFFFFF;
		border: 1px solid #DDDDDD;
		cursor: move;
		display: block;
		width: 100px;
		position: relative;
		float: left;
		vertical-align: middle;
		height: 16px;
	}
	.configwidget div.lineitem p {
		float: none;
		margin: 0px;
		padding: 0px;
	}
	.configwidget div.lineitem img {
		vertical-align: middle;
		margin-right: 5px;
		width: 16px;
		height: 16px;
	}

	.configwidget h1 {
		margin-bottom: 0;
		font-size: 18px;
	}
	.configwidget hr {
		border: 1px solid #EEEEEE;
		height: 1px;
	}
</style>
<?php global $overrideoptions; if ($overrideoptions != 'true') { ?>
<input class="zerosize" type="button" name="configchange" id="configchange" value="Switch to advanced" onclick="javascript:ChangeMode();" />
<input type="hidden" name="dropdown_configmode" id="dropdown_configmode" value="basic" />
<div id="configmessage">Advanced mode is available if you have JavaScript enabled.</div>
<div id="dropconfigbasic">
<p>Select the bookmarks you want to display:</p>
<input type="hidden" name="offset" value="10" />
<?php
$all = explode("|",$dropdown_all);
$bookline = explode("|",str_replace(',','|',get_option('dropdown_query')));
?>
<ul style="list-style: none; margin: 0px; padding: 0px;">
<?php

for ($counter = 0; $counter < count($all); $counter += 1) {
echo '<li><input type="checkbox" name="'.$all[$counter].'" value="1" id="'.$all[$counter].'"';
if(in_array($all[$counter],$bookline)) { echo 'checked="checked"'; }
echo ' /> '.$all[$counter]."\r\n";
}

?>
</ul>
</div>
<div id="dropconfigadvanced" class="zerosize">

<script type="text/javascript" src="<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/ajax.js"></script>
<script type="text/javascript" src="<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/thescripts/prototype.js"></script>
<script type="text/javascript" src="<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/thescripts/scriptaculous.js"></script>

<?php include_once('generatebookmarks.php'); ?>

<script type="text/javascript">
	sections = [<?php GetBookmarkSections(); ?>];

	function createNewSection(name) {
		var name = $F('sectionName');
		name = ' ';
		if (name != '') {
			var newDiv = Builder.node('div', {id: 'group' + (sections.length + 1), className: 'section', style: 'display:none;' }, [
				Builder.node('h3', {className: 'handle'}, name)
			]);

			sections.push(newDiv.id);
			$('page').appendChild(newDiv);
			Effect.Appear(newDiv.id);
			destroyLineItemSortables();
			createLineItemSortables();
			createGroupSortable();
		}
	}

	function createLineItemSortables() {
		for(var i = 0; i < sections.length; i++) {
			Sortable.create(sections[i],{tag:'div',dropOnEmpty: true, containment: sections,only:'lineitem', overlap: 'horizontal',constraint:false,onChange:function(){pushinfo()}});
		}
	}

	function destroyLineItemSortables() {
		for(var i = 0; i < sections.length; i++) {
			Sortable.destroy(sections[i]);
		}
	}

	function createGroupSortable() {
		Sortable.create('page',{tag:'div',only:'section',handle:'handle',onChange:function(){pushinfo()}});
	}

	function getGroupOrder() {
		var sections = document.getElementsByClassName('section');
		var alerttext = '';
		sections.each(function(section) {
			var sectionID = section.id;
			var order = Sortable.serialize(sectionID);
			alerttext += sectionID + ': ' + Sortable.sequence(section) + '\n';
		});
		alert(alerttext);
		return false;
	}

function pushinfo() {
	textinfo = document.getElementById('dropdown_query');
	var sectarray = GroupsArray();
	textinfo.value = '';
	for (var c = 0; c < sectarray.length; c++) {
		listitemparent = document.getElementById(sectarray[c]);

		if (listitemparent != null) {
			var items = listitemparent.getElementsByTagName("div");

			if (c == 0) {
				textinfo.value = textinfo.value;
			} else {
				textinfo.value = textinfo.value + ","; //separates the items
			}

			var array = new Array()

			for (var i = 0, n = items.length; i < n; i++) {
				var item = items[i]
				if (i == 0) {
					textinfo.value = textinfo.value + item.id;
				} else {
					textinfo.value = textinfo.value + "|" + item.id;
				}
			}
		}
	}
	UpdatePreview()
}

function GroupsArray() {
	var sections = document.getElementsByClassName('section');
	var alerttext = '';
	sections.each(function(section) {
		var sectionID = section.id;
		var order = Sortable.serialize(sectionID);
		alerttext += sectionID + ':';
	});
	return alerttext.split(':');
}

function ShowGroupsArray() {
	var sections = document.getElementsByClassName('section');
	var alerttext = '';
	sections.each(function(section) {
		var sectionID = section.id;
		var order = Sortable.serialize(sectionID);
		alerttext += sectionID + '|';
	});
	alert(alerttext);
}

function UpdatePreview() {
	textinfo = document.getElementById('dropdown_query');
	CallAJAX(textinfo.value, '<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>');
}
</script>


<div class="configwidget">
	<div id="createNew">
		<h3>Information</h3>
		<p>Drag and drop the social bookmarks into the grey boxes for them to be included. Drag bookmarks into the green box (Unused Social Bookmarks) for them to be not included.</p>
		<p>You can organise bookmarks into rows by dragging them into the separate grey boxes. You can add new rows by clicking on the '<strong>Add New Row</strong>' button. Rows can be rearranged by simply dragging the top handle of the grey box. Empty rows will be ignored when generating the bookmarks.</p>
		<p style="margin: 15px 5px 5px 5px;">Once done customizing your bookmarks, click on the '<strong>Update Options &raquo;</strong>' button to save your changes.</p>
		<p><input type="hidden" id="sectionName" size="25"><input type="button" onClick="createNewSection();" value="Add New Row"><input type="hidden" id="dropdown_query" name="dropdown_query" value="<?php echo get_option('dropdown_allowlinkback'); ?>" /></p>
	</div>
<hr />
<div name="preview" id="preview" class="previewcontainer">
Preview<br />
<div class="displaypreview" id="dispprev"><img src="<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/icons/loading.png" /> Preview coming up...</div>
<hr />
</div>
<?php CreateConfigBookmarks(); ?>

</div>
</div>

<script type="text/javascript">
var configmode = document.getElementById('dropdown_configmode');
var buttonmode = document.getElementById('configchange');
var configmessage = document.getElementById('configmessage');
var confprev = '';
function ChangeMode() {
	var itemmode1 = document.getElementById('dropconfigbasic');
	var itemmode2 = document.getElementById('dropconfigadvanced');
	if (configmode.value == 'basic') {
		itemmode2.setAttribute("class", ""); 
		itemmode2.setAttribute("className", ""); 
		itemmode2.style.visibility="visible";
		itemmode1.style.visibility="hidden";
		itemmode1.setAttribute("class", "zerosize"); 
		itemmode1.setAttribute("className", "zerosize"); 
		configmode.value = 'advanced';
		buttonmode.value = 'Switch To Basic';
	} else {
		itemmode2.setAttribute("class", "zerosize"); 
		itemmode2.setAttribute("className", "zerosize"); 
		itemmode2.style.visibility="hidden";
		itemmode1.style.visibility="visible";
		itemmode1.setAttribute("class", ""); 
		itemmode1.setAttribute("className", ""); 
		configmode.value = 'basic';
		buttonmode.value = 'Switch To Advanced';
	}
	if (confprev != '') {
		configmessage.innerHTML = 'Any changes made to the previous mode will be lost if you click &quot;Update Options&quot;. You can revert to the previous mode if you want to preserve your changes.';
	}
}
buttonmode.setAttribute("class", ""); 
buttonmode.setAttribute("className", ""); 
configmessage.innerHTML = '';
<?php if (get_option('dropdown_configmode') == 'advanced') { ?>
ChangeMode();
<?php } ?>
confprev = true;
</script>
<?php } else { ?>
<div class="configwidget">
	<div id="createNew">
		<h3>Information</h3>
		<p>$overrideoptions (in <code>socialdropdown.php</code>) is set to <code>'true'</code>. Please set it to <code>'false'</code> in order to use the options panel to customize the bookmarks.</p>
	</div>
</div>
<?php } ?>