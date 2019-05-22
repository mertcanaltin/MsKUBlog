<?php
include("bootstrap/css.php");
include("bootstrap/js.php");
$page = <<< EOPAGE
<!doctype html>
<html>
<head>
<meta charset="utf-8">
$css
<title>Yeni Sayfa Ekle</title>
</head>

<body>
 <script src="../js/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({fullPanel : true,iconsPath : '../images/nicEditorIcons.gif', maxHeight : 100}).panelInstance('sayfaicerik');
});
</script>

<div class="container-fluid">
<div class="col-lg-6">
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-6">Yeni Sayfa Ekle</h1>
    <p class="lead">Bu form ile web sitenize yeni bir sayfa içeriği ekleyebilirsiniz.</p>
  </div>
</div>
EOPAGE;
if(!isset($_POST["kaydet"])){
$page .= <<< EOPAGEA
  <form name="form1" method="post" action="sayfaekle.php">
    <div class="form-group">
		<label for="sayfabaslik">Sayfa Başlık</label>
    	<input type="text" name="sayfabaslik" id="sayfabaslik" class="form-control">
    </div>
	    <div class="form-group">
		<label for="sayfalink">Sayfa Linki</label>
    	<input type="text" name="sayfalink" id="sayfalink" class="form-control">
    </div>
	    <div class="form-group">
		<label for="sayfaicerik">Sayfa İçeriği</label>
    	<textarea name="sayfaicerik" id="sayfaicerik" class="form-control" rows="8"
		placeholder="Sayfa içeriğini giriniz..."></textarea>
    </div>
	    <div class="form-group">
		<label for="anahtarkelimeler">Anahtar Kelimeler</label>
    	<input type="text" name="anahtarkelimeler" id="anahtarkelimeler" class="form-control">
    </div>
	    <div class="form-group">
		<label for="dil">Sayfa Dili</label>
    	<select name="dil" id="dil" class="form-control">
			<option value="TR" selected>Türkçe</option>
			<option value="EN">İngilizce</option>
		</select>
    </div>
	    <div class="form-group">
		<label for="olusturmatarihi">Sayfa Oluşturma Tarihi</label>
    	<input type="text" name="olusturmatarihi" id="olusturmatarihi" class="form-control" placeholder="2018" readonly>
    </div>
	    <div class="form-group">
		<label for="guncellemetarihi">Sayfa Güncelleme Tarih</label>
    	<input type="text" name="guncellemetarihi" id="guncellemetarihi" class="form-control" placeholder="2018" readonly>
    </div>
    <button type="submit" class="btn btn-success btn-lg btn-block" name="kaydet" id="kaydet">Kaydet</button>
    <button type="reset" class="btn btn-danger btn-lg btn-block" name="temizle" id="temizle">Temizle</button>
  </form>
EOPAGEA;
}#if(!isset($_POST["kaydet"])) iafadesinin bitti yer şimdi kullanıcı kaydet butonuna bastıysa else kısmı çalışacak.
else{
$mesaj="";
$stil="";
try{
$sayfabaslik=$_POST["sayfabaslik"];#form elemanlarının adı ile aynı olmalı
$sayfalink=$_POST["sayfalink"];
$sayfaicerik=$_POST["sayfaicerik"];
$anahtarkelimeler=$_POST["anahtarkelimeler"];
$dil=$_POST["dil"];
$olusturmatarihi=$_POST["olusturmatarihi"];
$guncellemetarihi=$_POST["guncellemetarihi"];
include("../mysqlconnect.php");
$sorgu=$db->prepare("INSERT INTO sayfa_tablosu (sayfa_baslik,link_baslik,sayfa_icerik,anahtar_kelimeler,dil) VALUES (:sayfa_baslik,:link_baslik,:sayfa_icerik,:anahtar_kelimeler,:dil)");
$sorgu->bindParam(":sayfa_baslik",$sayfabaslik,PDO::PARAM_STR);
$sorgu->bindParam(":link_baslik",$sayfalink,PDO::PARAM_STR);
$sorgu->bindParam(":sayfa_icerik",$sayfaicerik,PDO::PARAM_STR);
$sorgu->bindParam(":anahtar_kelimeler",$anahtarkelimeler,PDO::PARAM_STR);
$sorgu->bindParam(":dil",$dil,PDO::PARAM_STR);


$sonuc=$sorgu->execute();

if($sonuc){
$mesaj="Kaydetme İşlemi Başarı İle Gerçekleşti.";
$stil="alert-success";
}else{
$mesaj="Kaydetme İşleminde Hata İle Karşılaşıldı.";
$stil="alert-danger";
}

}catch(PDOException $ex){
$mesaj="Kaydetme İşleminde Hata:$ex";
$stil="alert-danger";
}
$page .= <<< EOPAGEB
<div class="alert $stil">$mesaj 5 saniye içerisinde Sayfa Yönetimi sayfasına yönlendirileceksiniz.</div>
EOPAGEB;
header("refresh:5;url=sayfayonetim.php");
}#İf ifadesinin else sinin bittiği yer.
$page .= <<< EOPAGEC
  </div>
</div>
$js
</body>
</html>
EOPAGEC;

echo($page);

?>