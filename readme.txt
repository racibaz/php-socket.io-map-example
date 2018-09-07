
Araç verisi gödnerilen url
http://localhost/yoyo/emmit_test.php?vehicleID=100&latitude=41.5760&longitude=34.5788

Harita url si
http://localhost/yoyo/reciever_1.php

Notlar : 
1) Harita sayfasý ilk açýldýðýnda veriler gelmiyor. Veri gönderildiðinde veriler gösteriliyor.

2) Orjinal verilerde mükerrer olan 33 ve 35 vehicleID li veriler kaldýrýldý nedeni ise her defasýnda json dosyasýnýn 
tamamýný unique hale getirmeye çalýþmamaktý çünkü her eklenen veri json dosyasýnda 
mükerreri varsa siliyoruz ve güncelini ekliyoruz.

