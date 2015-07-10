<?php
    
    if(isset($paginationData))
    {
        if($paginationData['draw'])
        {
            echo '<div class="pagination" style="margin-left: 15px;">';
            
            if($paginationData['current'] > 1)
            {  
                echo '<a href="javascript:'.$paginationData['function'].'(1);">« First</a>';
            }
            else
            {
                echo '<span>« First</span>';
            }
            
            $span = true;
            for($cnt = 0; $cnt < $paginationData['count']; $cnt++)
            {
                if($cnt + 1 == $paginationData['current'])
                {
                    echo '<span class="active">'.($cnt + 1).'</span>';
                }
                else
                {
                    echo '<a href="javascript:'.$paginationData['function'].'('.($cnt + 1).');">'.($cnt + 1).'</a>';
                }          
            }
            
            if($paginationData['current'] >= $paginationData['count'])
            {
                echo '<span>Last »</span>';     
            }
            else
            {
                echo '<a href="javascript:'.$paginationData['function'].'('.ceil($paginationData['count']).');">Last »</a>';
            }
            
            echo '</div>';  
        }        
    }
?>