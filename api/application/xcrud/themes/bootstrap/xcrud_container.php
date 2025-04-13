<div class="xcrud<?php echo $this->is_rtl ? ' xcrud_rtl' : ''?>">
<?php echo $this->render_table_name(false, 'div', true)?>
<div class="xcrud-container"<?php echo ($this->start_minimized) ? ' style="display:none;"' : '' ?>>
<div class="xcrud-ajax">
<?php echo $this->render_view() ?>
</div>
<div class="xcrud-overlay">
<div class="matrialprogress" style="margin-top: 54px; position: absolute;">
<div class="indeterminate"></div>
</div>
</div>
</div>
</div>