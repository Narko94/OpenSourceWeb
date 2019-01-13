<div class="profile_main">
    <div class="profile_body">

        <div class="profile_cont2">
            <ul>
                <li><span class="left">Имя:</span><span class="right"><?php print $account->getlogin(); ?></span></li>
                <li><span class="left">Группа:</span><span class="right"><?php print $account->getGroup(); ?></span></li>
                    <?php
                        if($account->getEmail())
                        {
                    ?>
                            <li><span class="left">Email:</span><span class="right"><?php print $account->getEmail(); ?></span></li>
                    <?php
                        }
                        $account->getAccInfo();
                        ?>
            </ul>?>
        </div>
    </div>
</div>