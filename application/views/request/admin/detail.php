<?php
$status;
if ($result[0]['approval'] == 0 && $result[0]['adm_fullname'] == '') {
    $status = 'PENDING';
} else if ($result[0]['approval'] == 0) {
    $status = 'REJECTED';
} else {
    $status ='ACCEPTED';
}
?>
<div class="container-fluid">

    <div class="row g-1">
        <div class="col-md-10 offset-md-1">
        <?php echo '<h6 class="mb-2">'.$this->session->flashdata("success").'</h6>'; ?>
        <?php echo '<h6 class="mb-2">'.$this->session->flashdata("error").'</h6>'; ?>
            <div class="card mt-3">
                <div class="card-header">
                    <form id="form-request-approve" name="form-request-approve" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Request Detail</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <?php $arrNewQty = []; ?>
                                <input type="text" id="id" name="id" value="<?=$result[0]['id']?>" hidden/>
                                <input type="text" id="ver" name="ver" value="<?=$result[0]['ver']?>" hidden/>
                                <input type="text" id="types" name="types" value="<?= $result[0]['code']; ?>" hidden/>
                                <input type="text" id="arrNewQty" name="arrNewQty" hidden/>
                                <a href="<?= base_url('request') ?>" class="btn btn-secondary">Back to List</a>
                                <button class="btn btn-primary" id="btn-request-approve" <?= $status == 'PENDING' ? '' : 'disabled' ?>>Approve</button>
                                <button class="btn btn-danger" id="btn-request-reject" <?= $status == 'PENDING' ? '' : 'disabled' ?>>Reject</button>

                            </div>
                        </div>
                    </form>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Info :
                        <span class="badge text-bg-secondary">Code : <?= $result[0]['code']; ?></span>
                        <span class="badge text-bg-secondary">Type : <?= $result[0]['name']; ?></span>
                        <span class="badge text-bg-secondary">Status : <?=  $status?></span>
                        <span class="badge text-bg-secondary">Data Version : <?= $result[0]['ver']; ?></span>
                    </li>
                    <li class="list-group-item">Admin :
                        <span class="badge text-bg-info"><?= $result[0]['adm_fullname']; ?></span>
                    </li>
                    <li class="list-group-item">User :
                        <span class="badge text-bg-info"><?= $result[0]['user_fullname']; ?></span>
                    </li>
                </ul>
                <div class="card-body">
                    <h6 class="card-title">Transaction Code : <?= $result[0]['trx_code'] ?></h6>
                    <p class="card-text">
                        Item Count : <?= $result[0]['item_count']; ?><br>
                        Item Sum : <?= $result[0]['item_sum']; ?>
                    </p>
                </div>
                <div class="card-footer">
                    <small class="text-muted"><?= $result[0]['created_at']; ?></small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 offset-md-1 mt-3">
            <div class="card">
                <div class="card-header">
                    <h5>Items</h5>
                </div>
                <div class="card-body">

                    <div class="row">
                        <table id="table1" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>In Stock</th>
                                    <th>Quantity</th>
                                    <th>New Quantity</th>
                                    <th>Category</th>
                                    <th>Is Active</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (is_array($items) && count($items) > 0) { ?>
                                <?php foreach ($items as $item) { ?>
                                    <tr>
                                        <td><?= $item['item'] ?></td>
                                        <td><?= $item['qty'] ?></td>
                                        <td><?= $item['req_qty'] ?></td>
                                        <td>
                                            <?php
                                                if($status == 'PENDING') {
                                                    if ($result[0]['code'] == CODE_REQUEST_TYPE_CHECK_IN) {
                                                        array_push($arrNewQty, $item['qty'] + $item['req_qty']);
                                                        echo $item['qty'] + $item['req_qty'];
                                                    } else {
                                                        array_push($arrNewQty, $item['qty'] - $item['req_qty']);
                                                        echo $item['qty'] - $item['req_qty'];
                                                    }
                                                } else {
                                                    echo '0';
                                                }
                                            ?>
                                        </td>
                                        <td><?= $item['code'] ?> - <?= $item['name'] ?></td>
                                        <td>
                                            <?php
                                            if ($item['is_active']) {
                                                echo "TRUE";
                                            } else {
                                                echo "FALSE";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Item</th>
                                    <th>In Stock</th>
                                    <th>Quantity</th>
                                    <th>New Quantity</th>
                                    <th>Category</th>
                                    <th>Is Active</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var formRequestApprove = document.getElementById('form-request-approve');
    var btnRequestApprove = document.getElementById('btn-request-approve');
    var btnRequestReject = document.getElementById('btn-request-reject');
    var arrNewQtyInput = document.getElementById('arrNewQty');

    btnRequestApprove.addEventListener('click', function() {
        arrNewQtyInput.value = JSON.stringify(<?php echo json_encode($arrNewQty); ?>);
        formRequestApprove.action = "<?= base_url('request/approve') ?>";
        formRequestApprove.submit();
    });

    btnRequestReject.addEventListener('click', function() {
        formRequestApprove.action = "<?= base_url('request/reject') ?>";
        formRequestApprove.submit();
    });
</script>