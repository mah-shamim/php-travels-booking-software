<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getPaginationEan'))
{

function getPaginationEan($urlink,$count, $perpage, $currentpage = null){
      $paginationCount= floor($count / $perpage);
      $paginationModCount= $count % $perpage;
      if(!empty($_GET)){

      $url = $urlink."/".$currentpage."?".http_build_query($_GET);

      }else{

      $url = $urlink."/".$currentpage;

      }

      if(!empty($paginationModCount)){
               $paginationCount++;
      }
      $html = array();
      $html['total'] = $paginationCount;
      $html['pages'] = '';
      if($html['total'] > 0){

   /* if($paginationCount > 10){
      $midrange = 9;
       $start_range = $currentpage - floor($midrange/2);
       $end_range = $currentpage + floor($midrange/2);

            if($start_range <= 0)
            {
                $end_range += abs($start_range)+1;
                $start_range = 1;
            }
            if($end_range > $paginationCount)
            {
                $start_range -= $end_range - $paginationCount;
                $end_range = $paginationCount;
            }

          $range = range($start_range,$end_range);
    $html['pages'] .='<ul class="pagination">
    <li class="first link" id="1">
        <a  href="'.$url.'" >First</a>
    </li>';
   for($i=1;$i<=$paginationCount;$i++){
                 if(!empty($_GET)){

      $url = $urlink."/".$i."?".http_build_query($_GET);

      }else{

      $url = $urlink."/".$i;

      }

               if($range[0] > 2 And $i == $range[0]) $html['pages'] .= '<li><a href="javascript:void(0)">...</a> </li>';
                // loop through all pages. if first, last, or in range, display
                if($i==1 Or $i==$paginationCount Or in_array($i,$range))
                {
                    $html['pages'] .= ($i == $currentpage) ? '<li id="li_'.$i.'" class="litem active">
          <a  href="javascript:void(0)" >
              '.($i).'
          </a>
    </li>' : '<li id="li_'.$i.'" class="litem">
          <a  href="'.$url.'">
              '.($i).'
          </a>
    </li>';
               }

          if($range[$midrange-1] < $paginationCount-1 And $i == $range[$midrange-1])  $html['pages'] .= '<li><a href="javascript:void(0)">...</a> </li>';




    } if($currentpage < $paginationCount){
      $nextpage = $currentpage + 1;
       if(!empty($_GET)){

      $url = $urlink."/".$nextpage."?".http_build_query($_GET);

      }else{

      $url = $urlink."/".$nextpage;

      }

                        if(!empty($_GET)){

      $lasturl = $urlink."/".$paginationCount."?".http_build_query($_GET);

      }else{

      $lasturl = $urlink."/".$paginationCount;

      }


        $html['pages'] .='<li class="next" id="'.$paginationCount.'">
         <a href="'.$url.'">Next</a>
    </li>';


     $html['pages'] .='<li class="last" id="'.$paginationCount.'">
         <a href="'.$lasturl.'">Last</a>
    </li></ul>';
     }

    }else{

   $html['pages'] .='<ul class="pagination">';
   if($currentpage != 1){
   $html['pages'] .= '<li class="first link" id="1">
        <a  href="$urlink">First</a>
    </li>';

   }
   for($i=1;$i<=$paginationCount;$i++){
             if(!empty($_GET)){

      $url = $urlink."/".$i."?".http_build_query($_GET);

      }else{

      $url = $urlink."/".$i;

      }
                       $html['pages'] .= ($i == $currentpage) ? '<li id="li_'.$i.'" class="litem active">
          <a  href="javascript:void(0)" >
              '.($i).'
          </a>
    </li>' : '<li id="li_'.$i.'" class="litem">
          <a  href="'.$url.'" >
              '.($i).'
          </a>
    </li>';



    }

  if($currentpage < $paginationCount){
    $nextpage = $currentpage + 1;
                  if(!empty($_GET)){

      $url = $urlink."/".$nextpage."?".http_build_query($_GET);

      }else{

      $url = $urlink."/".$nextpage;

      }

                        if(!empty($_GET)){

      $lasturl = $urlink."/".$paginationCount."?".http_build_query($_GET);

      }else{

      $lasturl = $urlink."/".$paginationCount;

      }

        $html['pages'] .='<li class="next" id="'.$paginationCount.'">
         <a href="'.$url.'" >Next</a>
    </li>';


     $html['pages'] .='<li class="last" id="'.$paginationCount.'">
         <a href="'.$lasturl.'" >Last</a>
    </li></ul>';
     }

      }*/
         $html['pages'] .='<ul class="pagination">';   
      if($currentpage > 1){
    $prevpage = $currentpage - 1;
     if(!empty($_GET)){

      $purl = $urlink."/".$prevpage."?".http_build_query($_GET);

      }else{

      $purl = $urlink."/".$prevpage;

      }
       $html['pages'] .='<li class="next" id="'.$paginationCount.'">
         <a href="'.$purl.'" >Previous '.$perpage.' Results</a>
    </li>';
             }

         if($currentpage < $paginationCount){
    $nextpage = $currentpage + 1;
                  if(!empty($_GET)){

      $url = $urlink."/".$nextpage."?".http_build_query($_GET);

      }else{

      $url = $urlink."/".$nextpage;

      }
       $html['pages'] .='<li class="next" id="'.$paginationCount.'">
         <a href="'.$url.'" >Next '.$perpage.' Results</a>
    </li>';
             }

  $html['pages'] .= '</ul>';
   }

    return $html;

}

}
