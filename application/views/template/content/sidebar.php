<div id="sidebar">
    <?php
    if(isset($topNav))
    {
        foreach($topNav as $nav)
        {
            echo '<div class="box"><div class="h_title">&#8250; '.$nav['title'].'</div>';
            
            echo '<ul '. (($nav['home']) ? 'id="home"' : '') .'>'; 
            
            $cnt = 0;                       
            foreach($nav['items'] as $item)
            {
                $click = isset($item['click']) ? 'onclick="'.$item['click'].'"'  : '';
                echo '<li class="'. ((($cnt++ / 2) == 0) ? 'b1' : 'b2').'"><a class="icon '.$item['class'].'" href="'.$item['link'].'" '.$click.'>'.$item['title'].'</a></li>';
            }
            
            echo '</ul></div>';
        }               
    }
    else
    {
        echo '<div class="box"><div class="h_title">&#8250; nav</div></div>';
    }
    
    ?>
    
    
</div>
