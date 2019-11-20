<?php

?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <span class="text-white mr-5"><?= $user->username ?> (<?= $user->email ?>)</span>
            <a href="/web/logout">Выйти</a>
        </form>
    </div>
</nav>

<div class="container wrapper">
    <div class="row">
        <div class="starter-template">
            <div class="col-4 avatar">
                <?php if (file_exists(createRoute('public/images/avatars/' . $user->photo))) : ?>
                    <img src="/images/avatars/<?= $user->photo ?>" alt="" width="300">
                <?php else : ?>
                    <img src="/images/default-user.png" alt="" width="300">
                <?php endif; ?>
            </div>
        </div>
        <div class="col-4">
            <h4><?= encode($user->username) ?></h4>
            <hr>
            <h6>Email : <?= encode($user->email) ?></h6>
            <hr>
            <h6>Дата регистрации : <?= (new DateTime($user->created_at))->format('H:i:s d-m-Y') ?></h6>
            <hr>
        </div>
    </div>
</div>
