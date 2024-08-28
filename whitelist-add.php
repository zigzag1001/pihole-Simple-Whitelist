<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'list') {
        // List whitelisted domains
        $command = "sudo pihole -w -l | awk '{print $1, $2}'";
        
        $output = [];
        exec("$command 2>&1", $output);
        
        echo "<pre>" . implode("\n", $output) . "</pre>";
    } elseif (isset($_POST['action']) && $_POST['action'] === 'disable') {
        // https://www.crosstalksolutions.com/the-worlds-greatest-pi-hole-and-unbound-tutorial-2023/
        
        $XMin = 5; // Minutes to disable blocking
        $XSec = $XMin * 60;
        $auth = "YOUR_PASSWORD_HASH"; // `cat /etc/pihole/setupVars.conf | grep WEBPASSWORD`
        
        $command = "curl -s \"http://localhost/admin/api.php?disable={$XSec}&auth={$auth}\"";
        
        $output = [];
        $returnVar = 0;
        exec("$command 2>&1", $output, $returnVar);
        
        if ($returnVar === 0) {
            echo "Disabled blocking for $XMin minutes. ". implode(' ', $output);
            $t=time();
            $d=date("M-d H:i e",$t);
            error_log("Disabled by {$_SERVER['REMOTE_ADDR']} - {$d}\n", 3, "/var/log/pihole_disabled.log");
        } else {
            echo "Failed. Blocking not disabled. Output: " . implode(' ', $output);
        }
    } else {
        // Whitelist a domain
        $t=time();
        $d=date("M-d H:i e",$t);
        $domain = escapeshellarg($_POST['domain']);
        $regex_domain = "/[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z]{2,6}/";
        $is_match = preg_match($regex_domain, $domain);
        if ($is_match == 1) {
            $command = "sudo pihole -w $domain --comment \"{$_SERVER['REMOTE_ADDR']} - {$d}\"";
            
            $output = [];
            $returnVar = 0;
            exec("$command 2>&1", $output, $returnVar);
            
            if ($returnVar === 0) {
                echo "Domain $domain has been successfully whitelisted.";
            } else {
                echo "Failed to whitelist domain $domain. Output: " . implode(' ', $output);
            }
        } else {
            echo "Domain input is wrong.";
        }
    }
}
?>

