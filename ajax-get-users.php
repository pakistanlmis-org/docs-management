<?php
require_once 'classes/users.php';
$users = new users();
$id = $_POST['id'];
$user = $users->find_by_department($id);
while ($rowd = $user->fetch_array()) {
    ?>
    <option value="<?php echo $rowd['pk_id']; ?>"><?php echo $rowd['username']; ?></option>
    <?php
}