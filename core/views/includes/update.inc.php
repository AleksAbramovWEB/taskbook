
    <?php if ($data['feedback']['update']):?>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    ИЗМНЕНИЯ УСПЕШНО СОХРАНЕНЫ
                </div>
            </div>
        </div>
    <?php endif;?>
    <form method="POST" action="/admin/<?=$data['tasks']["id"]?>/update">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="maindata" role="tabpanel">
                                            <div class="form-group">
                                                <label for="email">email:
                                                     <span style="color: red"><?=$data["feedback"]['error']["email"]?></span>
                                                </label>
                                                <input name="email" value="<?=$data['tasks']["email"]?>"
                                                       id="email"
                                                       type="email"
                                                       class="form-control"
                                                       required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">имя:
                                                    <span style="color: red"><?=$data["feedback"]['error']["name"]?></span>
                                                </label>
                                                <input name="name" value="<?=$data['tasks']["name"]?>"
                                                       id="name"
                                                       type="text"
                                                       class="form-control"
                                                       required>
                                            </div>
                                            <div class="form-group">
                                                <label for="text">Задача:
                                                    <span style="color: red"><?=$data["feedback"]['error']["text"]?></span>
                                                </label>
                                                <textarea name="text"
                                                          id="text"
                                                          type="text"
                                                          class="form-control"
                                                          rows="15"
                                                ><?=$data['tasks']["text"]?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-body ">
                                    <button type="submit" class="btn btn-primary ">!Сохранить изменения!</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br>
