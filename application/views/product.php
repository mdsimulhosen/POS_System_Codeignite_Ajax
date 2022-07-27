<!DOCTYPE html>
<html lang="en">

<head>
    <title>STOCK PRODUCTS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap link  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>


</head>

<body>

    <div class="container-fluid">
        <a href="<?= base_url('Pos/shop') ?>" class="btn btn-dark px-5 mt-5 ms-5">View Sales Page</a>
        <h3 class="text-center fw-bold">STOCK PRODUCTS</h3>


        <!-- Add Modal Button  -->
        <button type="button" id="addProduct" class="btn btn-primary border-0 float-end m-2 me-5">Add Product</button>
        <!-- product table  -->
        <table class="table table-hover table-bordered mt-4 text-center">
            <thead>
                <th>Supplier</th>
                <th>Product Name</th>
                <th>Buy Price</th>
                <th>Sell Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php foreach ($stock as $product) { ?>
                    <tr>
                        <td><?= $product->supplier_name ?></td>
                        <td><?= $product->product_name ?></td>
                        <td><?= $product->buy_price ?></td>
                        <td><?= $product->sell_price ?></td>
                        <td><?= $product->quantity ?></td>
                        <td>
                            <button type="button" class="btn btn-primary me-3 px-3" id="editbtn" onclick="editModal('<?= $product->stock_id; ?>')">Edit</button>
                            <button type="button" class="btn btn-danger" id="deletebtn" onclick="delete_data('<?= $product->stock_id; ?>')">Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>




        <!--Add Stock Modal -->
        <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="item-title" id="addStockModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addStock" name="addStock">
                            <input type="hidden" name="stock_id" id="stock_id" value="0">
                            <div class="mb-3">
                                <label for="" class="form-label">Supplier</label>
                                <select class="form-select" name="supplier_id" id="supplier_id">
                                    <option value="">Select Supplier</option>
                                    <?php
                                    foreach ($rows as $row) { ?>
                                        <option value="<?= $row->supplier_id; ?>"><?= $row->supplier_name; ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Product Name</label>
                                <!-- <input type="text" name="product_name" id="product_name" class="form-control" value=""> -->
                                <select class="form-select" name="product_id" id="product_id">
                                    <option value="">Select Product</option>
                                    <?php
                                    foreach ($product_list as $row) { ?>
                                        <option value="<?= $row->product_id; ?>"><?= $row->product_name; ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Quantity</label>
                                <input type="text" name="quantity" id="quantity" class="form-control quantity">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submit" onchange="" onclick="insert_update()"></button>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        $("#addProduct").click(function() {
            $("#addStockModal").modal("show");
            $(".item-title").html("Add Product");
            $("#submit").html("Save");
            erase_data();
        });


        // Add & Update function 
        function insert_update() {
            $("#addStockModal").modal("hide");
            var stock_id = $("#stock_id").val();
            var supplier_id = $("#supplier_id").val();
            var product_id = $("#product_id").val();
            var quantity = $("#quantity").val();

            if (stock_id == 0) {
                $.ajax({
                    url: "<?php echo base_url("Pos/add_stock") ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        stock_id: stock_id,
                        supplier_id: supplier_id,
                        product_id: product_id,
                        quantity: quantity,
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }

            // Update Condition 
            if (stock_id > 0) {
                $.ajax({
                    url: "<?php echo base_url("Pos/update_stock/") ?>" + stock_id,
                    type: "POST",
                    dataType: "json",
                    data: {
                        stock_id: stock_id,
                        supplier_id: supplier_id,
                        product_id: product_id,
                        quantity: quantity,
                    },
                    success: function(response) {
                        window.location.reload();

                    }
                });
            }
        }

        // Show informatin in editModal 
        function editModal(stock_id) {
            $("#addStockModal").modal("show");
            $(".item-title").html("Update Product");
            $("#submit").html("Update");

            $.ajax({
                url: "<?php echo base_url("Pos/edit_stock/") ?>" + stock_id,
                type: "POST",
                dataType: "json",
                data: {
                    stock_id: stock_id
                },
                success: function(data) {
                    $("#stock_id").val(data.stock_id);
                    $("#supplier_id").val(data.supplier_id);
                    $("#product_id").val(data.product_id);
                    $("#quantity").val(data.quantity);
                }
            });
        }

        // Delete data from product & stock table 
        function delete_data(stock_id) {
            $.ajax({
                url: "<?php echo base_url("Pos/delete_stock/") ?>" + stock_id,
                type: "post",
                data: {
                    stock_id: stock_id
                }
            });
        }

        function erase_data() {
            $("#product_id").val('');
            $("#supplier_id").val('');
            $("#quantity").val('');
        }
    </script>

</body>

</html>