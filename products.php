<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="sidebar">
        <h4>Admin Dashboard</h4>
        <hr>
        <a href="index.php">Dashboard</a>
        <a href="categories.php">Categories</a>
        <a href="products.php">Products</a>
    </div>
    <div class="content">
        <div class="container text-center">
            
            <div class="row">
                <div class="col-9">
                    <h2 class="text-start">ALL Products</h1>
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">+
                        Add New product</button>
                </div>
            </div>

            <div class="row" style="padding-top: 25px;">
                <div class="col">
                    <table class="table table-striped table-bordered border-dark">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Category</th>
                                <th scope="col" colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productTableBody">
                        <?php
                                require_once 'login.php';
                                $conn = new mysqli($hn, $un, $pw, $db);
                                if ($conn->connect_error) die($conn->connect_error);
                                // $query = "SELECT * FROM products";
                              $query =  "SELECT p.id, p.name AS product_name, c.name AS category_name FROM products p JOIN categories c ON p.categories_id = c.id";
                                $result = $conn->query($query);
                                if (!$result) die ("Database access failed: " . $conn->error);
                                $rows = $result->num_rows;
                                for ($j = 0 ; $j < $rows ; ++$j)
                                {
                                    $result->data_seek($j);
                                    $row = $result->fetch_array(MYSQLI_NUM);
                                    echo<<<_END
                                    <tr>
                                      <th scope="row">$row[0]</th>
                                        <td>$row[1]</td>
                                        <td>$row[2]</td>
                                        <th colspan="2">
                                         <div style="display: inline-flex;">
                                            <a href="#" class="edit-product">Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="handleProduct.php?row_id=$row[0]&ac=delete" class="text-danger">Delete</a>
                                        </div>    
                                        </th>
                                    </tr>
_END;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

         <!-- Add Product Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addProductForm" action="handleProduct.php" method="post">

                            <div class="form-group">
                                <label for="productName">Product Name:</label>
                                <input type="text" class="form-control" id="productName" name="productName">
                            </div>
                            <div class="form-group">
                                <label for="productCategory">Category:</label>
                                <select class="form-control" id="productCategory" name="productCategory">
                                    <option value="">Select category</option>
                                    <?php
                                    require_once 'login.php';
                                    $conn = new mysqli($hn, $un, $pw, $db);
                                    if ($conn->connect_error) die($conn->connect_error);
                                    $query = "SELECT * FROM categories";
                                    $result = $conn->query($query);
                                    if (!$result) die ("Database access failed: " . $conn->error);
                                    $rows = $result->num_rows;
                                    for ($j = 0 ; $j < $rows ; ++$j)
                                    {
                                        $result->data_seek($j);
                                        $row = $result->fetch_array(MYSQLI_NUM);
                                        echo "<option value=".$row[0].">".$row[1]."</option>";
                                    }
                                ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="addProductForm">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- edit Product Modal -->
        <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog"
            aria-labelledby="editProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <form id="editProductForm" action="handleProduct.php" method="post">
                            <div class="form-group">
                                <label for="editedProductName">Product Name:</label>
                                <input type="text" class="form-control" id="editedProductName" name="editedProductName">
                            </div>
                            <div class="form-group">
                                <label for="editedProductCategory">Category:</label>
                                <select class="form-control" id="editedProductCategory" name="editedProductCategory">
                                    <option value="">Select category</option>
                                        <?php
                                    require_once 'login.php';
                                    $conn = new mysqli($hn, $un, $pw, $db);
                                    if ($conn->connect_error) die($conn->connect_error);
                                    $query = "SELECT * FROM categories";
                                    $result = $conn->query($query);
                                    if (!$result) die ("Database access failed: " . $conn->error);
                                    $rows = $result->num_rows;
                                    for ($j = 0 ; $j < $rows ; ++$j)
                                    {
                                        $result->data_seek($j);
                                        $row = $result->fetch_array(MYSQLI_NUM);
                                        echo "<option value=".$row[0].">".$row[1]."</option>";
                                    }
                                ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="editProductForm">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>

        // Edit product functionality
        $(document).on('click', '.edit-product', function () {
            const row = $(this).closest('tr');
            const id = row.find('th').text();
            const name = row.find('td:nth-child(2)').text();
            const categortyname = row.find('td:nth-child(3)').text();
            var fieldHTML = '<input type="hidden" name="editID" value="' + id + '"/>';
            $('#editedProductName').append(fieldHTML);
            $('#editedProductName').val(name);
            // $('#editedProductCategory').val(category);
            // var option = $('#editedProductCategory').find('option[value="' + id + '"]');
            // option.prop('selected', true);
            $("#editedProductCategory option:contains('"+categortyname+"')").prop("selected", true);
            
            $('#editProductModal').modal('show');
        });

    </script>
</body>

</html>