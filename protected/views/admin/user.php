<?php
/**
 * @var integer $userId
 */
$profile = Profile::search('userid', $userId);
$user = UserHelper::getUserById($userId);
$types = UserHelper::getTypes();
?>
<div id="leftColumn">
    <div id="userInfo" class="containerDiv">
        <h3><?=$profile['name']; ?></h3>
        <p>
            <b>Type:</b> <?=$types[$user->type]; ?><br />
            <b>Alias:</b> <?=$profile['alias']; ?><br />
            <b>Email/Username:</b> <?=$profile['email']; ?><br />
            <b>Address:</b> <?=$profile['address'] . ', ' . $profile['city'] . ', ' . $profile['state'] . ' ' . $profile['zip'] . ' ' . $profile['country']; ?><br />
            <b>Phone:</b> <?=$profile['phone']; ?><br />
            <b>Age:</b> <?=$profile['age']; ?><br />
            <b>Forum Id:</b> <?=$profile['teahouseid']; ?><br />
            <b>Unavailable:</b> <?=$profile['unavailable']; ?><br />
        </p>
    </div>
    <div id="userSchedule" class="containerDiv">
        <h3>Schedule</h3>
    <?php
    $this->widget('application.widgets.PanelistSchedule', ['user' => $user]);
    ?>
    </div>
</div>
<div id="rightColumn">
<?php
$this->widget('application.widgets.ConfirmedPanels', ['user' => $user, 'admin' => TRUE]);
$this->widget('application.widgets.RegisteredPanels', ['user' => $user, 'admin' => TRUE]);
$this->widget('application.widgets.DeleteUser', ['userId' => $user->id]);
?>
</div>
<script>
function deleteUser(userId) {
        $.ajax({
            type: "POST",
            url:    "<?php echo Yii::app()->createUrl('admin/deleteUser'); ?>",
            data:  {
                userid: userId,
            },
            success: function(msg){
                window.location = '<?=Yii::app()->createUrl('/'); ?>';
            },
            error: function(xhr){
                alert("Unable to delete user");
            }
        });
        return false;
    }
</script>