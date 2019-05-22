<?php
include("bootstrap/css.php");
include("bootstrap/js.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<?php echo $css;?>
<title>Sayfa Bilgilerini Düzenle</title>
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
    <h1 class="display-6">Sayfa Bilgilerini Güncelle</h1>
    <p class="lead">Bu form ile web sitenizdeki sayfa içeriklerini güncelleyebilirsiniz.</p>
  </div>
</div>
<?php 
if(!isset($_POST["kaydet"])){
	$sayfa_no="";
	$sayfa_baslik="";
	$link_baslik="";
	$sayfa_icerik="";
	$anahtar_kelimeler="";
	$TR="";
	$EN="";
	$olusturma_tarihi="";
	$guncelleme_tarihi="";
	if(!empty($_GET["sno"])&&is_numeric($_GET["sno"])){
		$sno=$_GET["sno"];
		try{
		include("../mysqlconnect.php");
		$sorgu="SELECT * FROM sayfa_tablosu WHERE sayfa_no=:sayfa_no";
		$tablo=$db->prepare($sorgu);
		#$tablo->execute(array($sno));
		$tablo->bindParam(":sayfa_no",$sno,PDO::PARAM_INT);
		$tablo->execute();
		if($tablo){
			foreach($tablo as $satir){
				$sayfa_no=$satir["sayfa_no"];
				$sayfa_baslik=$satir["sayfa_baslik"];
				$link_baslik=$satir["link_baslik"];
				$sayfa_icerik=$satir["sayfa_icerik"];
				$anahtar_kelimeler=$satir["anahtar_kelimeler"];
				$dil=$satir["dil"];
				if($dil=="TR")
				$TR="selected";
				else
				$EN="selected";
				$olusturma_tarihi=$satir["olusturma_tarihi"];
				$guncelleme_tarihi=$satir["guncelleme_tarihi"];
			}
?>
  <form name="form1" method="post" action="sayfaguncelle.php">
  		<input name="sayfano" type="hidden" value="<?php echo $sayfa_no;?>">
    <div class="form-group">
		<label for="sayfabaslik">Sayfa Başlık</label>
    	<input type="text" name="sayfabaslik" id="sayfabaslik" value="<?php echo $sayfa_baslik;?>" class="form-control">
    </div>
	    <div class="form-group">
		<label for="sayfalink">Sayfa Linki</label>
    	<input type="text" name="sayfalink" id="sayfalink" 
        value="<?php echo $link_baslik;?>" class="form-control">
    </div>
	    <div class="form-group">
		<label for="sayfaicerik">Sayfa İçeriği</label>
    	<textarea name="sayfaicerik" id="sayfaicerik" class="form-control" rows="8"
		placeholder="Sayfa içeriğini giriniz..."><?php echo $sayfa_icerik;?></textarea>
    </div>
	    <div class="form-group">
		<label for="anahtarkelimeler">Anahtar Kelimeler</label>
    	<input type="text" name="anahtarkelimeler" id="anahtarkelimeler" value="<?php echo $anahtar_kelimeler; ?>" class="form-control">
    </div>
	    <div class="form-group">
		<label for="dil">Sayfa Dili</label>
    	<select name="dil" id="dil" class="form-control">
			<option value="TR" <?php echo $TR;?>>Türkçe</option>
			<option value="EN" <?php echo $EN;?>>İngilizce</option>
		</select>
    </div>
	    <div class="form-group">
		<label for="olusturmatarihi">Sayfa Oluşturma Tarihi</label>
    	<input type="text" name="olusturmatarihi" id="olusturmatarihi" value="<?php echo $olusturma_tarihi;?>" class="form-control" placeholder="2018" readonly>
    </div>
	    <div class="form-group">
		<label for="guncellemetarihi">Sayfa Güncelleme Tarih</label>
    	<input type="text" name="guncellemetarihi" id="guncellemetarihi"value="<?php echo $guncelleme_tarihi;?>" class="form-control" placeholder="2018" readonly>
    </div>
    <button type="submit" class="btn btn-success btn-lg btn-block" name="kaydet" id="kaydet">Kaydet</button>
    <button type="reset" class="btn btn-danger btn-lg btn-block" name="temizle" id="temizle">Temizle</button>
  </form>
<?php
		}#if($tablo) kapandığı yer
		else{
			echo("<div class=\"alert alert-danger\">Düzenleme yapılacak sayfa bulunamadı 5 saniye içerisinde Sayfa Yönetimi sayfasına yönlendirileceksiniz.</div>");
		header("refresh:5;url=sayfayonetim.php");

		}
		}catch(PDOException $ex){
			echo("<div class=\"alert alert-danger\">Düzenleme yapılacak sayfaya ulaşılamadı 5 saniye içerisinde Sayfa Yönetimi sayfasına yönlendirileceksiniz.</div>");
		header("refresh:5;url=sayfayonetim.php");

		}
	
		
	}
	else{
		echo("<div class=\"alert alert-danger\">Düzenleme yapılacak sayfa bulunamadı 5 saniye içerisinde Sayfa Yönetimi sayfasına yönlendirileceksiniz.</div>");
		header("refresh:5;url=sayfayonetim.php");

	}
}#if($_POST["kaydet"]) ifadesisin bittiği yer
else{
	try{
		$sayfa_no=$_POST["sayfano"];
		$sayfa_baslik=$_POST["sayfabaslik"];
		$link_baslik=$_POST["sayfalink"];
		$sayfa_icerik=$_POST["sayfaicerik"];
		$anahtar_kelimeler=$_POST["anahtarkelimeler"];
		$dil=$_POST["dil"];
		include("../mysqlconnect.php");
		$sorgu="UPDATE sayfa_tablosu SET sayfa_baslik=:sayfa_baslik, link_baslik=:link_baslik, sayfa_icerik=:sayfa_icerik, anahtar_kelimeler=:anahtar_kelimeler, dil=:dil WHERE sayfa_no=:sayfa_no";
		$tablo=$db->prepare($sorgu);
		$tablo->bindParam(":sayfa_baslik",$sayfa_baslik,PDO::PARAM_STR);
		$tablo->bindParam(":link_baslik",$link_baslik,PDO::PARAM_STR);
		$tablo->bindParam(":sayfa_icerik",$sayfa_icerik,PDO::PARAM_STR);
		$tablo->bindParam(":anahtar_kelimeler",$anahtar_kelimeler,PDO::PARAM_STR);
		$tablo->bindParam(":dil",$dil,PDO::PARAM_STR);
		$tablo->bindParam(":sayfa_no",$sayfa_no,PDO::PARAM_INT);
		if($tablo->execute()){
			echo("<div class=\"alert alert-success\">Düzenleme işlemi başarıyla gerçekleşti 5 saniye içerisinde Sayfa Yönetimi sayfasına yönlendirileceksiniz.</div>");
		header("refresh:5;url=sayfayonetim.php");
			}
			else{
				echo("<div class=\"alert alert-danger\">Düzenleminde hata 5 saniye içerisinde Sayfa Yönetimi sayfasına yönlendirileceksiniz.</div>");
		header("refresh:5;url=sayfayonetim.php");
			}
		
	}catch(PDOException $ex){
		echo("<div class=\"alert alert-danger\">Düzenleminde hata 5 saniye içerisinde Sayfa Yönetimi sayfasına yönlendirileceksiniz.</div>");
		header("refresh:5;url=sayfayonetim.php");
	}
}
?>
</div>
</div>
<?php echo $js;?>
</body>
</html>