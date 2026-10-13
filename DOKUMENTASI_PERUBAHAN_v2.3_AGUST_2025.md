# DOKUMENTASI PERUBAHAN MENU ERP - 1 AGUSTUS 2025 v1

## - Revisi Selanjutnya...
- Rubahlah nama Kategori "OPERATIONS" menjadi "SHIPPING DELIVERY"
- Rubah semua nama struktur "STANSFER STOK" menjadi "STANSFER STOCK"
- Masih ada beberapa Katefoti terpisah seperti pada screenshoot yang saya lampirkan. ada beberapa Kategori "SETTINGS" Terpisah, saya ingin semua Kategori yang ada hanya dibuat 1 Kategori Group saja untuk tampilannya, jangan sampai terpisah" seperti itu. Pada bagian Menu "AKUNTANSI", "PRODUKSI" dan BIAYA" juga seharusnya itu ada di kategori "MANAGEMENT" bagian atas.
- Masukan menu "STANSFER STOCK" ke tampilan Kategori "INVENTORY"

- Pada bagian Menu "Pengiriman Paket" saya butuh 1 submenu lagi untuk "Pembatalan Pesanan / Cancel Order !!" dan silahkan kamu design UI nya yang Profer dan Profesional agar dapat mudah dioperasikan.

# Untuk kebutuhan pada semua submenu "Pengiriman Paket"
- Saya butuh Tabble Data semua submenu "Pengiriman Paket" dengan masing-masing format "NO, RESI PESANAN, EXPEDISI KURIR, MARKETPLACE, ACCOUNT (Dapat diisi manual atau di isi secara validasi data akun 1-20 dengan fitur setelan data seperti pada sreadsheet saya saat ini), KETERANGAN, STATUS PESANAN, DROPED OFF, HARI, TANGGAL, JAM, WIB (Saat input data terjadi). Semua Header Tabble Cell ini wajib ada pada semua submenu "PENGIRIMAN PAKET" yang ada.

# Untuk Logika yang dipakai pada Cell-cell saya menggunakan Logika-logika dibawah ini pada spread saya sebelumnya, dan semua SHEET biasanya saling sync satu sama lainnya :
- Saya ingin untuk semua resi pesanan wajib dapat di scan melalui scanner Barcode. 
- Pada Fitur / Modules "PENGIRIMAN PAKET" saya butuh settingan untuk Scalable kedepannya seperti data pada STATUS dan KETERANGAN dan juga fitur" lainnya yang isi logikanya dapat saya sclable kedepannya dengan mudah" 
- Untuk Refrensi Rumus / Logika yang digunakan dalam semua submenu "PENGIRIMAN PAKET" ini ada link ini : https://docs.google.com/spreadsheets/d/1bzn1oK1FWI5p1ksLDpYKxAQEp4pjFxiUtuZJfORDNFs/edit?usp=sharing jika ada kekurangan nanti kita revisi di scalable versi berikutnya.


## Dari Link SPreadsheet tersebut, saya menggunakan Rumus Logika dibawah ini pada SHEET "1-SCAN PROSES PESANAN | PAKET YANG SUDAH DISIAPKAN"
### Baris Tabble "EXPEDISI KURIR" (Cell C) Menggunakan Logika / Rumus =
 =IF(
  B17=""; 
  ""; 
  SWITCH(
    TRUE();
    AND(REGEXMATCH(B17;"^[0-9]+$"); LEN(B17)=14);  "AnterAja";
    AND(REGEXMATCH(B17;"^[0-9]+$"); LEN(B17)=12);  "SICEPAT";
    LEFT(B17;2)="CM";          "JNE";
    LEFT(B17;2)="JY";          "JNE YES";
    LEFT(B17;3)="SPX";         "SPX";
    LEFT(B17;4)="SHPE";        "POS REG";
    LEFT(B17;2)="25";          "INSTANT";
    LEFT(B17;4)="2505";        "SAMEDAY";
    LEFT(B17;4)="TKSC";        "SICEPAT HALU";
    LEFT(B17;3)="JNE";         "JNE";
    LEFT(B17;2)="TL";          "JNE";
    LEFT(B17;2)="JP";          "J&T";
    LEFT(B17;2)="ID";          "ID Express";
    LEFT(B17;3)="SCE";         "SICEPAT";
    LEFT(B17;1)=" ";           "RESI NOT VALID";
    "Lainnya"
  )
)

