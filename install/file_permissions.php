<?php
$error = false;

// UPLOADS
if (!is_writable('../uploads/')) {
    $error                 = true;
    $uploads = "<span class='label label-danger'>No (Make uploads writable) - Permissions 0755</span>";
} else {
    $uploads = "<span class='label label-success'>Ok</span>";
}

// CONFIG
// if (!is_writable('../install/_config_sample.php')) {
//     $error         = true;
//     $_config = "<span class='label label-danger'>No (Make install/_config_sample.php writable) - Permissions - 0644</span>";
// } else {
//     $_config = "<span class='label label-success'>Ok</span>";
// }

// CACHE
if (!is_writable('../cache/')) {
    $error        = true;
    $cache = "<span class='label label-danger'>No (Make cache writable) - Permissions 0755</span>";
} else {
    $cache = "<span class='label label-success'>Ok</span>";
}

?>
<table class="table table-hover tw-text-sm">
    <thead>
        <tr>
            <th><b>File/Folder</b></th>
            <th><b>Result</b></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="tw-font-medium">uploads</td>
            <td><?php echo $uploads; ?></td>
        </tr>
        <tr>
            <td class="tw-font-medium">cache</td>
            <td><?php echo $cache; ?></td>
        </tr>
        <!-- <tr>
            <td class="tw-font-medium">_config.php writable</td>
            <td><?php echo $_config; ?></td>
        </tr> -->
        
    </tbody>
</table>
<hr class="-tw-mx-4" />
<?php if ($error == true) {
    echo '<div class="text-center alert alert-danger tw-mb-0">You need to fix the requirements in order to install PHPTRAVELS</div>';
} else {
    echo '<div class="text-center">';
    echo '<form action="" method="post" accept-charset="utf-8">';
    echo '<input type="hidden" name="permissions_success" value="true">';
    echo '<div class="text-right">';
    echo '<button type="submit" class="btn btn-primary">Setup Database</button>';
    echo '</div>';
    echo '</form>';
    echo '</div>';
}