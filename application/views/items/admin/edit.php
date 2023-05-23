<div class="container-fluid bg-light">
    <div class="row g-1">
        <div class="col-md-10 offset-md-1 mt-3 mb-4">
            <div class="card">
                <div class="card-header"><?=$title;?></div>
                <div class="card-body">
                    <a href="<?=base_url('items/');?>" class="btn btn-secondary mb-4">Back to List</a>
                    <form id="form-create-items" name="form-create-items" action="<?=base_url("items/update")?>" method="post" class="row">
                        <input type="text" name="id" id="id" value="<?=$result[0]['id'];?>" hidden/>
                        <input type="text" name="ver" id="ver" value="<?=$result[0]['ver'];?>" hidden/>
                        <div class="col-md-1 mt-1 mb-1">
                            <label for="item" class="form-label">Item<span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5 mt-1 mb-1">
                            <input type="text" name="item" id="item" class="form-control" value="<?=$result[0]['item'];?>" required>
                        </div>
                        <div class="col-md-1 mt-1 mb-1">
                            <label for="category" class="form-label">Category<span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-5 mt-1 mb-1">
                            <select name="category" id="category" class="form-select" required>
                                <option value="" selected="selected">Select option</option>
                                <?php 
                                    foreach  ($categories as $category) { 
                                        $selected = ($category['id'] == $result[0]['goods_category_id']) ? 'selected=selected' : '';?>
                                        <option value="<?=$category['id']?>" <?= $selected; ?>><?=$category['name']?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-md-12 mt-4 mb-1">
                            <button class="btn btn-primary" id="btn-create-item">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>