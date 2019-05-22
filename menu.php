<?php 
$htmlmenu="";
try{
	include("mysqlconnect.php");
	$menu=$db->query("SELECT * FROM menu_tablosu");
	$htmlmenu="\n<div class=\"btn-group btn-group-justified\">\n";
	foreach($menu as $satir){
		$htmlmenu.="<a href=\"{$satir['menu_link']}\" target=\"{$satir['menu_hedef']}\" class=\"btn btn-primary\">{$satir['menu_baslik']}</a>\n";
	}
	$htmlmenu.="</div>\n";
}catch(PDOException $ex){
	$htmlmenu="";
}
?>