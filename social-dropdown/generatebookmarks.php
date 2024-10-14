<?php

if(!function_exists('bloginfo')) {
include('../../../wp-blog-header.php');
}
//This file is used to generate bookmarks for preview and handles the drag and drop features. It will output customized bookmarks.

function GenerateIMG($type) {
?>
<img alt="<?php GenerateName($type); ?>" src="<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/icons/<?php echo $type; ?>.png" />
<?php
}

//A handy function for generating bookmarks for config
function CreateConfigBookmarks() {
$bookline = get_option('dropdown_query');
$all = explode("|",'blinkbits|blinklist|bloglines|blogmarks|buddymarks|bumpzee|citeulike|comments|delicious|digg|diigo|facebook|fark|faves|feedmelinks|furl|google|gravee|hugg|jeqq|live|linkagogo|magnolia|misterwong|netvouz|newsvine|onlywire|propeller|rawsugar|reddit|rojo|simpy|slashdot|sphinn|spurl|squidoo|stumbleupon|tailrank|taggly|tagtooga|technorati|yahoo');
echo '<div id="page">';
//Generates the rows
$used = array();
$rows = explode(",", $bookline);
for ( $counter = 0; $counter <= count($rows); $counter += 1) {
	if ($rows[$counter] != '') {
		echo "<div id=\"group".$counter."\" class=\"section\">\r\n<h3 class=\"handle\"> </h3>\r\n";
		$cells = explode("|", $rows[$counter]);
		for ( $count = 0; $count <= count($cells); $count += 1) {
			if ($cells[$count] != '') {
				echo "<div id=\"$cells[$count]\" class=\"lineitem\"><p>";
				GenerateIMG($cells[$count]);
				GenerateName($cells[$count]);
				echo "</p></div>\r\n";
				$used[count($used)] = $cells[$count];
			}
		}
		echo "</div>\r\n";
	}
}
echo '</div>';
echo "<hr />\r\n";

//Generates the unused bookmarks
echo "<div id=\"grouptool\" class=\"toolsection\"><h3 class=\"handle\">Unused Social Bookmarks</h3>\r\n";
for ( $count = 0; $count <= count($all); $count += 1) {
if (!in_array($all[$count], $used)) {
if ($all[$count] != '') {
echo "<div id=\"".$all[$count]."\" class=\"lineitem\">";
GenerateIMG($all[$count]);
GenerateName($all[$count]);
echo "</p></div>\r\n";
}
}
}
echo "</div>\r\n";

//Generate the JavaScript
?><script type="text/javascript">
	// <![CDATA[
<?php
$therows = GetBookmarkRows();
for ( $counter = 0; $counter <= count($therows); $counter += 1) {
if ($therows[$counter] != '') {
echo "Sortable.create('".$therows[$counter]."',{tag:'div',dropOnEmpty: true, overlap: 'horizontal',constraint:false, containment: sections,only:'lineitem',onChange:function(){pushinfo()}});\r\n";
}
}


?>

	Sortable.create('grouptool',{tag:'div',dropOnEmpty: true, overlap: 'horizontal',constraint:false, containment: sections, only:'lineitem',onChange:function(){pushinfo()}});

	Sortable.create('page',{tag:'div',only:'section',handle:'handle',onChange:function(){pushinfo()}});

pushinfo(); //Shows a preview
	// ]]>
 </script>
<?php
}

function GetBookmarkRows() {
//$bookline = 'blinkbits|blinklist|bloglines|blogmarks|buddymarks|citeulike|comments|delicious|digg|diigo,fark|feedmelinks|furl|google|linkagogo|magnolia|netvouz|newsvine|propeller|rawsugar,reddit|rojo|simpy|sphinn|spurl|squidoo|stumbleupon|tailrank|technorati|yahoo';
$bookline = get_option('dropdown_query');
//The text generates 3 rows, and includes 10 bookmarks on each
//Generates the array
$rowt = array();
$rows = explode(",", $bookline);
for ( $counter = 0; $counter <= count($rows); $counter += 1) {
	if ($rows[$counter] != '') {
		$rowt[count($rowt)] = "group".$counter;
	}
}
return $rowt;
}

function GetBookmarkSections() {
echo "'".implode("','",GetBookmarkRows())."','grouptool'";
}

function DisplayBookmarks() {
//This function replaces the generateall function. If you want to use the original function please set $overrideoption to true
$bookline = get_option('dropdown_query');

$rows = explode(",", $bookline);
for ( $counter = 0; $counter <= count($rows); $counter += 1) {
	if ($rows[$counter] != '') {
if ($counter != 0) {
GenerateLink('separator');
}
		$cells = explode("|", $rows[$counter]);
		for ( $count = 0; $count <= count($cells); $count += 1) {
			if ($cells[$count] != '') {
				GenerateLink($cells[$count]);
			}
		}
	}
}
}


if ($_POST['mode'] == '') {
$state = $_GET['mode'];
} else {
$state = $_POST['mode'];
}
if ($_POST['q'] == '') {
$entry = $_GET['q'];
} else {
$entry = $_POST['q'];
}
switch ($state) {
case 'preview':
$rows = explode(",", $entry);
for ( $counter = 0; $counter <= count($rows); $counter += 1) {
	if ($rows[$counter] != '') {
		echo "<p>";
		$cells = explode("|", $rows[$counter]);
		for ( $count = 0; $count <= count($cells); $count += 1) {
			if ($cells[$count] != '') {
				if ($count != '0') {
				echo "".GenerateIMG($cells[$count]);
				}else {
				echo GenerateIMG($cells[$count]);
				}
			}
		}
		echo "</p>";
	}
}

break;
}


?>