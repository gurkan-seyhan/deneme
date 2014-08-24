<?php
//MYSQL BAĞLANTISI------------------------------------------------------------------------
require("my_database.php");
$baglan=mysql_connect($server,$username,$password) or die ("Mysql e baglanamadi");
mysql_select_db($database ,$baglan) or die ("veritabanina baglanamadi.");
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_turkish_ci'");
set_time_limit(0);
//----------------------------------------------------------------------------------------

//TARİH FONKSİYONU------------------------------------------------------------------------
$min_tarih_mysql = mysql_fetch_assoc(mysql_query("select distinct(gn),ay,yl,saat,dakika,saniye from ekips_knm where trh= (select min(trh) from ekips_knm)"));
$max_tarih_mysql = mysql_fetch_assoc(mysql_query("select distinct(gn),ay,yl,saat,dakika,saniye from ekips_knm where trh= (select max(trh) from ekips_knm)"));
$min_trh = $min_tarih_mysql["yl"]."-".$min_tarih_mysql["ay"]."-".$min_tarih_mysql["gn"];
$max_trh = $max_tarih_mysql["yl"]."".$max_tarih_mysql["ay"]."".$max_tarih_mysql["gn"];
$degisken = mktime(0,0,0,$min_tarih_mysql["ay"],$min_tarih_mysql["gn"],$min_tarih_mysql["yl"]);
$yl = (date('Y',$degisken));
$ay = (date('n',$degisken));
$gn = (date('j',$degisken));sssss
//-----------------------------------------------------------------------------------------

