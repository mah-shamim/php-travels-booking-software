<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" id="fadein" data-bs-toggle="modal" data-bs-target="#dev" style="position: fixed; bottom: 12px; left: 0; z-index: 9999; margin: 14px;">
<i class="la la-flask"></i> Dev Mode
</button>

<!-- Modal -->
<div class="modal fade modal-dialog-scrollable" id="dev" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="la la-flask"></i> Dev Mode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            <div class="d-flex text-muted">
            <p class="py-2 mb-0 small lh-sm border-bottom"><strong>PHP INI</strong> <?=php_ini_loaded_file()?></p>
            </div>

            <div class="d-flex text-muted">
            <p class="py-2 mb-0 small lh-sm border-bottom"><strong>PHP Version</strong> <?=phpversion()?></p>
            </div>

            <div class="d-flex text-muted">
            <p class="py-2 mb-0 small lh-sm border-bottom"><?php $file = "app/core.php"; if(is_writable($file)) { echo ("<span class='text-success'><strong>$file</strong> file is writable!</span>"); } else { echo ("<span class='text-danger'><strong>$file</strong> file is not writable!</span>"); } ?></p>
            </div>

            <div class="d-flex text-muted">
            <p class="py-2 mb-0 small lh-sm border-bottom"><?php $file = "app/logs"; if(is_writable($file)) { echo ("<span class='text-success'><strong>$file</strong> folder is writable!"); } else { echo ("<span class='text-danger'><strong>$file</strong> folder is not writable!</span>"); } ?></p>
            </div>

            <div class="d-flex text-muted">
            <p class="py-2 mb-0 small lh-sm border-bottom"><?php $file = "app/cache"; if(is_writable($file)) { echo ("<span class='text-success'><strong>$file</strong> folder is writable!</span>"); } else { echo ("<span class='text-danger'><strong>$file</strong> folder is not writable!</span>"); } ?></p>
            </div>

            <div class="d-flex text-muted">
            <p class="py-2 mb-0 small lh-sm border-bottom"><?php if( ini_get('allow_url_fopen') ) { echo ("<span class='text-success'><strong>Perfect</strong> allow_url_fopen is enabled!</span>"); } else { echo ("<span class='text-danger'><strong>Damn</strong> allow_url_fopen is not enabled!</span>"); } ?></p>
            </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>