<?php echo '<form action="" method="post" accept-charset="utf-8">'; ?>
<?php echo '<input type="hidden" name="step" value="' . $current_step . '">'; ?>
<div class="form-group">
    <label for="hostname" class="control-label"><strong>Hostname</strong></label>
    <input type="text" class="form-control" name="hostname" value="localhost">
</div>
<div class="form-group">
    <label for="database" class="control-label"><strong>Database Name</strong></label>
    <input type="text" class="form-control" name="database">
</div>
<div class="form-group">
    <label for="username" class="control-label"><strong>Username</strong></label>
    <input type="text" class="form-control" name="username">
</div>
<div class="form-group">
    <label for="password" class="control-label"><strong>Password</strong> ( <small>Avoid use of single(&lsquo;) and double(&ldquo;) quotes in your password</small> )</label>
    <input type="password" class="form-control" name="password">
</div>
<hr class="-tw-mx-4" />
<div class="text-right">
    <button type="submit" class="btn btn-primary">Check Database</button>
</div>
</form>