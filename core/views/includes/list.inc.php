<div class="card mt-3">
    <div class="card-body">
        <h3>Выберете задачу для редактирования:</h3>
        <table class="table table-hover">
            <thead>
            <tr>
                <th> <a <?=(is_null($_GET['order']))?"style=\"color: red\"":""?>
                        href="/admin/list/<?='?'.$data['desc']?>">#</a>
                </th>
                <th><a
                        <?=($_GET['order'] == 'email')?"style=\"color: red\"":""?>
                        href="/admin/list/?order=email<?=$data['desc']?>">email
                    </a>
                </th>
                <th><a
                        <?=($_GET['order'] == 'name')?"style=\"color: red\"":""?>
                        href="/admin/list/?order=name<?=$data['desc']?>">имя
                    </a>
                </th>
                <th>задача</th>
                <th><a
                        <?=($_GET['order'] == 'status')?"style=\"color: red\"":""?>
                        href="/admin/list/?order=status<?=$data['desc']?>">статус
                    </a>
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data['tasks'] as $task):
                $admin = ($task['status_admin'] == 1)? "отредактировано администратором":"";
                ?>
                <tr>
                    <td><?=$task['id']?></td>
                    <td><?=$task['email']?></td>
                    <td><?=$task['name']?></td>
                    <td><?=$task['text']?></td>
                    <td><?=($task['status'] == 1)
                            ?"<span style='color: #1e7e34'>Выполнено</span>"
                            :"<span style='color: red'>Не выполнено /<br> $admin</span><br>
                              <a href='admin/performed/{$task['id']}'>в выполненные-></a>"?>
                    </td>
                    <td><a href="/admin/show/<?=$task['id']?>">редактировать</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot></tfoot>
        </table>
    </div>
</div>
<br>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php new \library\Pagination($_GET['view'], $data['count'], 10)?>
            </div>
        </div>
    </div>
</div>
<br>
