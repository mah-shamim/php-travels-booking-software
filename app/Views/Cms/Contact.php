<div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <!-- <div class="panel-heading"><?=T::contact?></div> -->
                <div class="d-flex align-items-center">
                    <div class="p-3">
                       
                        <div class="boxeds">
                            <span class="df aic gap05">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/></svg>
                            <strong><?=T::address?></strong>
                            </span>
                            <p><?=(base()->app->address)?></p>
                        </div>

                         <div class="boxeds">
                            <span class="df aic gap05"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <strong><?=T::email?></strong>
                            </span>
                            <p><?=(base()->app->contact_email)?></p>
                        </div>
                        <!-- <div class="boxeds">
                            <span class="df aic gap05"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <strong>Whatsapp</strong>
                            </span>
                            <p>+923311442244</p>
                        </div> -->
                        <div class="boxeds">
                            <span class="df aic gap05"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <strong><?=T::phone?></strong>
                            </span>
                            <p><?=(base()->app->contact_phone)?></p>
                        </div>
                        <!--+92 340 022 2255 -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div style="width:100%;overflow:hidden;height:375px;max-width:100%;">
                <div id="google-maps-canvas" style="height:100%; width:100%;max-width:100%;">

                <iframe src="<?=(base()->app->map_address)?>" width="800" height="600" frameborder="0" style="border:0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                <style>#google-maps-canvas .map-generator{max-width: 100%; max-height: 100%; background: none;}</style>
            </div>
        </div>
    </div>
</div>
