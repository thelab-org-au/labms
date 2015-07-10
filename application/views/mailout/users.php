            <!--    <div class="element">
                <h3>Recipients</h3>
                <p>
                    <label for="all">
                    <input type="checkbox" id="selectAll" name="all" value="1" onclick='selectAllUsers(this);'/>
                    All&nbsp;&nbsp;

                    <input type="checkbox" name="mentor" value="2" onclick='selectAllUsers(this);'/>
                    Mentors&nbsp;&nbsp;
                    <input type="checkbox" name="parents" value="3" onclick='selectAllUsers(this);'/>
                    Parents&nbsp;&nbsp;

                    <input type="checkbox" name="admins" value="4" onclick='selectAllUsers(this);'/>

                    Admins&nbsp;&nbsp;

                    </label>
                </p>
        </div>-->
    
    
    <?php

        echo '<table style="text-align:center;"><thead><tr>';
        
        for ($cnt = 0; $cnt < 3; $cnt++)
        {
        
            echo '<th style="width: 50px;">Select</th>';
        
            echo '<th>User name</th>';
        
        }
        
        echo '</tr></thead><tbody>';
        
        
        $count = 0;
        
        for ($cnt = 0; $cnt < (sizeof($users) / 3); $cnt++)
        {
        
            echo '<tr>';
        
            for ($cnt2 = 0; $cnt2 < 3; $cnt2++)
            {
        
        
                if (isset($users[$count]))
                {
        
                    //$pre = (in_array($users[$count]['id'],$userLocations));
        
                    echo '<span><td><input type="checkbox" id="user' . $count . '" name="user' . $users[$count]['id'] . '" value="' . $users[$count]['id'] . '" userType="' . $users[$count]['userType'] .
                        '" userLocations="' . $users[$count]['locations'] . '" /></td>';
        
                    echo '<td>' . $users[$count]['firstName'] . ' ' . $users[$count]['lastName'] . '</td></span>';
        
                }
                else
                {
        
                    echo '<td></td><td></td>';
        
                }
        
                $count++;
        
            }
        
            echo '</tr>';
        
        }
        
        
        echo '</tbody></table>';
        
        ?>