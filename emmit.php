<?php

require __DIR__ . '/vendor/autoload.php';

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;


if(!isset($_GET['vehicleID'])) {
    return false;
}

$myFile = "tracking.json";
$arr_data = array(); // boş bir array oluşturuyoruz.

try
{
    //Get ile gelmesi umulan verileri diziye atıyoruz.
    $formdata = [
        'vehicleID'=> (int) $_GET['vehicleID'],
        'date' => date("Y-m-d H:i:s"),
        'latitude'=> (double) $_GET['latitude'],
        'longitude'=> (double) $_GET['longitude']
    ];

    //json dosyamızı okuyoruz.
    $jsondata = file_get_contents($myFile);

    //json verileri decode ediyoruz.
    $arr_data = json_decode($jsondata, true);


    /*
     * Önemli :
     *
     *  Mükerrer kayıt var ise "vehicleID" sine göre eşleştiriyoruz.
     *  olanı siliyoruz. Burada "array_splice" kullanılabilirdi.
     *
     *  unset işeminden sonra tekrar sıralama yapmamaızın sebebi "unset()" dizi sırasını da sildiği için
     *  json dosyasına verileri eklerken otomatik olarak sıralama yapmakta buda json parse işlemimize uymuyor.
     *
     * */
    foreach ($arr_data as $index => $array){

        if($array['vehicleID'] == $formdata['vehicleID']){

            unset($arr_data[$index]);
            sort($arr_data);
        }
    }

    //formdan array i mevcut array emize ekliyoruz.
    array_push($arr_data,$formdata);

    //array verilerimizi  json a encode ediyoruz.
    $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);

    //json verilerimizi json dosyasına ekliyoruz.
    if(file_put_contents($myFile, $jsondata)) {
        echo 'Data successfully saved';
    }
    else
        echo "error";

}
catch (Exception $e) {

    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


/*
 * Harita üzerinde göstermek istediğmizi verilerimizi gönderiyoruz.
 * */
$client = new Client(new Version2X('http://localhost:3001'));

$client->initialize();
$client->emit('broadcast', $arr_data);
$client->close();