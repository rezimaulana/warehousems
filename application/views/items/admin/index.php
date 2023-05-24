<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <h3><a class="btn btn-primary pull-right" style="margin-bottom: 10px" href="<?= base_url('items/create'); ?>">Create Entry</a></h3>
            <?php echo '<h4 class="mb-2">'.$this->session->flashdata("success").'</h4>'; ?>
            <?php echo '<h4 class="mb-2">'.$this->session->flashdata("error").'</h4>'; ?>
            <div class="mb-4">
                <label for="category_filter" class="form-label">Filter by Category:</label>
                <select id="category_filter" class="form-select">
                    <option value="">All Categories</option>
                    <?php if (is_array($categories) && count($categories) > 0) { ?>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php } } ?>
                </select>
            </div>
            <table id="table1" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Category ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($result) && count($result) > 0) { ?>
                    <?php foreach($result as $res) {?>
                        <tr>
                            <td><?= $res['item'] ?></td>
                            <td><?= $res['qty'] ?></td>
                            <td><?= $res['name'] ?></td>
                            <td><?= $res['goods_category_id'] ?></td>
                            <td>
                                <a class="btn btn-success btn-sm" href="<?= base_url('items/detail/').$res['id'] ?>">Detail</a>
                                <a class="btn btn-warning btn-sm" href="<?= base_url('items/edit/').$res['id'] ?>">Edit</a>
                                <a class="btn btn-danger btn-sm" onclick="return confirm('Delete entry?')" href="<?= base_url('items/delete/').$res['id'].'/'.$res['ver'] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Category ID</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>