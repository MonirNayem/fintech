<?php
if(isset($_SESSION['status']))
{
    ?>
    <div class="alert alert-warning alert-dismissable fade show" role="atert">
        <strong>Hey! </strong><?php echo $_SESSION['status']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
    <?php
    unset($_SESSION['status']);
}

?>