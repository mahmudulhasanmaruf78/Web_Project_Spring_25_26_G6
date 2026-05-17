<?php
require_once '../Model/CategoryModel.php';

$model = new CategoryModel();

$id = $_GET['id'];

$data = $model->getCategoryById($id);

$row = $data->fetch_assoc();
?>

<form action="../Controller/CategoryController.php" method="POST">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<input type="text" name="name" value="<?php echo $row['name']; ?>">

<button type="submit" name="update">
Update
</button>

</form>
