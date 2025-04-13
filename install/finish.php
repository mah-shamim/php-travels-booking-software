<h4 class="bold text-success">🎉 Installation successful!</h4>

<?php if (isset($config_copy_failed)) { ?>
<p class="text-danger">
    Failed to copy _config.php. Please navigate to install/_config.php
    and copy the file _config.php and save it to public_html _config.php.
</p>
<?php } ?>

<!-- <p>
    <b>Delete the install directory</b> at <a href="<?php echo $_POST['base_url']; ?>install"
        target="_blank"><?php echo $_POST['base_url']; ?>install</a>
</p> -->

<hr />

<h4><b style="color:red;">Remember</b></h4>

<ul class="list-unstyled">
    <li><strong>Admin URL </strong> <a href="<?php echo $_POST['base_url']; ?>admin" target="_blank"><?php echo $_POST['base_url']; ?>admin</a></li>
    <li><strong>Admin Email</strong> <?=$_POST['admin_email']?></li>
    <li><strong>Admin Pass</strong>  <?=$_POST['admin_passwordr']?></li>
    <li><hr style="margin: 8px 0px;" /></li>
    <li><strong>Website URL</strong> <a href="<?php echo $_POST['base_url']; ?>" target="_blank"><?php echo $_POST['base_url']; ?></a></li>
</ul>

<hr style="margin: 8px 0px;" />

<ul class="list-unstyled">
    <li><strong>Sitemap URL</strong> <a href="<?php echo $_POST['base_url']; ?>sitemap.xml" target="_blank"><?php echo $_POST['base_url']; ?>sitemap.xml</a></li>
</ul>

<hr style="margin: 8px 0px;" />

<h5><b>Documentation - <a href="https://docs.phptravels.com/" target="_blank"> <small><strong>Read More</strong></small> </a></b></h5>
<h5> <b>Looking For Help? - <a href="https://link.phptravels.com/support" target="_blank"> <small><strong>Join Discord Group</strong></small> </a></b>
</h5>

<!-- ANIMATION LIBRARY -->
<script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.9.3/tsparticles.confetti.bundle.min.js"></script>
<script>
const count=200,defaults={origin:{y:.7}};function fire(e,t){confetti(Object.assign({},defaults,t,{particleCount:Math.floor(count*e)}))}fire(.25,{spread:26,startVelocity:55}),fire(.2,{spread:60}),fire(.35,{spread:100,decay:.91,scalar:.8}),fire(.1,{spread:120,startVelocity:25,decay:.92,scalar:1.2}),fire(.1,{spread:120,startVelocity:45});
</script>