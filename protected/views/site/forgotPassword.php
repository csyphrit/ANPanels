Enter your email address below and a new password will be sent to your account.
<p>
<?php
echo CHtml::textField('email');
echo CHtml::button('Reset Password', array('onclick' => 'resetPassword();'));
?>
</p>
<script>
    function resetPassword() {
        $.ajax({
            type: "POST",
            url:    "<?php echo Yii::app()->createUrl('site/resetPassword'); ?>",
            data:  {
                email: $('#email').val(),
            },
            success: function(msg){
                alert("A new password has been sent.");
            },
            error: function(xhr){
                alert("Unable to locate email address.");
            }
        });
        return false;
    }
</script>