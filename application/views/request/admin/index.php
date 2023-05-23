<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <table id="table1" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Request Type</th>
                        <th>User</th>
                        <th>Admin</th>
                        <th>Item Count</th>
                        <th>Item Sum</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $res) {?>
                        <tr>
                            <td><?= $res['trx_code'] ?></td>
                            <td><?= $res['code'] ?> - <?= $res['name'] ?></td>
                            <td><?= $res['user_fullname'] ?></td>
                            <td><?= $res['adm_fullname'] ?></td>
                            <td><?= $res['item_count'] ?></td>
                            <td><?= $res['item_sum'] ?></td>
                            <td>
                                <?php
                                    if($res['approval'] == 0 && $res['adm_fullname'] == '') {
                                        echo 'PENDING';
                                    } else if($res['approval'] == 0) {
                                        echo 'REJETED';
                                    } else {
                                        echo 'ACCEPTED';
                                    }
                                ?>
                            </td>
                            <td><?= $res['created_at'] ?></td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="<?= base_url('request/edit/').$res['id'] ?>">Manage</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Code</th>
                        <th>Request Type</th>
                        <th>User</th>
                        <th>Admin</th>
                        <th>Item Count</th>
                        <th>Item Sum</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>