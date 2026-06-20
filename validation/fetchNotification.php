<?php
include '../core/init.php';

    $selectNotifications = $getFromU->fetch_innerjoin_one_cond('notification', 'products', 'product_id', 'checked', 'unread');
    
    $htmlo = '';
    $i = 0;

    foreach($selectNotifications as $selectNotification) {
        $i++;

        $htmlo .= '<div class="media"><img class="d-flex align-self-center img-radius" src="'.$selectNotification->product_pics .'" alt="'.$selectNotification->name.'">
        <div class="media-body">
            <h5 class="notification-user">'.$selectNotification->name.'</h5>
            <p class="notification-msg">We have '.$selectNotification->quantity.' quantit(ies) left.</p>
            <span class="notification-time">'.$getFromU->timeAgo($selectNotification->notify_date).'</span>
        </div></div>';
    }

    exit($htmlo);
