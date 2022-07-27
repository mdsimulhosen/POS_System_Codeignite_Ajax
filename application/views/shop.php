<!DOCTYPE html>
<html lang="en">

<head>
  <title>SELL</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap link  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">



</head>

<body>
  <a href="<?= base_url('index.php/Pos') ?>" class="btn btn-dark mt-5 ms-5">Go to Stock Page</a>
  <h3 class="text-center fw-bold">SELL</h3>


  <!-- Add Modal Button  -->
  <button type="button" id="addProduct" class="btn btn-primary border-0 float-end m-2 me-5">Add Sell</button>
  <!-- product table  -->
  <table class="table table-hover table-bordered mt-4 text-center">
    <thead>
      <th>Customer Name</th>
      <th class="bg-light">Address</th>
      <th class="bg-light">Supplier</th>
      <th>Product Name</th>
      <th class="bg-light">Single Price</th>
      <th>Quantity</th>
      <th class="bg-light">Total</th>
      <th>Action</th>
    </thead>
    <tbody>
      <?php foreach ($sells as $sell) { ?>
        <tr>
          <td><?= $sell->customer_name ?></td>
          <td class="bg-light"><?= $sell->address ?></td>
          <td class="bg-light"><?= $sell->supplier_name ?></td>
          <td><?= $sell->product_name ?></td>
          <td class="bg-light"><?= $sell->sell_price ?></td>
          <td><?= $sell->sell_quantity ?></td>
          <td class="bg-light">
            <?php
            $price = $sell->sell_price;
            $sell_quantity = $sell->sell_quantity;
            $total = $price * $sell_quantity;
            echo $total;
            ?>
          </td>
          <td>
            <button type="button" class="btn btn-primary me-3 px-3" id="editbtn" onclick="editModal('<?= $sell->sell_id; ?>')">Edit</button>
            <button type="button" class="btn btn-danger" id="deletebtn" onclick="delete_data('<?= $sell->sell_id; ?>')">Delete</button>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>


  <!--Add Product Modal -->
  <div class="modal fade" id="addSellModal" tabindex="-1" aria-labelledby="addSellModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="item-title" id="addSellModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addSell" name="addSell">
            <input type="hidden" name="sell_id" id="sell_id" value="0">
            <div class="mb-3">
              <label for="" class="form-label">Customer</label>
              <select class="form-select" name="customer_id" id="customer_id">
                <option value="">Select Customer</option>
                <?php
                foreach ($customer as $row) { ?>
                  <option value="<?= $row->customer_id; ?>"><?= $row->customer_name; ?></option>
                <?php }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Product</label>
              <select class="form-select" name="product_id" id="product_id">
                <option value="">Select Product</option>
                <?php
                foreach ($stock_product as $row) { ?>
                  <option value="<?= $row->product_id; ?>"><?= $row->product_name; ?></option>
                <?php }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Quantity</label>
              <input type="text" name="sell_quantity" id="sell_quantity" class="form-control sell_quantity">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="submit" onclick="insert_sell()"></button>
        </div>
      </div>
    </div>
  </div>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <script>
    $("#addProduct").click(function() {
      $("#addSellModal").modal("show");
      $(".item-title").html("Add Sell");
      $("#submit").html("Save");
      erase_data();
    });

    function insert_sell() {
      $("#addSellModal").modal("hide");
      var sell_id = $("#sell_id").val();
      var customer_id = $("#customer_id").val();
      var product_id = $("#product_id").val();
      var price = $("#price").val();
      var sell_quantity = $("#sell_quantity").val();

      if (sell_id == 0) {
        $.ajax({
          url: "<?php echo base_url("index.php/Pos/insert_sell") ?>",
          type: "POST",
          dataType: "json",
          data: {
            customer_id: customer_id,
            product_id: product_id,
            sell_quantity: sell_quantity,
          },
          success: function(response) {
            return response;
            erase_data();
          }
        });
      }
      if (sell_id > 0) {
        $.ajax({
          url: "<?php echo base_url("index.php/Pos/update_sell/") ?>" + sell_id,
          type: "POST",
          data: {
            sell_id: sell_id,
            customer_id: customer_id,
            product_id: product_id,
            sell_quantity: sell_quantity,
          },
          dataType: "json",
          success: function(response) {
            return response;
          }
        });
      }
    }

    // Show informatin in editModal 
    function editModal(sell_id) {
      $("#addSellModal").modal("show");
      $(".item-title").html("Update Sell");
      $("#submit").html("Update");

      $.ajax({
        url: "<?php echo base_url("index.php/Pos/edit_sell/") ?>" + sell_id,
        type: "POST",
        dataType: "json",
        data: {
          sell_id: sell_id
        },
        success: function(data) {
          $("#sell_id").val(data.sell_id);
          $("#customer_id").val(data.customer_id);
          $("#product_id").val(data.product_id);
          $("#sell_quantity").val(data.sell_quantity);
        }
      });
    }

    // Delete data from product & stock table 
    function delete_data(sell_id) {
      $.ajax({
        url: "<?php echo base_url("index.php/Pos/delete_sell/") ?>" + sell_id,
        type: "post",
        data: {
          sell_id: sell_id
        }
      });
    }

    function erase_data() {
      $("#customer_id").val('');
      $("#product_id").val('');
      $("#sell_quantity").val('');
    }
  </script>
</body>

</html>