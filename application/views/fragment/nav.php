<?php
$url = $this->uri->slash_segment(1, 'both');;
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CRUDCI</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= base_url() == current_url() ? 'active' : '' ?>" href="<?=base_url()?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $url == "/pengarang/" ? 'active' : '' ?>" href="<?=base_url("pengarang")?>">Pengarang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $url == "/buku/" ? 'active' : '' ?>" href="<?=base_url("buku")?>">Buku</a>
                </li>
            </ul>
        </div>
    </div>
</nav>