### MARKETPLACE (Cell D) =
=IFS(
  B17="";                                  "";  
  LEFT(B17;1)=" ";                         "CEK SPASI RESI";
  C17="RESI NOT VALID";                    "CEK SPASI RESI";
  LEFT(B17;3)="SPX";                       "SHOPEE";
  AND(REGEXMATCH(B17;"^[0-9]+$");LEN(B17)=14);"SHOPEE";
  AND(REGEXMATCH(B17;"^[0-9]+$");LEN(B17)=12);"SHOPEE";
  LEFT(B17;2)="TG";                        "TIKTOK";
  LEFT(B17;2)="TK";                        "TOKPED";
  LEFT(B17;2)="TP";                        "TOKPED";
  LEFT(B17;2)="TL";                        "TOKPED";
  LEFT(B17;3)="JNE";                       "JNE";
  LEFT(B17;4)="SHPE";                      "SHOPEE";
  LEFT(B17;1)="J";                         "SHOPEE";
  LEFT(B17;2)="CM";                        "SHOPEE";
  LEFT(B17;2)="ID";                        "SHOPEE";
  LEFT(B17;2)="25";                        "SHOPEE";
  TRUE;                                     "CEK ULANG !!"
)

### ACCOUNT (Cell E) =
Manual atau Bisa juga dibuat Validasi Data ACCOUNT 1-20

### KETERANGAN (Cell F) =
=LET(
  v; B17;
  g; G17;
  i; I17;
  k; K17;
  l; L17;

  cancelO; 'CANCEL ORDER | PENGAJUAN CANCEL PESANAN !'!$O$17:$O4083;
  cancelB; 'CANCEL ORDER | PENGAJUAN CANCEL PESANAN !'!$B$17:$B4083;
  cancelF; 'CANCEL ORDER | PENGAJUAN CANCEL PESANAN !'!$F$17:$F4083;
  scanDrop; '2 - SCAN PENGIRIMAN PAKET | DROP OFF !!'!$B$17:$B8083;

  isDouble; AND(v <> ""; COUNTIF($B$17:$B4083; v) > 1);
  isCancelO;  COUNTIF(cancelO; v) > 0;
  idxCancelB; IF(COUNTIF(cancelB; v) > 0; MATCH(v; cancelB; 0); NA());
  isPickuped; ISNUMBER(MATCH(v; scanDrop; 0));

  SWITCH(
    TRUE;
    v = "";                                     "";
    g = "Need Response";                        "PENGAJUAN CANCEL";
    g = "Cek Ulang Pesanan";                    "PENGAJUAN CANCEL";
    isDouble;                                   "DOUBLE";
    isCancelO;                                  "Beresiko Terlambat";
    ISNUMBER(idxCancelB);                       INDEX(cancelF; idxCancelB);
    AND(i = "PICK UP"; isPickuped);             "Sudah di Pickup";
    AND(g = "Process Packing"; k = TODAY());    "Sudah Disiapkan";
    AND(g = "Process Packing"; k = TODAY()-1; l < TIME(23;59;59)); "Beresiko Terlambat";
    AND(g = "Process Packing"; k = TODAY()-2);  "Batal BESOK";
    isPickuped;                                 "DROPPED OFF";
    TRUE;                                       "Sudah Disiapkan"
  )
)

### STATUS PESANAN (Cell G-H) =
=LET(
  v; B17;
  f; F17;
  i; I17;

  cancelB; 'CANCEL ORDER | PENGAJUAN CANCEL PESANAN !'!$B$17:$B4083;
  cancelP; 'CANCEL ORDER | PENGAJUAN CANCEL PESANAN !'!$P$17:$P4083;
  scanDrop; '2 - SCAN PENGIRIMAN PAKET | DROP OFF !!'!$B$17:$B8083;

  isDup;      COUNTIF($B$17:$B4083; v) > 1;
  isDropped;  ISNUMBER(MATCH(v; scanDrop; 0));
  isCanceled; ISNUMBER(MATCH(v; cancelB; 0));
  isPicked;   f = "SUDAH DI PICKUP";
  isPickup;   i = "PICK UP";
  isPembatal; OR(f = "PEMBATALAN DITERIMA"; f = "BATAL OTOMATIS");
  isMenarik;  f = "MENARIK PEMBATALAN";
  isToday;    ISNUMBER(MATCH(v; cancelP; 0));

  SWITCH(
    TRUE();
    v = "";              "";
    isPicked;           "Sudah Terkirim !!";
    isPickup;           "Menunggu Pickup";
    isPembatal;         "JANGAN DIKIRIMKAN !!";
    isDup;              "JANGAN DIKIRIMKAN !!";
    isDropped;          "Sudah Terkirim !!";
    isMenarik;          "Segera Kirimkan Pesanan";
    isCanceled;         "Need Response";
    isToday;            "Dikirim HARI INI !!";
    TRUE();             "Process Packing"
  )
)

