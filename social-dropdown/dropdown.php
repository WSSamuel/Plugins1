<?php
/* Generates the dropdown design. */

$iscallout = false;

//The HTML version of the dropdown
//Set Dropdown_html(true) to separate both HTML and JavaScript elements so that you can position them best.
//Note: HTML version must come before Javascript to eliminate any Javascript related errors.
function Dropdown_html($htmlseparate = false) {
global $isfirst, $usedropdown, $usenonjavaset, $dropdown_width;
global $iscallout;
$dropdown_allowlinkback = get_option('dropdown_allowlinkback');
?>
<div id="dropdown<?php the_ID(); ?>" class="dropcontainer">
<?php if ($iscallout) { ?>
<div class="dropcallouttop" onmouseout="SetHide()" onmouseenter="SetShow()" id="dropcallouttop<?php the_ID(); ?>">A</div>
<?php } ?>
<div class="drop" onmouseout="javascript:ShowDescription(this,'dropinfo<?php the_ID(); ?>')">
<div class="dropminioptions">
<?php if ($dropdown_allowlinkback == 'true') { ?>
<a href="http://www.tevine.com/projects/socialdropdown/" onmouseover="javascript:ShowDescription(this,'dropinfo<?php the_ID(); ?>')" title="About Social Dropdown">?</a>
<?php } ?>
<a href="javascript:void();" onmouseover="javascript:ShowDescription(this,'dropinfo<?php the_ID(); ?>')" onclick="return dropdownmenu(document.getElementById('bookbutton<?php the_ID(); ?>'), event, menu<?php the_ID(); ?>, '<?php echo $dropdown_width; ?>', document.getElementById('bookdropbutton<?php the_ID(); ?>'))" style="display: none;" id="closelink<?php the_ID(); ?>" title="Close">X</a></div>
<ul class="nav">
<li class="selected"><a onmouseover="javascript:ShowDescription(this,'dropinfo<?php the_ID(); ?>')" href="javascript:void(0)" title="Bookmark this post">Bookmarks</a></li>
<?php /* ?><li><a href="" onmouseover="javascript:ShowDescription(this,'dropinfo<?php the_ID(); ?>')" title="Email this post">Email</a></li>
<?php */ ?>
</ul>
<div class="content">
<div class="bookmarks" id="bookmark<?php the_ID(); ?>">
<p><?php Dropdown_GenerateAll(); ?></p>
</div>
<div class="extrabookmarks" id="extrabookmark<?php the_ID(); ?>">
</div>
<div class="options">
<div class="info" id="dropinfo<?php the_ID(); ?>"></div>
<div class="more"><span class="evenmore" id="evenmore<?php the_id(); ?>"></span><a href="http://www.tevine.com/social/<?php if (!is_single()) { echo '?url='; echo str_replace("http://","",get_permalink()); } ?>" onclick="return ShowHideArea('extrabookmark<?php the_ID(); ?>', this);" onmouseover="javascript:ShowDescription(this,'dropinfo<?php the_ID(); ?>')" title="More bookmarks">More &raquo;</a></div>
</div>
</div></div>
<?php if ($iscallout) { ?>
<div class="dropcallout" id="dropcallout<?php the_ID(); ?>">A</div>
<?php } ?>
</div>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
//To prevent what Google says is hidden content
extrabookmarks = document.getElementById('extrabookmark<?php the_ID(); ?>');
extrabookmarks.innerHTML = "<p><?php Dropdown_GenerateAll_Inverse(true); ?></p>";

evenmore = document.getElementById('evenmore<?php the_ID(); ?>');
evenmore.innerHTML = "<a onmouseover=\"javascript:ShowDescription(this,\'dropinfo<?php the_ID(); ?>\')\" href=\"http://www.tevine.com/social/<?php if (!is_single()) { echo '?url='; echo str_replace("http://","",get_permalink()); } ?>\" title=\"Even More Bookmarks\">Even More</a> | ";
//--><!]]>
</script>
<?php

if (!$htmlseparate) {
if ($usedropdown == 'true') {
Dropdown_javascript();
}
}

}

function Dropdown_GenerateAll() {
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
				Dropdown_GenerateLink($cells[$count]);
			}
		}
	}
}
}

