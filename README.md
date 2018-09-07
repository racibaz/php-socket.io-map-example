# php-socket.io-map-example


Araç verisi gödnerilen url
http://localhost/yoyo/emmit_test.php?vehicleID=100&latitude=41.5760&longitude=34.5788

Harita url si
http://localhost/yoyo/reciever_1.php

Notlar : 
1) Harita sayfası ilk açıldığında veriler gelmiyor. Veri gönderildiğinde veriler gösteriliyor.

2) Orjinal verilerde mükerrer olan 33 ve 35 vehicleID li veriler kaldırıldı nedeni ise her defasında json dosyasının 
tamamını unique hale getirmeye çalışmamaktı çünkü her eklenen veri json dosyasında 
mükerreri varsa siliyoruz ve güncelini ekliyoruz.
