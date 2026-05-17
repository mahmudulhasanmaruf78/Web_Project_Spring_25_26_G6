<?php
require_once '../Model/CategoryModel.php';

$model = new CategoryModel();

$data = $model->getCategories();
?>

<a href="AddCategory.php">Add Category</a>

<table border="1">

<tr>
<th>ID</th>
<th>Name</th>
<th>Action</th>
</tr>

<?php while($row=$data->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>

<td>

<a href="EditCategory.php?id=<?php echo $row['id']; ?>">
Edit
</a>

<a href="../Controller/CategoryController.php?delete=<?php echo $row['id']; ?>">
Delete
</a>

</td>

</tr>

<?php } ?>

</table>
