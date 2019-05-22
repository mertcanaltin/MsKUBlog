<?php
include("bootstrap/css.php");
include("bootstrap/js.php");
$page=<<< EOPAGE
<!doctype html>
<html>
<head>
<meta charset="utf-8">
$css
<title>Sayfa Yönetimi</title>
</head>
<body>
<div class="container-fluid">
<a href="sayfaekle.php" target="_self" class="btn btn-success">+ Yeni Sayfa Ekle</a>
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th>Sayfa No</th><th>Sayfa Başlık</th><th>Link Başlık</th><th>Sayfa İçeriği</th>
<th>Anahtar Kelimeler</th><th>Dil</th><th>Oluşturma Tarihi</th><th>Güncelleme Tarihi</th><th colspan="2">İşlem</th>
</tr>
</thead>
<tbody>
EOPAGE;
try{
	include("../mysqlconnect.php");
	$sayfalar=$db->prepare("SELECT * FROM sayfa_tablosu");
	$sayfalar->execute();
	foreach($sayfalar as $satir){
		$page.="<tr><td>{$satir['sayfa_no']}</td>";
		$page.="<td>{$satir['sayfa_baslik']}</td>";
		$page.="<td>{$satir['link_baslik']}</td>";
		$icerik=strip_tags($satir['sayfa_icerik']);
		if(strlen($icerik)>150)
		$icerik=substr($icerik,0,strpos($icerik," ",150))."...";
		
		$page.="<td>{$icerik}</td>";
		$page.="<td>{$satir['anahtar_kelimeler']}</td>";
		$page.="<td>{$satir['dil']}</td>";
		$page.="<td>{$satir['olusturma_tarihi']}</td>";
		$page.="<td>{$satir['guncelleme_tarihi']}</td>";
		$sno=$satir['sayfa_no'];
		$page.="<td>
				<a href=\"sayfaguncelle.php?sno=$sno\" target=\"_self\" class=\"btn btn-info\">
				Düzenle
				</a>
				</td>";
		$page.="<td>
				<a href=\"\" data-toggle=\"modal\" data-target=\"#silme_uyarisi$sno\" class=\"btn btn-danger\">
				Sil
				</a>
				</td></tr>";
		$page .= <<< EOPAGEA
	<!-- Silme Uyarısı vermek için bootstrap ekliyoruz -->
    <div id="silme_uyarisi$sno" class="modal fade" role="dialog"> 
    <div class="modal-dialog">
    <div class="modal-content">
    	<div class="modal-header">
        <h4 class="modal-title">Silme Uyarısı</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body"><b>{$satir["sayfa_baslik"]}</b> başlıklı sayfayı silmek istediğinize emin misiniz?</div>
        <div class="modal-footer">
        <form action="sayfasil.php" method="post">
        <input type="hidden" name="sayfa_no" id="sayfa_no" value="{$satir['sayfa_no']}">
        <button type="submit" class="btn btn-danger" id="delete" name="delete">Sayfayı Sil</button>
        <button type="button" class="btn btn-info" id="cancel" name="cancel" data-dismiss="modal">Vazgeç</button>
        </form>
        </div>
    </div>
    </div>
    </div>
    <!-- -->
EOPAGEA;
	}
}catch(PDOException $ex){
}
$page .= <<< EOPAGEB
</tbody>

</table>
</div>
</div>
$js
</body>
</html>
EOPAGEB;
echo($page);
?>