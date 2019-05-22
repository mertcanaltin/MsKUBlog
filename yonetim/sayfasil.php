<?php
include("bootstrap/css.php");
include("bootstrap/js.php");
$page = <<< EOPAGE
<!doctype html>
<html>
<head>
<meta charset="utf-8">
$css
<title>Sayfa Silme İşlemi</title>
</head>

<body>
<div class="container-fluid">
<div class="col-lg-6">
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-6">Sayfa Silme</h1>
    <p class="lead">Sayfa Silme İşlemi İçin Kullanılan Sayfadasınız.</p>
  </div>
</div>
EOPAGE;
try{
	if(isset($_POST["sayfa_no"])){
		$sno=$_POST["sayfa_no"];
		include("../mysqlconnect.php");
		$sorgu="DELETE FROM sayfa_tablosu WHERE sayfa_no=:sayfa_no";
		$tablo=$db->prepare($sorgu);
		$tablo->bindParam(":sayfa_no",$sno,PDO::PARAM_INT);
		if($tablo->execute()){
			$page.="<div class=\"alert alert-success\">Silme işlemi başarı ile gerçekleşti 5 saniye içerisinde Sayfa Yönetimi sayfasına yönlendirileceksiniz.</div>";
			header("refresh:5;url=sayfayonetim.php");
		}
		else{
			$page.="<div class=\"alert alert-danger\">Silme işleminde hata 5 saniye içerisinde Sayfa Yönetimi sayfasına yönlendirileceksiniz.</div>";
			header("refresh:5;url=sayfayonetim.php");
		}
		
	}else{
		$page.="<div class=\"alert alert-danger\">Silme yapılacak sayfaya ulaşılamadı 5 saniye içerisinde Sayfa Yönetimi sayfasına yönlendirileceksiniz.</div>";
		header("refresh:5;url=sayfayonetim.php");
	}
	
}catch(PDOException $ex){
	$page.="<div class=\"alert alert-danger\">Silme işleminde hata 5 saniye içerisinde Sayfa Yönetimi sayfasına yönlendirileceksiniz.</div>";
	header("refresh:5;url=sayfayonetim.php");
}
$page .= <<< EOPAGEA
</div>
</div>
$js
</body>
</html>
EOPAGEA;
echo $page;
?>