### DROPPED OFF (Cell I) =
=LET(
  v; C17;
  s; G17;
  IF(
    v=""; 
    ""; 
    IF(
      s="CANCEL !!"; 
      "Cek Lagi !!"; 
      SWITCH(
        v;
        "Same Day";   "Pick Up";
        "INSTANT";    "Pick Up";
        "J&T Cargo";  v;
        "JNE";        v;
        "JNE YES";    v;
        "POS REG";    "Kantor POS";
        "Lainnya";    "Lainnya";
        "Si Cici"
      )
    )
  )
)

### HARI, TANGGAL, dan WAKTU WIB =
Ini terisi otomatis ketika cell (B) SCAN NO RESI nya terisi (ada nilainya) menggunakan script spreadsheet triger. 


## Dari Link SPreadsheet tersebut, saya menggunakan Rumus Logika dibawah ini pada SHEET "2 - SCAN PENGIRIMAN PAKET | DROP OFF !!"
### Baris Tabble "EXPEDISI KURIR" (Cell C) Menggunakan Logika / Rumus =
=IF(
  B17=""; 
  ""; 
  SWITCH(
    TRUE();
    AND(REGEXMATCH(B17;"^[0-9]+$"); LEN(B17)=14);  "AnterAja";
    AND(REGEXMATCH(B17;"^[0-9]+$"); LEN(B17)=12);  "SICEPAT";
    LEFT(B17;2)="CM";          "JNE";
    LEFT(B17;2)="JY";          "JNE YES";
    LEFT(B17;3)="SPX";         "SPX";
    LEFT(B17;4)="SHPE";        "POS REG";
    LEFT(B17;2)="25";          "INSTANT";
    LEFT(B17;4)="2505";        "SAMEDAY";
    LEFT(B17;4)="TKSC";        "SICEPAT HALU";
    LEFT(B17;3)="JNE";         "JNE";
    LEFT(B17;2)="TL";          "JNE";
    LEFT(B17;2)="JP";          "J&T";
    LEFT(B17;2)="ID";          "ID Express";
    LEFT(B17;3)="SCE";         "SICEPAT";
    LEFT(B17;1)=" ";           "RESI NOT VALID";
    "Lainnya"
  )
)


### MARKETPLACE (Cell D) =
=IFS(
  B17="";                                  "";  
  LEFT(B17;1)=" ";                         "CEK SPASI RESI";
  C17="RESI NOT VALID";                    "CEK SPASI RESI";
  LEFT(B17;3)="SPX";                       "SHOPEE";
  AND(REGEXMATCH(B17;"^[0-9]+$");LEN(B17)=14);"SHOPEE";
  AND(REGEXMATCH(B17;"^[0-9]+$");LEN(B17)=12);"SHOPEE";
  LEFT(B17;2)="TG";                        "TIKTOK";
  LEFT(B17;2)="TK";                        "TOKPED";
  LEFT(B17;2)="TP";                        "TOKPED";
  LEFT(B17;2)="TL";                        "TOKPED";
  LEFT(B17;3)="JNE";                       "JNE";
  LEFT(B17;4)="SHPE";                      "SHOPEE";
  LEFT(B17;1)="J";                         "SHOPEE";
  LEFT(B17;2)="CM";                        "SHOPEE";
  LEFT(B17;2)="ID";                        "SHOPEE";
  LEFT(B17;2)="25";                        "SHOPEE";
  TRUE;                                     "CEK ULANG !!"
)


### ACCOUNT (Cell E) =
Manual atau Bisa juga dibuat Validasi Data ACCOUNT 1-20

