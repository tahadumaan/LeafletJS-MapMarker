<?php 
  //print_r($_POST);

  //LOKASYON BİLGİLERİNİ JSON DOSYASINA EKLE
  if(file_exists('data.json')){
    $current_data = file_get_contents('data.json');
    $array_data = json_decode($current_data,true);

    $extra = array(
      'lat'       =>  $_POST['lat'],
      'lng'       =>  $_POST['lng'],
      'datetime'  =>  $_POST['datetime']
    );

    $array_data[] = $extra;
    $final_data = json_encode($array_data);

    if(file_put_contents('data.json',$final_data)){
      $message = "<p>SUCCESS</p>";
    }
  }
?>