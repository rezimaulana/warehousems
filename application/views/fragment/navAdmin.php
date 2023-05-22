<?php $url = $this->uri->slash_segment(1, 'both');?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-2">
    <div class="container-fluid">
        <a class="navbar-brand"><?=APPLICATION_NAME;?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $url == "/dashboard/" ? 'active' : '' ?>" href="<?=base_url("dashboard");?>">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $url == "/items/" ? 'active' : '' ?>" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Master Data</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?= $url == "/items/" ? 'active' : '' ?>" href="<?=base_url("items");?>">Warehouse Item</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $url == "/manage-request/" ? 'active' : '' ?>" href="<?=base_url("manage-request");?>">Manage Request</a>
                </li>
                
            </ul>
            <button type="button" class="btn btn-primary nav-item dropdown">
                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Akun</a>
                <ul class="dropdown-menu dropdown-menu-lg-end">
                    <li><a class="dropdown-item" id="btn-Logout" href="<?=base_url("dexin/logout")?>">Logout</a></li>
                </ul>
            </button>
        </div>
    </div>
</nav>