
<?php 
$sayfa_baslik="";
$sayfa_icerik="";
$anahtar_kelimeler="";
$olusturma_tarihi=0;
$guncelleme_tarihi=0;
$ot="";
$gt="";
try{
	#QueryString (adres satırı) değişkeni varmı ve integer mı kontrol et
	if(!empty($_GET["sno"]) && is_numeric($_GET["sno"])){
		$sno=$_GET["sno"];
		include("mysqlconnect.php");
		$sayfa=$db->prepare("SELECT * FROM sayfa_tablosu WHERE sayfa_no=:sayfa_no");
		#Yukarıdaki SQL cümlesinde :sayfa_no bir parametredir ve sorgu çalıştırmadan önce tanımlanmalıdır.
		$sayfa->bindParam(":sayfa_no",$sno,PDO::PARAM_INT);
		$sayfa->execute();
		foreach($sayfa as $satir){
			$sayfa_baslik=$satir["sayfa_baslik"];
			$sayfa_icerik=$satir["sayfa_icerik"];
			$anahtar_kelimeler=$satir["anahtar_kelimeler"];
			$olusturma_tarihi=settype($satir["olusturma_tarihi"],"integer");
			$guncelleme_tarihi=settype($satir["guncelleme_tarihi"],"integer");
			$ot=strftime("Oluşturma tarihi:%d %B %Y %A",$olusturma_tarihi);
			$gt=strftime("Son Güncelleme tarihi:%d %B %Y %A",$guncelleme_tarihi);
		}
	}
}catch(PDOException $ex){
	$sayfa_baslik="Hata";
}
include("menu.php");
$page=<<< EOPAGE
<!doctype html>
<html>
<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="keywords" content="{$anahtar_kelimeler}">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<title>{$sayfa_baslik}</title>
</head>

<body>
<div class="container-fluid">
<div class="row">
<div class="col-sm-5">Logo</div>
<div class="col-sm-7">{$htmlmenu}</div>
</div>
<div class="row">
<div class="col-sm-12">
<div class="page-header"><h3>{$sayfa_baslik}</h3></div>
</div>
</div>
<div class="row">
<div class="col-sm-12">{$sayfa_icerik}</div>
</div>
<div class="row">
<div class="col-sm-12">{$ot},{$gt}</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
EOPAGE;
echo $page;
?>