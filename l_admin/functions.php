<?php
  header("Content-Type: text/html;charset=UTF-8");
  require_once "../v.php";
  require '../medoo.php';
  require_once '../library/HTMLPurifier.auto.php';
  if(!defined("l_v") || constant("l_v")!="lam's masterpiece" || !isset($l_v_masterpiece)){echo "未授权!";die();}
  $config = HTMLPurifier_Config::createDefault();
  $purifier = new HTMLPurifier($config);
	function createTable($where){
							
	                        $database=new medoo();
                          $datas=$database->select("items","*",$where);
                          if ($datas) {
                            foreach($datas as $row)
                            {
                              echo '<tr>
                                <td>'.$row["ID"].'</td>
                                <td>
                                  <label>
                                    <a onclick=fun($(this)); data-ID='.$row["ID"].' href="" data-target="#editModal" data-toggle="modal">'.$row["title"].'</a>
                                  </label>
                                  
                                  
                                </td>
                                <td><a target=_blank href="../'.$row["imgurl"].'"><img width="32px" height="32px" title="点击查看大图" src="../'.$row["imgurl"].'"></a></td>
                                <td>'.$row["uploader"].'</td>
                                <td>'.$row["type"].'</td>
                                <td>'.($row["isfounded"]==0?"未认领":"已认领").'</td>
                                <td>'.$row["uploaddate"].'</td>
                                </tr>';
                            }
                          }
                           
                      }
     function createTable_cards($where){
							
	                        $database=new medoo();
                          $datas=$database->select("cards",array("[>]types"=>array("type"=>"TID")),"*",$where);
                          
                          if ($datas) {
                             foreach($datas as $row)
                            {
                              echo '<tr>
                                <td>'.$row["ID"].'</td>
                                <td>
                                  
                                    <label><a onclick=fun2($(this)); data-ID='.$row["ID"].' href="" data-target="#editModal" data-toggle="modal">'.$row["name"].'</a></label>
                                  
                                  
                                  
                                </td>
                                <td>'.$row["num"].'</td>
                                <td>'.$row["uploader"].'</td>
                                <td>'.$row["typename"].'</td>
                                <td>'.($row["isfounded"]==0?"未认领":"已认领").'</td>
                                <td>'.$row["uploaddate"].'</td>
                                </tr>';
                            }
                          }
                           
                      } 
                        function createTable_types($where){
              
                          $database=new medoo();
                          $datas=$database->select("types","*",$where);
                          
                          if ($datas) {
                             foreach($datas as $row)
                            {
                              echo '<tr>
                                <td>'.$row["TID"].'</td>
                                <td>
                                  
                                    <label><a onclick=fun3($(this)); data-ID='.$row["TID"].' href="" data-target="#editModal" data-toggle="modal">'.$row["typename"].'</a></label>
                                  
                                  
                                  
                                </td>
                                <td>'.($row["table"]=="items"?"物品类":"卡类").'</td>
                                </tr>';
                            }
                          }
                           
                      } 
  function createTypeSelect($table){
      $database=new medoo();
      $datas=$database->select("types","*",array("table"=>$table));
      
      if ($datas) {
         foreach($datas as $row)
        {
          echo '<option value="'.$row["TID"].'">'.$row["typename"].'</option>';
        }
      }

  }
	function jumpUrl($url)
	{

		echo '<script>window.location.href="'.$url.'";</script> ';
	}
  function setmsg($msg,$type="success")
  {
    $_SESSION["msg"]=$msg;
    $_SESSION["msgtype"]=$type;
  }
	function msgJump($url,$msg,$type="success")
  {
    setmsg($msg,$type);
    jumpUrl($url);
  }
  function delayJump($url,$time)
  {
    echo "<script language=\"javascript\">setTimeout(\"window.location.href='".$url."'\",".$time.")</script>";
  }
  function signin($username,$pwd)
  {
    $database=new medoo();
    if ($database->has("admins",array("AND"=>array("username"=>$username,"userpwd"=>$pwd))) ) 
    {

      return true;
    }else
      return false;
  }
  function GetPara($needorder=true){
  $r="";
  if (isset($_GET["col"]) && isset($_GET["key"])) {
    $col=trim($_GET["col"]);
    $key=trim($_GET["key"]);
    $r.= "&col=$col&key=$key&";
    //$r="?";
  }
  if (isset($_GET["order"]) && $needorder) {
    $order=$_GET['order'];
    $r.= "&order=$order&";
  }
  
    return $_SERVER['PHP_SELF']."?".substr($r,1);
}
function GetOrderPara($col){
    $r="";
    $para=GetPara(false);
    $order=$col;
    if (isset($_GET["order"]) && $_GET["order"]==$col) {
      $order="~".$col;
    }
    if (isset($_GET["page"])) {
      $r=$para."page=".$_GET["page"]."&order=".$order;
     
    }else{
        $r=$para."order=".$order;
    }
     return $r;
  
}
  function GetSelectOrder($x="ID"){
    $r=$x." DESC";
    if (isset($_GET["order"])) {
      $order=$_GET["order"];
      if (substr($order, 0,1)=="~") {
        $r=substr($order, 1)." ASC";
      }else{
        $r=$order." DESC";
      } 
    }
    return $r;
  }
?>