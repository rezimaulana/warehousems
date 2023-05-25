[![Contributors][contributors-shield]][contributors-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]
## Warehouse Management System

![Database Diagram](https://github.com/rezimaulana/warehousems/raw/main/db_warehousems.png)

### Installation

1. Clone atau download repo
   ```sh
   git clone https://github.com/rezimaulana/warehousems.git
   ```
2. Download XAMPP [disini.](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.3.1/xampp-win32-7.3.1-0-VC15-installer.exe/download)
3. Copy project ke htdocs
4. Gunakan [db_warehousems.sql](https://github.com/rezimaulana/warehousems/blob/main/db_warehousems.sql) untuk migrasi data




### Flow Sistem

1. Ada 3 level user: system, admin, user
2. Login:
    ```sh
    Email : admin@gmail.com
    Password : admin
    Email : user@gmail.com
    Password : admin
    Email : system@gmail.com
    Password : admin
    ```
3. System tidak bisa login, hanya sebagai scheduler untuk insert data
4. Admin bisa(create, delete, edit, view) item
5. User hanya bisa lihat item
6. Create item, qty default adalah 0
7. Nama item dan kategori bisa di edit
8. Delete menggunakan fitur soft delete dari is active, sehingga transaksi sebelumnya tetap ada.
9. View Item beserta jenis request check-in/check-out
10. User bisa check-in/check-out dengan qty
11. Admin bisa aprrove atau reject request tersebut
12. Approve/reject hanya bisa dilakukan 1x
13. Jika item dalam stok akan minus maka approve tidak bisa dilakukan

[contributors-shield]: https://img.shields.io/github/contributors/rezimaulana/warehousems.svg?style=for-the-badge
[contributors-url]: https://github.com/rezimaulana/warehousems/graphs/contributors
[license-shield]: https://img.shields.io/github/license/rezimaulana/warehousems.svg?style=for-the-badge
[license-url]: https://github.com/rezimaulana/warehousems/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/rezimaulana