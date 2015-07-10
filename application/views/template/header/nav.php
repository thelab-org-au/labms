<div id="nav">
	<ul>
        <?php
            if(isset($topNav))
            {
                
                foreach($topNav as $nav)
                {
                   
                    echo '<li class="upp"><a href="'.$nav['link'].'">'.$nav['title'].'</a><ul>';
                        foreach($nav['items'] as $item)
                        {
                            $click = isset($item['click']) ? 'onclick="' .$item['click'].'"'  : '';
                            
                            echo '<li>&#8250; <a href="'.$item['link'].'" '.$click.'>'.$item['title'].'</a></li>';
                        }
                            
                    
                    echo '</ul></li>';
                }               
            }
                
        ?>
	</ul>
    
</div>