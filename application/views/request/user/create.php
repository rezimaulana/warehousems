<div class="container-fluid bg-light">
    <div class="row">
        <div class="col-md-10 offset-md-1">

        <?php echo '<h6 class="mb-2">'.$this->session->flashdata("success").'</h6>'; ?>
        <?php echo '<h6 class="mb-2">'.$this->session->flashdata("error").'</h6>'; ?>
        
            <div class="card mt-3">
                <div class="card-header"><?= $title; ?></div>
                <div class="card-body">

                    <form id="form-create-request" name="form-create-request" action="<?=base_url("request/insert")?>" method="post" class="row">
                        <div class="col-md-2 mt-1 mb-1">
                            <label for="request" class="form-label">Request Type<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-4 mt-1 mb-1">
                            <select name="request" id="request" class="form-select" required>
                                <option value="" selected="selected">Select option</option>
                                <?php
                                foreach ($request_types as $type) { ?>
                                    <option value="<?= $type['id'] ?>"><?= $type['code'] ?> - <?= $type['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="px-5">
                            <div class="card text-bg-light mt-2 mb-3 w-100">
                                <div class="card-body">

                                    <div class="row mb-2">
                                        <h6>*Minimum 1 Item</h6>
                                        <div class="col-md-1 mt-1 mb-1">
                                            <label for="item" class="form-label">Item</label>
                                        </div>
                                        <div class="col-md-4 mt-1 mb-1">
                                            <select name="item" id="item" class="form-select">
                                                <option value="" selected="selected">Select option</option>
                                                <?php
                                                foreach ($goods as $good) { ?>
                                                    <option value="<?= $good['id'] ?>"><?= $good['item'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mt-1 mb-1">
                                            <label for="qty" class="form-label">Quantity</label>
                                        </div>
                                        <div class="col-md-4 mt-1 mb-1">
                                            <input type="number" name="qty" id="qty" class="form-control">
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <button class="btn btn-secondary" type="button" id="btn-add-item">Add Item</button>
                                        </div>
                                    </div>
                                    
                                    <div id="items-container" class="text-center">
                                    </div>
                                    <input type="text" id="items" name="items" hidden/>



                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4 mb-1">
                            <button class="btn btn-primary" id="btn-create-request">Submit</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>


<script>
    var items = [];
    var itemsContainer = document.getElementById('items-container');
    var itemsInput = document.getElementById('items');

    document.addEventListener('DOMContentLoaded', function() {

        document.getElementById('btn-add-item').addEventListener('click', function() {
            // Get the selected item and quantity
            var itemId = document.getElementById('item').value;
            var itemQty = document.getElementById('qty').value;

            // Check if item or quantity is null
            if (itemId === '' || itemQty === '') {
                alert('Item and quantity must not be empty!');
                return; // Exit the function
            }

            // Check if an item with the same ID already exists in the array
            var existingItemIndex = items.findIndex(function(item) {
                return item.id === itemId;
            });

            if (existingItemIndex !== -1) {
                // Item already exists, update its quantity
                items[existingItemIndex].qty = parseInt(items[existingItemIndex].qty) + parseInt(itemQty);
            } else {
                // Item doesn't exist, create a new object representing the added item
                var newItem = {
                    id: itemId,
                    item: document.getElementById('item').selectedOptions[0].text,
                    qty: itemQty
                };

                // Add the item to the array
                items.push(newItem);
            }

            // Clear the input fields
            document.getElementById('item').selectedIndex = 0;
            document.getElementById('qty').value = '';

            // Call the function to update the displayed items
            updateItems();
        });

    
    });

    function updateItems() {
        // Clear the existing items
        itemsContainer.innerHTML = '';

        // Iterate over the items and create the HTML markup
        items.forEach(function(item) {
            var itemMarkup = `
                <button type="button" class="btn btn-secondary position-relative" disabled>
                    ${item.item}
                    <span class="badge text-bg-info">${item.qty}</span>
                    <span class="position-absolute top-0 end-0">
                        <button type="button" class="btn-close" aria-label="Close" onclick="removeItem('${item.id}')"></button>
                    </span>
                </button>
            `;

            // Append the item markup to the container
            itemsContainer.innerHTML += itemMarkup;
        });

        // Convert the items array to a JSON string and assign it to the hidden input field
        itemsInput.value = JSON.stringify(items);
    }
    function removeItem(itemId) {
        // Find the index of the item in the items array
        var itemIndex = items.findIndex(function(item) {
            return item.id === itemId;
        });

        // Remove the item from the array if found
        if (itemIndex !== -1) {
            items.splice(itemIndex, 1);

            // Call the function to update the displayed items
            updateItems();
        }
    }
</script>