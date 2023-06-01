<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
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
                    <h2 class="text-start">ALL Categories</h1>
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">+
                        Add New Category</button>
                </div>
            </div>

            <div class="row" style="padding-top: 25px;">
                <div class="col">
                    <table class="table table-striped table-bordered border-dark">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col" colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="CategoryTableBody">
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
                                    echo<<<_END
                                    <tr>
                                      <th scope="row">$row[0]</th>
                                        <td>$row[1]</td>
                                        <th colspan="2">
                                         <div style="display: inline-flex;">
                                            <a href="#" class="edit-Category">Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;
                                            <form id="DelteForm" action="handleCategory.php" method="post">
                                                <input type="hidden" name="DeleteID" value="$row[0]">
                                                <button type="submit" class="text-danger" style="border:none;background:none;padding: 0px;" form="DelteForm">Delete</button>
                                            </form>
                                        </div>    
                                        </th>
                                    </tr>
_END;
                                }
                            ?>
                            <tr>
                              
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Category Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
            aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addCategoryForm" action="handleCategory.php" method="post">
                            <div class="form-group">
                                <input type="hidden" name="addNewCategory">
                                <label for="CategoryName">Category Name:</label>
                                <input type="text" class="form-control" id="CategoryName" name="CategoryName">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="addCategoryForm">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- edit Category Modal -->
        <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog"
            aria-labelledby="editCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editCategoryForm" action="handleCategory.php" method="post">
                            <div class="form-group">
                                <label for="editedCategoryName">Category Name:</label>
                                <input type="text" class="form-control" id="editedCategoryName"  name="CategoryName">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="editCategoryForm">Save</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
     $(document).on('click', '.edit-Category', function () {
        const row = $(this).closest('tr');
        const id = row.find('th').text();
         var fieldHTML = '<input type="hidden" name="editID" value="' + id + '"/>';
        // var inputElement = $('<input>', {
        //     type: 'hidden',
        //     name: 'editID',
        //     value: id
        // });
        const name = row.find('td').text();
        $('#editedCategoryName').val(name);
        $('#editedCategoryName').append(fieldHTML);
        
        $('#editCategoryModal').modal('show');
    });
</script>
</body>

</html>