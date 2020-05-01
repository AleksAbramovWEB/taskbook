<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">ВХОД</div>

            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Имя пользователя:</label>

                        <div class="col-md-6">
                            <input id="email" type="text" class="form-control <?=($data['error']['name'])?"is-invalid":""?> " name="name" value="<?=$_POST['name']?>" required autocomplete="email" autofocus>
                            <?php if ($data['error']['name']):?>
                                <span class="invalid-feedback" role="alert">
                                        <strong><?=$data['error']['name']?></strong>
                                    </span>
                            <?php endif;?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">ПАРОЛЬ:</label>

                        <div class="col-md-6">
                            <input id="password"
                                   type="password"
                                   class="form-control <?=($data['error']['password'])?"is-invalid":""?>"
                                   name="password"
                                   value="<?=$_POST['password']?>"
                                   required autocomplete="current-password">
                            <?php if ($data['error']['password']):?>
                                <span class="invalid-feedback" role="alert">
                                        <strong><?=$data['error']['password']?></strong>
                                    </span>
                            <?php endif;?>
                        </div>
                    </div>


                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                ВОЙТИ
                            </button>
                            <a class="btn btn-link" href="/">На главную</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
