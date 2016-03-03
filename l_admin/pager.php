<?php 




function gethref($type){
  if($type=="index"){
    if (isset($_GET["page"])){
      if($_GET["page"]!=0)
        echo 'href="'.GetPara().'page=0"';
    }    
  }elseif ($type=="previous") {
      if (isset($_GET["page"]) && $_GET["page"]>0)
       echo 'href="'.GetPara().'page='.($_GET["page"]-1).'"';
  }elseif ($type=="next") {
      global $maxpage;
      if (isset($_GET["page"])){
        if($_GET["page"]>=0 && ($_GET["page"]+1)<=$maxpage)
          echo 'href="'.GetPara().'page='.($_GET["page"]+1).'"';
      }elseif ($maxpage>=1) {
          echo 'href="'.GetPara().'page=1"';
      }
  }elseif ($type=="end") {
    global $maxpage;
    if (isset($_GET["page"])){
      if(($_GET["page"]+1)<=$maxpage)
        echo 'href="'.GetPara().'page='.$maxpage.'"';
    }elseif ($maxpage>=1) {
      echo 'href="'.GetPara().'page='.$maxpage.'"';
    }
  }
}
function getclass($type)
{
  if($type=="index" || $type=="previous"){
    if (isset($_GET["page"])){
      if($_GET["page"]==0)
        echo 'class="disabled"';
    }else
      echo 'class="disabled"';
  }elseif ($type=="end" || $type=="next") {
    global $maxpage;
    if (isset($_GET["page"]) && ($_GET["page"]+1)>$maxpage){
        echo 'class="disabled"';
    }else if($maxpage<=0)
        echo 'class="disabled"';
  }
}
?>
<nav>
            <ul class="pager">
              <li <?php getclass("index"); ?>><a <?php gethref("index"); ?>>首页</a></li>
              <li <?php getclass("previous"); ?>>
                <a <?php gethref("previous"); ?> aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              
              <li <?php getclass("next"); ?>>
                <a <?php gethref("next"); ?> aria-label="Next" >
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
              <li <?php getclass("end"); ?>><a <?php gethref("end"); ?>>尾页</a></li>
            </ul>
</nav>