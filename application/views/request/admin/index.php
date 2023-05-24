<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="mb-4">
                <label for="status_filter" class="form-label">Filter by Status:</label>
                <select id="status_filter" class="form-select">
                    <option value="">All</option>
                    <option value="ACCEPTED">ACCEPTED</option>
                    <option value="REJECTED">REJECTED</option>
                    <option value="PENDING">PENDING</option>
                </select>
            </div>
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
                    <?php if (is_array($result) && count($result) > 0) { ?>
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
                                        echo 'REJECTED';
                                    } else {
                                        echo 'ACCEPTED';
                                    }
                                ?>
                            </td>
                            <td><?= $res['created_at'] ?></td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="<?= base_url('request/detail/').$res['id'] ?>">Manage</a>
                            </td>
                        </tr>
                    <?php } } ?>
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