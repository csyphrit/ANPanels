<?php
class DeleteUser extends CWidget {
    public $userId = NULL;
    
    public function run() {
        echo '<div id="deleteUser" class="containerDiv">';

        echo '<h3>Delete User</h3>';
        echo '<button name="deleteSubmit" onclick="deleteUser(' . $this->userId . ');">Delete User</button>';
        echo '</div>';
    }
}
?>