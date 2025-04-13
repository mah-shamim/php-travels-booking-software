   <!-- Bootstrap core -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap core -->

    <!-- Modal -->
     <div class="modal-dialog modal-lg ptb">
       <div class="modal-content">
        <div class="pd25">
         <div align="center"><img class="img-responsive" src="<?php echo base_url();?>assets/images/success.jpg" alt="" /></div>
         <h3 class="text-center"><strong><?php echo trans('0349');?></strong></h3>
          <h5 class="text-center"><strong><?php echo trans('0163');?>.</strong></h5>
           <p class="text-center"> <?php echo trans('0162');?></p>
           <br>
          <center><a href="<?php echo base_url();?>invoice?id=<?php echo $bookingid;?>&sessid=<?php echo $refno;?>"><button class="btn btn-primary"> <?php echo trans('0160');?></button></a>
         <a href="<?php echo base_url();?>"><button class="btn btn-success"> <?php echo trans('0161');?></button></a></center>
       </div>
      </div>
     </div>

     <style>
    ::selection                     { background: #a8d1ff;                                   }
    ::-moz-selection                { background: #a8d1ff;                                   }
    ::-webkit-scrollbar             { width: 10px;                                           }
    ::-webkit-scrollbar-track       { background-color: #eaeaea; border-left: 1px solid #ccc;}
    ::-webkit-scrollbar-thumb       { background-color: #888888;                             }
    ::-webkit-scrollbar-thumb:hover { background-color: #636363;                             }

     body { background-color: #eaeaea !important; }
    .modal-content { box-shadow: 0px 0px 0px 0px !important; }
    .pd25 { padding:25px; }
    .ptb { padding: 75px 0px 75px 0px; }

    </style>
