/*
Original source: http://www.dynamicdrive.com/

Modified for Social DropDown plug-in

Menu only hides if user clicks outside of area

Version: 1.3
*/
		

var menuwidth='300px' //default menu width
var hidemenu_onclick="yes" //hide menu when user clicks within menu

var ie4=document.all
var ns6=document.getElementById&&!document.all

if (ie4||ns6)
document.write('<div class="dropmenudiv" id="dropmenudiv" style="visibility:hidden;width:'+menuwidth+'" onMouseover="clearhidemenu()" onMouseout="dynamichide(event)"></div>')

function getposOffset(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}

var isout = false;
var dropbutton;

function ShowCallOut(mode) {
if (iscallout == true) {
if (mode=='top') {
//dropbutton.style.background = 'red';
var id;
id = dropbutton.id;
id = id.replace('bookdropbutton', '');
var calloutobj1 = document.getElementById('dropcallouttop'+id);
var calloutobj2 = document.getElementById('dropcallout'+id);
/*
calloutobj2.setAttribute("class", "dropcallouthide"); 
calloutobj2.setAttribute("className", "dropcallouthide"); 
calloutobj1.setAttribute("class", "dropcallouttop"); 
calloutobj1.setAttribute("className", "dropcallouttop"); 
*/
calloutobj1.style.visibility = "visible";
calloutobj2.style.visibility = "hidden";


} else if (mode=='bottom') {
var id;
id = dropbutton.id;
id = id.replace('bookdropbutton', '');
var calloutobj1 = document.getElementById('dropcallouttop'+id);
var calloutobj2 = document.getElementById('dropcallout'+id);
/*
calloutobj1.style.display = 'none';
calloutobj2.style.display = 'none';
*/
calloutobj2.style.visibility = "visible";
calloutobj1.style.visibility = "hidden";


} else {
var id;
id = dropbutton.id;
id = id.replace('bookdropbutton', '');
var calloutobj1 = document.getElementById('dropcallouttop'+id);
var calloutobj2 = document.getElementById('dropcallout'+id);
calloutobj2.style.visibility = "hidden";
calloutobj1.style.visibility = "hidden";
}
}
}





function showhide(obj, e, visible, hidden, menuwidth){
if (ie4||ns6)
dropmenuobj.style.left=dropmenuobj.style.top="-500px"
if (menuwidth!=""){
dropmenuobj.widthobj=dropmenuobj.style
dropmenuobj.widthobj.width=menuwidth
}
if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover") {
obj.visibility=visible
dropbutton.setAttribute("class", "dropdownbuttonon"); 
dropbutton.setAttribute("className", "dropdownbuttonon"); 
isout = false;
}
else { if (e.type=="click") {
obj.visibility=hidden
dropbutton.setAttribute("class", "dropdownbutton"); 
dropbutton.setAttribute("className", "dropdownbutton"); 
ShowCallOut('none');
}
}
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=0
if (whichedge=="rightedge"){
var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth
}
else{
var topedge=ie4 && !window.opera? iecompattest().scrollTop : window.pageYOffset
var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
dropmenuobj.contentmeasure=dropmenuobj.offsetHeight

ShowCallOut('top')

if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure){ //move up?
edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight

ShowCallOut('bottom')
if ((dropmenuobj.y-topedge)<dropmenuobj.contentmeasure) { //up no good either?
edgeoffset=dropmenuobj.y+obj.offsetHeight-topedge

ShowCallOut('none')
}

}
}
return edgeoffset
}

function populatemenu(what){
if (ie4||ns6)
dropmenuobj.innerHTML=what.join("")
}


function dropdownmenu(obj, e, menucontents, menuwidth, dropbuttonobj){
if (window.event) event.cancelBubble=true
else if (e.stopPropagation) e.stopPropagation()
clearhidemenu()
dropmenuobj=document.getElementById? document.getElementById("dropmenudiv") : dropmenudiv
populatemenu(menucontents)

if (ie4||ns6){
dropbutton = dropbuttonobj

showhide(dropmenuobj.style, e, "visible", "hidden", menuwidth)
if (dropmenuobj.style.visibility == 'visible') {
dropmenuobj.x=getposOffset(obj, "left")
dropmenuobj.y=getposOffset(obj, "top")
dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px"
dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px"

}

}

return clickreturnvalue()
}

function clickreturnvalue(){
if (ie4||ns6) return false
else return true
}

function contains_ns6(a, b) {
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
}



function dynamichide(e){
if (ie4&&!dropmenuobj.contains(e.toElement))
delayhidemenu()
else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
delayhidemenu()
else
isout = false

}

function hidemenu(e){
if (isout==true) {

if (typeof dropmenuobj!="undefined"){
if (ie4||ns6) {
dropmenuobj.style.visibility="hidden"
dropbutton.setAttribute("class", "dropdownbutton"); 
dropbutton.setAttribute("className", "dropdownbutton"); 
ShowCallOut('none');


}
}

}
}

function delayhidemenu(){
// remove this if you want the menu to dissapear after a few seconds
/*
disappeardelay = 2;
if (ie4||ns6)
delayhide=setTimeout("hidemenu()",disappeardelay)
*/
isout = true
}

function clearhidemenu(){
if (typeof delayhide!="undefined")
clearTimeout(delayhide)
}

if (hidemenu_onclick=="yes")
document.onclick=hidemenu

function SwitchTab(mode) {
/*
id = dropbutton.id;
id = id.replace('bookdropbutton', '');
var tab1 = document.getElementById(mode+id);
var tab2 = document.getElementById(current+id);
*/
}

function ShowHideArea(obj,obj2) {
SetShow();
obj2.href = 'javascript:void(0);'; //spoof the URL

var item = document.getElementById(obj);
if (item.style.display == 'none') {
item.style.display = 'block';
obj2.innerHTML = '&laquo; Less';
obj2.title = 'Show less';

id = item.id;
id = id.replace('extrabookmark', '');
var evenmore = document.getElementById('evenmore'+id);
evenmore.style.display = 'inline';

} else if(item.style.display == 'block') {
item.style.display = 'none';
obj2.innerHTML = 'More &raquo;';
obj2.title = 'More bookmarks';

id = item.id;
id = id.replace('extrabookmark', '');
var evenmore = document.getElementById('evenmore'+id);
evenmore.style.display = 'none';

} else {
obj2.innerHTML = '&laquo; Less';
obj2.title = 'Show less';
item.style.display = 'block';

id = item.id;
id = id.replace('extrabookmark', '');
var evenmore = document.getElementById('evenmore'+id);
evenmore.style.display = 'inline';

}

}

function SetShow() {
isout = false;
}

function SetHide() {
isout = true;
}

function ShowDescription(obj,obj2name) {
if (obj.id != 'bookmark') {
var item = document.getElementById(obj2name);
item.innerHTML = obj.title;
}
}