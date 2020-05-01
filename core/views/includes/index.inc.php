<div class="row justify-content-center">
    <div class="col-md-12">
        <?php if ($data['feedback']['create']):?>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        ЗАДАЧА УСПЕШНО ДОБАВЛЕНА
                    </div>
                </div>
            </div>
        <?php endif;?>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h2>Добавить задачу:</h2>
                        <form action="/create" method="POST">
                            <div class="form-group">
                                <label for="email">email
                                    <span style="color: red"><?=$data['feedback']['error']['email']?></span>
                                </label>
                                <input name ="email"
                                       type="email"
                                       value="<?=$data['feedback']['data']['email']?>"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">имя
                                    <span style="color: red"><?=$data['feedback']['error']['name']?></span>
                                </label>
                                <input name="name"
                                       type="text"
                                       value="<?=$data['feedback']['data']['name']?>"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="task">задача
                                    <span style="color: red"><?=$data['feedback']['error']['text']?></span>
                                </label>
                                <input name="task"
                                       type="text"
                                       value="<?=$data['feedback']['data']['text']?>"
                                       class="form-control">
                            </div>
                            <button type="submit" class="btn btn-danger">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>ЗАДАЧИ:</h2>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th> <a <?=(is_null($_GET['order']))?"style=\"color: red\"":""?>
                                href="/<?='?'.$data['desc']?>">#</a>
                        </th>
                        <th><a
                                <?=($_GET['order'] == 'email')?"style=\"color: red\"":""?>
                                href="/?order=email<?=$data['desc']?>">email
                            </a>
                        </th>
                        <th><a
                                <?=($_GET['order'] == 'name')?"style=\"color: red\"":""?>
                                href="/?order=name<?=$data['desc']?>">имя
                            </a>
                        </th>
                        <th>задача</th>
                        <th><a
                                <?=($_GET['order'] == 'status')?"style=\"color: red\"":""?>
                                href="/?order=status<?=$data['desc']?>">статус
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data['tasks'] as $task):
                        $admin = ($task['status_admin'] == 1)? " /<br>отредактировано администратором":"";
                        ?>
                    <tr>
                        <td><?=$task['id']?></td>
                        <td><?=$task['email']?></td>
                        <td><?=$task['name']?></td>
                        <td><?=$task['text']?></td>
                        <td><?=($task['status'] == 1)
                                ?"<span style='color: #1e7e34'>Выполнено</span>"
                                :"<span style='color: red'>Не выполнено $admin</span>"?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php new \library\Pagination($_GET['view'], $data['count'], 3)?>
            </div>
        </div>
    </div>
</div>
<br>
