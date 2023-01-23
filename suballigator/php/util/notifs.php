<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


function getNotifs()
{
    return isset($_SESSION['notifs']) ? $_SESSION['notifs'] : array();
}

function addNotif($type, $title, $message)
{

    if (isset($_SESSION['notifs']) && count($_SESSION['notifs']) > 0) {
        array_push($_SESSION['notifs'], array("type" => $type, "title" => $title, "message" => $message));
    } else {
        $_SESSION['notifs'] = array(array("type" => $type, "title" => $title, "message" => $message));
    }

    return $_SESSION['notifs'];
}

function afficherNotifs()
{
    echo '<div class="absolute flex-col inset-x-0 mx-auto max-w-xl mt-4">';
    echo '
    <script>
        function removeFadeOut( el, speed ) {
            var seconds = speed/1000;
            el.style.transition = "opacity "+seconds+"s ease";
        
            el.style.opacity = 0;
            setTimeout(function() {
                el.parentNode.removeChild(el);
            }, speed);
        }
    </script>
    ';
    foreach (getNotifs() as $notif) {
        switch ($notif['type']) {
            case 'info':
                echo
                '<div class="alert alert-info shadow-lg mb-2" onclick="removeFadeOut(this, 1000);">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span><strong>' . $notif['title'] . '</strong><br>' . $notif['message'] . '</span>
                    </div>
                </div>';
                break;
            case 'success':
                echo
                '<div class="alert alert-success shadow-lg mb-2" onclick="removeFadeOut(this, 1000);">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span><strong>' . $notif['title'] . '</strong><br>' . $notif['message'] . '</span>
                    </div>
                </div>';
                break;
            case 'warning':
                echo
                '<div class="alert alert-warning shadow-lg mb-2" onclick="removeFadeOut(this, 1000);">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <span><strong>' . $notif['title'] . '</strong><br>' . $notif['message'] . '</span>
                    </div>
                </div>';
                break;

            default:
                echo
                '<div class="alert alert-error shadow-lg mb-2" onclick="removeFadeOut(this, 1000);">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span><strong>' . $notif['title'] . '</strong><br>' . $notif['message'] . '</span>
                    </div>
                </div>';

                break;
        }
    }
    echo '</div>';

    $_SESSION['notifs'] = array();

}

