<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <h1>Sistem Informasi Perpustakaan</h1>
            <h3>Cari Buku :</h3>
            <!-- basepath/index.php -->
            <form method="post" action="<?=base_url("dexin")?>">
                Judul : 
                <input type="text" name="judul" placeholder="Ketik judul">
                <input type="submit" name="submit" value="cari">
            </form>
            <?php
            if($result!=null) {
                echo "<h3>Hasil pencarian : </h3>";
                foreach($result as $res) {
                    echo $res->judul.' (pengarang : '.$res->nama.')'.'<hr>';
                }
            }
            else {
                return false;
            }
            ?>
        </div>
    </div>
</div>