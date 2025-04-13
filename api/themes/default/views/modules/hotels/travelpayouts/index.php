<div class="iframe-container">
  <iframe src="<?=$WidgetURL?>" allowfullscreen></iframe>
</div>

<style>
.iframe-container {
  overflow: hidden;
  // Calculated from the aspect ration of the content (in case of 16:9 it is 9/16= 0.5625)
  padding-top: 56.25%;
}

.iframe-container iframe {
   border: 0;
   height: 100%;
   left: 0;
   position: absolute;
   top: 0;
   width: 100%;
   margin-top: 96px;
}
.iframe-container{height:100vh}
 html{overflow: hidden;}

</style>