//Opposite of Generate all in that the items are unused
function Dropdown_GenerateAll_Inverse($sanitize = false) {
$insideline = explode("|", str_replace(",","|",get_option('dropdown_query')));
$all = explode("|", 'blinkbits|blinklist|bloglines|blogmarks|buddymarks|bumpzee|citeulike|comments|delicious|digg|diigo|facebook|fark|faves|feedmelinks|furl|google|gravee|hugg|jeqq|live|linkagogo|magnolia|misterwong|netvouz|newsvine|onlywire|propeller|rawsugar|reddit|rojo|simpy|slashdot|sphinn|spurl|squidoo|stumbleupon|tailrank|taggly|tagtooga|technorati|yahoo');
for ($i = 0; $i < count($insideline); $i++) {
if (array_search($insideline[$i],$all) != '') {
unset($all[array_search($insideline[$i],$all)]);
}

}


$bookline = implode("|",array_values($all));

$rows = explode(",", $bookline);
for ( $counter = 0; $counter <= count($rows); $counter += 1) {
	if ($rows[$counter] != '') {
if ($counter != 0) {
GenerateLink('separator');
}
		$cells = explode("|", $rows[$counter]);
		for ( $count = 0; $count <= count($cells); $count += 1) {
			if ($cells[$count] != '') {
				Dropdown_GenerateLink($cells[$count], $sanitize);
			}
		}
	}
}
}

function Dropdown_GenerateLink($type, $sanitize = false) {

if (!$sanitize) {
if ($type != 'separator') {
?>
<a class="link" onmouseover="javascript:ShowDescription(this,'dropinfo<?php the_ID(); ?>')" rel="nofollow" title="<?php GenerateName($type); ?>" href="<?php GenerateURL($type) ?>"><img alt="<?php GenerateName($type); ?>" src="<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/icons/<?php echo $type; ?>.png" /></a>
<?php
} else {
echo "</p><p>";
}
} else {
//Sometimes, Javascript makes things harder than it should be
if ($type != 'separator') {
?><a class=\"link\" onmouseover=\"javascript:ShowDescription(this,\'dropinfo<?php the_ID(); ?>\')\" rel=\"nofollow\" title=\"<?php GenerateName($type); ?>\" href=\"<?php GenerateURL($type) ?>\"><img alt=\"<?php GenerateName($type); ?>\" src=\"<?php echo get_settings('siteurl'); ?>/<?php echo str_replace("\\","/", GetDropPluginPath()); ?>/icons/<?php echo $type; ?>.png\" /></a><?php
} else {
echo "</p><p>";
}
}

}

//The dropdown will be converted to an actual dropdown by JavaScript
function Dropdown_javascript() {
global $isfirst, $usedropdown, $usenonjavaset, $dropdown_width;
global $iscallout;
?>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
<?php if ($iscallout) { ?>
var iscallout = true;
<?php } else { ?>
var iscallout = false;
<?php } ?>

closelinkobj = document.getElementById('closelink<?php the_ID(); ?>');
closelinkobj.style.display = 'inline';

var itemid = 'dropdown<?php the_ID(); ?>';
itemobj = document.getElementById(itemid);

var menu<?php the_ID(); ?> = new Array();
menu<?php the_ID(); ?>[0] = itemobj.innerHTML;

itemobj.innerHTML = ''; //clear off to avoid other errors

var droptext = "<p class=\"taskbuttoncontainer\"><span class=\"booktaskbutton\"><a class=\"bookbutton\" id=\"bookbutton<?php the_ID(); ?>\" href=\"javascript:void(0);\" onclick=\"return dropdownmenu(document.getElementById('bookbutton<?php the_ID(); ?>'), event, menu<?php the_ID(); ?>, '<?php echo $dropdown_width; ?>', document.getElementById('bookdropbutton<?php the_ID(); ?>'))\" onmouseout=\"\" title=\"Bookmarking options\">Bookmark This</a><a class=\"dropdownbutton\" id=\"bookdropbutton<?php the_ID(); ?>\" href=\"javascript:void(0);\" onclick=\"return dropdownmenu(document.getElementById('bookbutton<?php the_ID(); ?>'), event, menu<?php the_ID(); ?>, '<?php echo $dropdown_width; ?>', document.getElementById('bookdropbutton<?php the_ID(); ?>'))\" onmouseout=\"\" title=\"Bookmarking options\">&nbsp;</a></span> </p>";
document.write(droptext);
//--><!]]>
</script>
<?php
}
?>