### KETERANGAN (Cell F) =
=LET(
  v; B17;
  g; G17;
  i; I17;

  cancelB; 'CANCEL ORDER | PENGAJUAN CANCEL PESANAN !'!$B$17:$B11052;
  cancelO; 'CANCEL ORDER | PENGAJUAN CANCEL PESANAN !'!$O$17:$O11052;
  cancelF; 'CANCEL ORDER | PENGAJUAN CANCEL PESANAN !'!$F$17:$F11052;

  scanB; '1-SCAN PROSES PESANAN | PAKET YANG SUDAH DISIAPKAN'!$B$17:$B7040;
  scanF; '1-SCAN PROSES PESANAN | PAKET YANG SUDAH DISIAPKAN'!$F$17:$F7040;
  scanK; '1-SCAN PROSES PESANAN | PAKET YANG SUDAH DISIAPKAN'!$K$17:$K7040;
  scanL; '1-SCAN PROSES PESANAN | PAKET YANG SUDAH DISIAPKAN'!$L$17:$L7040;

  idxCancel; MATCH(v; cancelB; 0);
  idxScan; MATCH(v; scanB; 0);

  foundCancel; ISNUMBER(idxCancel);
  foundCancelO; ISNUMBER(MATCH(v; cancelO; 0));
  foundScan; ISNUMBER(idxScan);
  isDouble; COUNTIF(#REF!; v) > 1;

  scanDate; IF(foundScan; INDEX(scanK; idxScan); NA());
  scanTime; IF(foundScan; TIMEVALUE(TEXT(INDEX(scanL; idxScan); "HH:MM")); NA());

  IF(
    ISBLANK(v);
    "";
    IF(
      OR(g="CANCEL"; g="DOUBLE");
      "JANGAN DIKIRIM !!";
      IF(
        foundCancel;
        INDEX(cancelF; idxCancel);
        IF(
          foundCancelO;
          "Beresiko Terlambat";
          IF(
            AND(i="PICK UP"; foundScan);
            "Sudah di Pickup";
            IF(
              g="CEK ULANG PESANAN";
              "PENGAJUAN CANCEL";
              IF(
                isDouble;
                "Sudah Diproses !!";
                IF(
                  foundScan;
                  IF(
                    AND(scanDate=TODAY()-1; scanTime<TIME(21;0;0));
                    "Beresiko Terlambat";
                    INDEX(scanF; idxScan)
                  );
                  "Belum Ke Scan"
                )
              )
            )
          )
        )
      )
    )
  )
)


### STATUS PESANAN (Cell G-H) =
=LET(
  v; B17;
  f; F17;
  k; K17;
  cancelRange; 'CANCEL ORDER | PENGAJUAN CANCEL PESANAN !'!$B$17:$B11261;
  scanRange; '1-SCAN PROSES PESANAN | PAKET YANG SUDAH DISIAPKAN'!$B$17:$B7235;
  isDup; COUNTIF($B$17:$B15261; v) > 1;
  hasCancel; ISNUMBER(MATCH(v; cancelRange; 0));
  hasScan; ISNUMBER(MATCH(v; scanRange; 0));
  timeDiff; NOW() - k;

  SWITCH(
    TRUE();
    v = "";                            "";
    isDup;                             "DOUBLE";
    f = "PEMBATALAN DITERIMA";         "JANGAN DIKIRIMKAN !!";
    f = "MENARIK PEMBATALAN";          "Terkirim !!";
    hasCancel;                         "Cek Ulang Pesanan";
    hasScan;                           "Terkirim !!";
    timeDiff > 2;                      "Terkirim !!";
    TRUE();                            "Scan Process Pesanan !!"
  )
)


### DROPPED OFF (Cell I) =
=LET(
  c; C17;
  g; G17;
  SWITCH(
    TRUE();
    c="";               "";
    g="CANCEL !!";      "Cek Lagi !!";
    c="Same Day";       "Pick Up";
    c="INSTANT";        "Pick Up";
    OR(c="J&T Cargo"; c="JNE"; c="JNE YES"); c;
    c="POS REG";        "Kantor POS";
    c="Lainnya";        "Lainnya";
    TRUE();             "Si Cici"
  )
)


### HARI, TANGGAL, dan WAKTU WIB =
Ini terisi otomatis ketika cell (B) SCAN NO RESI nya terisi (ada nilainya) menggunakan script spreadsheet triger. 