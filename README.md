![Klien API RajaOngkir untuk PHP](https://rawcdn.githack.com/kavist/rajaongkir/38bae45b88c98e94ecb20a460403e7484c6c2bb4/cover.png)

# Klien API RajaOngkir untuk PHP
[![Latest Version](https://img.shields.io/github/v/release/kavist/rajaongkir?label=Release&sort=semver&style=flat-square)](https://github.com/kavist/rajaongkir/releases)
[![Packagist Version](https://img.shields.io/packagist/v/kavist/rajaongkir?label=Packagist&style=flat-square)](https://packagist.org/packages/kavist/rajaongkir)
![PHP Version Required](https://img.shields.io/packagist/php-v/kavist/rajaongkir?label=PHP%20Version&style=flat-square)
[![MIT Licensed](https://img.shields.io/github/license/kavist/rajaongkir?label=License&style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/kavist/rajaongkir?label=Travis%20CI%20build&style=flat-square)](https://travis-ci.org/kavist/rajaongkir)
[![StyleCI](https://styleci.io/repos/212767959/shield)](https://styleci.io/repos/212767959)

Paket pustaka PHP untuk mengakses API RajaOngkir dengan mudah.

### Fitur
- [x] Daftar semua provinsi.
- [x] Ambil provinsi berdasarkan ID.
- [x] Pencarian provinsi berdasarkan nama.
- [x] Daftar semua kota/kabupaten.
- [x] Daftar kota/kabupaten berdasarkan ID provinsinya.
- [x] Ambil kota/kabupaten berdasarkan ID.
- [x] Pencarian kota/kabupaten berdasarkan nama.
- [x] Ambil biaya pengiriman (ongkos kirim/ongkir).


#### _To Do_
- [ ] Fitur di tipe akun Basic dan Pro.
- [ ] Pencarian _fuzzy_ (menggunakan [Fuse](https://github.com/loilo/Fuse)).


## Persyaratan Sistem
* PHP 7.0 (direkomendasikan untuk menggunakan PHP 7.1 atau lebih tinggi).


## Instalasi
Gunakan [Composer](https://getcomposer.org) untuk menginstal pustaka ini.
```sh
$ composer require kavist/rajaongkir:^1.1
```
Anda juga bisa menambahkan dependensi ke `composer.json`.
```json
{
    "require": {
        "kavist/rajaongkir": "^1.1"
    }
}
```
### Integrasi ke Laravel
Bagi pengguna Laravel 5.5 atau lebih tinggi, paket ini akan tersedia secara otomatis 
berkat fitur _auto-discovery_. Anda bisa langsung lanjut ke bagian 
[konfigurasi untuk Laravel](#konfigurasi-untuk-laravel) di bawah.

Bagi pengguna Laravel sebelum versi 5.5, **kode dalam proyek ini tidak dites di versi Laravel dibawah 5.5.**
Jadi, dimohon pengertiannya jika pustaka ini tidak dapat berjalan dengan semestinya.


## Konfigurasi
Untuk pengguna PHP _native_, deklarasikan kunci API sebagai parameter ketika Anda 
menginstansiasi _class_ `Kavist\RajaOngkir\RajaOngkir`.
```php
$rajaOngkir = new RajaOngkir('isi_API_key_Anda_disini');
```
### Konfigurasi untuk Laravel
Anda cukup mengatur nilai `RAJAONGKIR_API_KEY` yang berisi kunci API ke _environment variable_.
```env
RAJAONGKIR_API_KEY=isi_API_key_Anda_disini
```
Anda juga bisa menerbitkan berkas konfigurasi paket ini untuk konfigirasi lebih jauh.
```sh
$ php artisan vendor:publish --provider="Kavist\RajaOngkir\Providers\LaravelServiceProvider"
```


## Penggunaan
### Provinsi
#### Daftar provinsi
Untuk mendapatkan daftar provinsi, gunakan metode `provinsi()->all()`.
```php
// Native PHP
use Kavist\RajaOngkir\RajaOngkir;

$rajaOngkir = new RajaOngkir($apiKey);
$daftarProvinsi = $rajaOngkir->provinsi()->all();

// Laravel
use Kavist\RajaOngkir\Facades\RajaOngkir;

$daftarProvinsi = RajaOngkir::provinsi()->all();
```

#### Ambil provinsi berdasarkan ID
Untuk mendapatkan provinsi berdasarkan ID, gunakan metode `provinsi()->find(int|string $id)`.
```php
// Native PHP
use Kavist\RajaOngkir\RajaOngkir;

$rajaOngkir = new RajaOngkir($apiKey);
$daftarProvinsi = $rajaOngkir->provinsi()->find(11);

// Laravel
use Kavist\RajaOngkir\Facades\RajaOngkir;

$daftarProvinsi = RajaOngkir::provinsi()->find(11);
```

#### Pencarian provinsi berdasarkan nama
Untuk mencari provinsi berdasarkan nama, gunakan metode `provinsi()->search(string $searchTerm)->get()`.
```php
// Native PHP
use Kavist\RajaOngkir\RajaOngkir;

$rajaOngkir = new RajaOngkir($apiKey);
$daftarProvinsi = $rajaOngkir->provinsi()->search('ja')->get();

// Laravel
use Kavist\RajaOngkir\Facades\RajaOngkir;

$daftarProvinsi = RajaOngkir::provinsi()->search('ja')->get();
```

### Kota/Kabupaten
#### Daftar kota/kabupaten
Untuk mendapatkan daftar kota/kabupaten, gunakan metode `kota()->all()`.
```php
// Native PHP
use Kavist\RajaOngkir\RajaOngkir;

$rajaOngkir = new RajaOngkir($apiKey);
$daftarProvinsi = $rajaOngkir->kota()->all();

// Laravel
use Kavist\RajaOngkir\Facades\RajaOngkir;

$daftarProvinsi = RajaOngkir::kota()->all();
```

#### Ambil kota/kabupaten berdasarkan ID
Untuk mendapatkan kota/kabupaten berdasarkan ID, gunakan metode `kota()->find(int|string $id)`.
```php
// Native PHP
use Kavist\RajaOngkir\RajaOngkir;

$rajaOngkir = new RajaOngkir($apiKey);
$daftarProvinsi = $rajaOngkir->kota()->find(80);

// Laravel
use Kavist\RajaOngkir\Facades\RajaOngkir;

$daftarProvinsi = RajaOngkir::kota()->find(80);
```

#### Daftar kota/kabupaten berdasarkan ID provinsinya
Untuk mendapatkan kota/kabupaten berdasarkan ID provinsinya, gunakan metode `kota()->dariProvinsi(int|string $provinceId)->get()`.
```php
// Native PHP
use Kavist\RajaOngkir\RajaOngkir;

$rajaOngkir = new RajaOngkir($apiKey);
$daftarProvinsi = $rajaOngkir->kota()->dariProvinsi(11)->find(80);

// Laravel
use Kavist\RajaOngkir\Facades\RajaOngkir;

$daftarProvinsi = RajaOngkir::kota()->dariProvinsi(11)->find(80);
```

#### Pencarian kota/kabupaten berdasarkan nama
Untuk mencari kota/kabupaten berdasarkan nama, gunakan metode `kota()->search(string $searchTerm)->get()`.
```php
// Native PHP
use Kavist\RajaOngkir\RajaOngkir;

$rajaOngkir = new RajaOngkir($apiKey);
$daftarProvinsi = $rajaOngkir->kota()->search('su')->get();

// Laravel
use Kavist\RajaOngkir\Facades\RajaOngkir;

$daftarProvinsi = RajaOngkir::kota()->search('su')->get();
```

Anda juga bisa mencari kota/kabupaten dari provinsi tertentu dengan memanggil 
metode `dariProvinsi()` sebelum memanggil metode `search()`.
```php
// Native PHP
use Kavist\RajaOngkir\RajaOngkir;

$rajaOngkir = new RajaOngkir($apiKey);
$daftarProvinsi = $rajaOngkir->kota()->dariProvinsi(11)->search('su')->get();

// Laravel
use Kavist\RajaOngkir\Facades\RajaOngkir;

$daftarProvinsi = RajaOngkir::kota()->dariProvinsi(11)->search('su')->get();
```

## Pencarian biaya pengiriman
Untuk mengambil biaya pengiriman, gunakan metode `ongkosKirim(array $payload)`.
```php
// Native PHP
use Kavist\RajaOngkir\RajaOngkir;

$rajaOngkir = new RajaOngkir($apiKey);
$daftarProvinsi = $rajaOngkir->ongkosKirim([
    'origin'        => 155,     // ID kota/kabupaten asal
    'destination'   => 80,      // ID kota/kabupaten tujuan
    'weight'        => 1300,    // berat barang dalam gram
    'courier'       => 'jne'    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
]);

// Laravel
use Kavist\RajaOngkir\Facades\RajaOngkir;

$daftarProvinsi = RajaOngkir::ongkosKirim([
    'origin'        => 155,     // ID kota/kabupaten asal
    'destination'   => 80,      // ID kota/kabupaten tujuan
    'weight'        => 1300,    // berat barang dalam gram
    'courier'       => 'jne'    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
]);
```
Selain metode `ongkosKirim()`, juga tersedia metode `ongkir()` dan `biaya()` sebagai 
alias dari metode `ongkosKirim()`.


## Pengujian
Jalankan pengujian dengan perintah berikut.
```sh
$ vendor/bin/phpunit
```


## Log Perubahan
Silakan membaca [log perubahan](CHANGELOG.md) untuk informasi lengkap.


## Ingin berkontribusi?
Silakan membaca [tata cara berkontribusi](CONTRIBUTING.md) untuk informasi lengkap.


## Kontributor
- [Ian Mustafa](https://github.com/ianmustafa)
- [Seluruh Kontributor](https://github.com/kavist/rajaongkir/contributors)


## Lisensi
The MIT License (MIT). Silakan membaca [berkas lisensi](LICENSE) untuk informasi lengkap.
