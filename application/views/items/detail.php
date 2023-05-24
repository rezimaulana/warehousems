<div class="container-fluid">

    <div class="row g-1">
        <div class="col-md-10 offset-md-1">
            <div class="card mt-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><?= $title; ?></h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="<?= base_url('items') ?>" class="btn btn-secondary">Back to List</a>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Info :
                        <span class="badge text-bg-secondary">Code : <?= $goods[0]['code']; ?></span>
                        <span class="badge text-bg-secondary">Category : <?= $goods[0]['name']; ?></span>
                        <span class="badge text-bg-secondary">Data Version : <?= $goods[0]['ver']; ?></span>
                    </li>
                </ul>
                <div class="card-body">
                    <h6 class="card-title">ID : <?= $goods[0]['id'] ?></h6>
                    <p class="card-text">
                        Item : <?= $goods[0]['item']; ?><br>
                        Quantity : <?= $goods[0]['qty']; ?>
                    </p>
                </div>
                <div class="card-footer">
                    <?php if($goods[0]['updated_at'] == '0000-00-00 00:00:00') { ?>
                        <small class="text-muted">Created at <?= $goods[0]['created_at']; ?></small> 
                    <?php } else { ?>   
                        <small class="text-muted">Last update at <?= $goods[0]['updated_at']; ?></small>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 offset-md-1 mt-3">
            <div class="card">
                <div class="card-header">
                    <h5>Approved Request</h5>
                </div>
                <div class="card-body">

                    <div class="row">
                        <table id="table1" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Transaction Code</th>
                                    <th>Request Type</th>
                                    <th>Quantity</th>
                                    <th>Aprroval Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (is_array($result) && count($result) > 0) { ?>
                                <?php foreach ($result as $item) { ?>
                                    <tr>
                                        <td><?= $item['trx_code'] ?></td>
                                        <td><?= $item['name'] ?></td>
                                        <td><?= $item['qty'] ?></td>
                                        <td><?= $item['updated_at'] ?></td>
                                    </tr>
                                <?php } } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Transaction Code</th>
                                    <th>Request Type</th>
                                    <th>Quantity</th>
                                    <th>Aprroval Date</th>
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