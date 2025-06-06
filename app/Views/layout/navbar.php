<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">HENDRI_CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>

                    <?php if (has_permission("data-pegawai")):?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/crud">Data Pegawai</a>
                    </li>
                    <?php endif;?>

                    <?php if (has_permission("data-pegawai")):?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/departemen">Data Departemen</a>
                    </li>
                    <?php endif;?>

                    <?php if (has_permission("data-penilaian")):?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/penilaian">Penilaian</a>
                    </li>
                    <?php endif;?>

                    <?php if (has_permission("data-pegawai")):?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/users">Data User</a>
                    </li>
                    <?php endif;?>

                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?= user()->username?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/profil">Profil</a></li>
                            <li><a class="dropdown-item" href="/password">Ubah password</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>