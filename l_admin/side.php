
<div class="panel panel-default">
        <ul class="nav nav-pills nav-stacked limit-side-width" id="sidebar">
        	
            <li<?php if(strpos($_SERVER['PHP_SELF'],"index.php")){echo ' class="active"';}?>><a href="index.php"><span class="glyphicon glyphicon-plus"></span> 管理招领数据(物品类)</a></li>
            <li<?php if(strpos($_SERVER['PHP_SELF'],"index_cards.php"))echo ' class="active"';?>><a href="index_cards.php"><span class="glyphicon glyphicon-plus"></span> 管理招领数据(卡类)</a></li>
            <?php
                if($_SESSION["type"]<=1)
                {
                    echo '<hr class="side-hr">
                    <li'.needactive("verify.php").'><a href="verify.php"><span class="glyphicon glyphicon-check"></span> 审核失物数据(物品类)</a></li>
                    <li'.needactive("verified.php").'><a href="verified.php"><span class="glyphicon glyphicon-ok"></span> 已审核的数据(物品类)</a></li>
                    <li'.needactive("verify_cards.php").'><a href="verify_cards.php"><span class="glyphicon glyphicon-check"></span> 审核失物数据(卡类)</a></li>
                    <li'.needactive("verified_cards.php").'><a href="verified_cards.php"><span class="glyphicon glyphicon-ok"></span> 已审核的数据(卡类)</a></li>
                    <hr class="side-hr">
                    <li'.needactive("edittypes.php").'><a href="edittypes.php"><span class="glyphicon glyphicon-edit"></span> 管理类型</a></li>';
                }
                function needactive($str){
                    if(strpos($_SERVER['PHP_SELF'],$str))
                        return ' class="active"';
                    else
                        return '';
                }

            ?>

            
            
        </ul>
            
            	

            
        </div>