while(($yl."".$ay."".$gn <= $max_trh)){

 $ekip_knms = mysql_query("select DISTINCT(simserial) as simseri from ekips_knm where yl='".$yl."' and ay='".$ay."' and gn='".$gn."' ");
while($ekip_veriler = mysql_fetch_assoc($ekip_knms)){
    $ekip_sorgu = mysql_query("select * from ekips_knm where simserial='".$ekip_veriler['simseri']."' and yl='".$yl."' and ay='".$ay."' and gn='".$gn."' group by knm_lat,knm_lng");

   $tarih = $yl."-".$ay."-".$gn;
  if(file_exists("xml/".$tarih."/".$ekip_veriler['simseri'].".xml")){
      //XML'İ OKU LAN

      $eski_dom = new DOMDocument("1.0","UTF-8");
      $eski_dom->load("xml/".$tarih."/".$ekip_veriler['simseri'].".xml");
      $dom_cocuk_adet  = $eski_dom->getElementsByTagName("ekip_bilgi")->length;

      //ÜST TARAF YENİ EKLENDİ...
      $dok = new DOMDocument("1.0","UTF-8");//Döküman Karakter Seti Versiyonu Yazılıyor
      $dok->formatOutput = true;
      $dom_ana = $dok->appendChild($dok->createElement("ekips_knm"));//Ana Dom Elementi Belirleniyor
      while($ekip_knms_veriler = mysql_fetch_assoc($ekip_sorgu)){
          $dom_cocuk = $dom_ana->appendChild($dok->createElement("ekip_bilgi"));      //Çoçuk Dom Elementi Belirleniyor
          $ekip_tarih = $dok->createAttribute("ekip_tarih");                          //Çoçuk Dom Elementi İçin Özellik Belirleniyor
          $ekip_tarih->value = "".$ekip_knms_veriler["ekip_tarih"];              //Çoçuk Dom Elementinin Değeri Veriliyor
          $dom_cocuk->appendChild($ekip_tarih);
          $yls = $dok->createAttribute("yl");
          $yls->value = "".$ekip_knms_veriler["yl"];
          $dom_cocuk->appendChild($yls);
          $ays=$dok->createAttribute("ay");
          $ays->value = "".$ekip_knms_veriler["ay"];
          $dom_cocuk->appendChild($ays);
          $gns=$dok->createAttribute("gn");
          $gns->value = "".$ekip_knms_veriler["gn"];
          $dom_cocuk->appendChild($gns);
          $saat = $dok->createAttribute("saat");
          $saat->value = "".$ekip_knms_veriler["saat"];
          $dom_cocuk->appendChild($saat);
          $dakika = $dok->createAttribute("dakika");
          $dakika->value = "".$ekip_knms_veriler["dakika"];
          $dom_cocuk->appendChild($dakika);
          $adres = $dok->createAttribute("adres");
          $adres->value = "".$ekip_knms_veriler["adres"];
          $dom_cocuk->appendChild($adres);
          $drm = $dok->createAttribute("drm");
          $drm->value = "".$ekip_knms_veriler["drm"];
          $dom_cocuk->appendChild($drm);
          $cihaz_id = $dok->createAttribute("cihaz_id");
          $cihaz_id->value = "".$ekip_knms_veriler["cihaz_id"];
          $dom_cocuk->appendChild($cihaz_id);
          $knm_lat = $dok->createAttribute("knm_lat");
          $knm_lat->value = "".$ekip_knms_veriler["knm_lat"];
          $dom_cocuk->appendChild($knm_lat);
          $knm_lng = $dok->createAttribute("knm_lng");
          $knm_lng->value = "".$ekip_knms_veriler["knm_lng"];
          $dom_cocuk->appendChild($knm_lng);
          $simserial = $dok->createAttribute("simserial");
          $simserial->value = "".$ekip_knms_veriler["simserial"];
          $dom_cocuk->appendChild($simserial);
          $id = $dok->createAttribute("id");
          $id->value = "".$ekip_knms_veriler["id"];
          $dom_cocuk->appendChild($id);
          $sarj = $dok->createAttribute("sarj");
          $sarj->value = "".$ekip_knms_veriler["sarj"];
          $dom_cocuk->appendChild($sarj);
          $saniye = $dok->createAttribute("saniye");
          $saniye->value = "".$ekip_knms_veriler["saniye"];
          $dom_cocuk->appendChild($saniye);
          $work_id = $dok->createAttribute("work_id");
          $work_id->value = "".$ekip_knms_veriler["work_id"];
          $dom_cocuk->appendChild($work_id);
          $knms = $dok->createAttribute("knms");
          $knms->value = "".$ekip_knms_veriler["knms"];
          $dom_cocuk->appendChild($knms);
          $trh = $dok->createAttribute("trh");
          $trh->value = "".$ekip_knms_veriler["trh"];
          $dom_cocuk->appendChild($trh);
          $KOD = $dok->createAttribute("KOD");
          $KOD->value = "".$ekip_knms_veriler["KOD"];
          $dom_cocuk->appendChild($KOD);
          $net_status = $dok->createAttribute("net_status");
          $net_status->value = "".$ekip_knms_veriler["net_status"];
          $dom_cocuk->appendChild($net_status);
          $Act_Status = $dok->createAttribute("ActStatus");
          $Act_Status->value = "".$ekip_knms_veriler["ActStatus"];
          $dom_cocuk->appendChild($Act_Status);
          $acc = $dok->createAttribute("acc");
          $acc->value = "".$ekip_knms_veriler["acc"];
          $dom_cocuk->appendChild($acc);
          $vel = $dok->createAttribute("vel");
          $vel->value = "".$ekip_knms_veriler["vel"];
          $dom_cocuk->appendChild($vel);
      }
      //NODE ELEMANLARINI DONDUR AL
      for($i=0;$i<$dom_cocuk_adet;$i++){
          $dok->documentElement->appendChild($dok->importNode($eski_dom->getElementsByTagName("ekip_bilgi")->item($i)));
      }
      //DONDUR AL BITIS
      $tarih = $yl."-".$ay."-".$gn;
      if(file_exists('xml/'.$tarih)){
          $dok->save("xml/".$tarih."/".$ekip_veriler['simseri'].".xml");
      }
      else{
          $klasor = mkdir('xml/'.$tarih,0700);
          if($klasor){
              $dok->save("xml/".$tarih."/".$ekip_veriler['simseri'].".xml");
          }
      }
    }
    else{
    $dok = new DOMDocument("1.0","UTF-8");//Döküman Karakter Seti Versiyonu Yazılıyor
    $dom_ana = $dok->appendChild($dok->createElement("ekips_knm"));//Ana Dom Elementi Belirleniyor
    while($ekip_knms_veriler = mysql_fetch_assoc($ekip_sorgu)){
        $dom_cocuk = $dom_ana->appendChild($dok->createElement("ekip_bilgi"));      //Çoçuk Dom Elementi Belirleniyor
        $ekip_tarih = $dok->createAttribute("ekip_tarih");                          //Çoçuk Dom Elementi İçin Özellik Belirleniyor
        $ekip_tarih->value = "".$ekip_knms_veriler["ekip_tarih"];              //Çoçuk Dom Elementinin Değeri Veriliyor
        $dom_cocuk->appendChild($ekip_tarih);
        $yls = $dok->createAttribute("yl");
        $yls->value = "".$ekip_knms_veriler["yl"];
        $dom_cocuk->appendChild($yls);
        $ays=$dok->createAttribute("ay");
        $ays->value = "".$ekip_knms_veriler["ay"];
        $dom_cocuk->appendChild($ays);
        $gns=$dok->createAttribute("gn");
        $gns->value = "".$ekip_knms_veriler["gn"];
        $dom_cocuk->appendChild($gns);
        $saat = $dok->createAttribute("saat");
        $saat->value = "".$ekip_knms_veriler["saat"];
        $dom_cocuk->appendChild($saat);
        $dakika = $dok->createAttribute("dakika");
        $dakika->value = "".$ekip_knms_veriler["dakika"];
        $dom_cocuk->appendChild($dakika);
        $adres = $dok->createAttribute("adres");
        $adres->value = "".$ekip_knms_veriler["adres"];
        $dom_cocuk->appendChild($adres);
        $drm = $dok->createAttribute("drm");
        $drm->value = "".$ekip_knms_veriler["drm"];
        $dom_cocuk->appendChild($drm);
        $cihaz_id = $dok->createAttribute("cihaz_id");
        $cihaz_id->value = "".$ekip_knms_veriler["cihaz_id"];
        $dom_cocuk->appendChild($cihaz_id);
        $knm_lat = $dok->createAttribute("knm_lat");
        $knm_lat->value = "".$ekip_knms_veriler["knm_lat"];
        $dom_cocuk->appendChild($knm_lat);
        $knm_lng = $dok->createAttribute("knm_lng");
        $knm_lng->value = "".$ekip_knms_veriler["knm_lng"];
        $dom_cocuk->appendChild($knm_lng);
        $simserial = $dok->createAttribute("simserial");
        $simserial->value = "".$ekip_knms_veriler["simserial"];
        $dom_cocuk->appendChild($simserial);
        $id = $dok->createAttribute("id");
        $id->value = "".$ekip_knms_veriler["id"];
        $dom_cocuk->appendChild($id);
        $sarj = $dok->createAttribute("sarj");
        $sarj->value = "".$ekip_knms_veriler["sarj"];
        $dom_cocuk->appendChild($sarj);
        $saniye = $dok->createAttribute("saniye");
        $saniye->value = "".$ekip_knms_veriler["saniye"];
        $dom_cocuk->appendChild($saniye);
        $work_id = $dok->createAttribute("work_id");
        $work_id->value = "".$ekip_knms_veriler["work_id"];
        $dom_cocuk->appendChild($work_id);
        $knms = $dok->createAttribute("knms");
        $knms->value = "".$ekip_knms_veriler["knms"];
        $dom_cocuk->appendChild($knms);
        $trh = $dok->createAttribute("trh");
        $trh->value = "".$ekip_knms_veriler["trh"];
        $dom_cocuk->appendChild($trh);
        $KOD = $dok->createAttribute("KOD");
        $KOD->value = "".$ekip_knms_veriler["KOD"];
        $dom_cocuk->appendChild($KOD);
        $net_status = $dok->createAttribute("net_status");
        $net_status->value = "".$ekip_knms_veriler["net_status"];
        $dom_cocuk->appendChild($net_status);
        $Act_Status = $dok->createAttribute("ActStatus");
        $Act_Status->value = "".$ekip_knms_veriler["ActStatus"];
        $dom_cocuk->appendChild($Act_Status);
        $acc = $dok->createAttribute("acc");
        $acc->value = "".$ekip_knms_veriler["acc"];
        $dom_cocuk->appendChild($acc);
        $vel = $dok->createAttribute("vel");
        $vel->value = "".$ekip_knms_veriler["vel"];
        $dom_cocuk->appendChild($vel);
    }
    
    
    $tarih = $yl."-".$ay."-".$gn;
    if(file_exists('xml/'.$tarih)){
        $dok->save("xml/".$tarih."/".$ekip_veriler['simseri'].".xml");
    }
    else{
        $klasor = mkdir('xml/'.$tarih,0700);
        if($klasor){
            $dok->save("xml/".$tarih."/".$ekip_veriler['simseri'].".xml");
        }

    }
    }
    
  mysql_query("delete from ekips_knm where simserial='".$ekip_veriler['simseri']."' and yl='".$yl."' and ay='".$ay."' and gn='".$gn."'");

}



$degisken = mktime(0,0,0,$ay,$gn,$yl)+86400;
$yl = (date('Y',$degisken));
$ay = (date('n',$degisken));
$gn = (date('j',$degisken));

}

?>














