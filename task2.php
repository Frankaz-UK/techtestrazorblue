<?php
// Task 2
function isIpAllowed($ip, $ipList): bool
{
    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return false;
    }

    $ipLong = ip2long($ip);

    foreach ($ipList as $entry) {
        $entry = trim($entry);

        // Case 1: CIDR format
        if (str_contains($entry, '/')) {
            list($subnet, $maskLength) = explode('/', $entry);

            if (!filter_var($subnet, FILTER_VALIDATE_IP) || !is_numeric($maskLength)) {
                continue;
            }

            $subnetLong = ip2long($subnet);
            $mask = -1 << (32 - (int)$maskLength);

            if (($ipLong & $mask) === ($subnetLong & $mask)) {
                return true;
            }
        }

        // Case 2: IP range with dash
        elseif (str_contains($entry, '-')) {
            list($startIp, $endIp) = array_map('trim', explode('-', $entry));

            if (!filter_var($startIp, FILTER_VALIDATE_IP) || !filter_var($endIp, FILTER_VALIDATE_IP)) {
                continue;
            }

            $startLong = ip2long($startIp);
            $endLong = ip2long($endIp);

            if ($ipLong >= $startLong && $ipLong <= $endLong) {
                return true;
            }
        }

        // Case 3: Single IP
        else {
            if ($ip === $entry) {
                return true;
            }
        }
    }

    return false;
}

$allowedList = [
    '192.168.1.1',
    '192.168.1.10 - 192.168.1.20',
    '10.10.1.32/27'
];

// Test The IP Range in allowed list
$testIp = '192.168.1.21'; // false

if (isIpAllowed($testIp, $allowedList)) {
    echo "$testIp is allowed.<br /><br />";
} else {
    echo "$testIp is not allowed.<br /><br />";
}

$testIp = '192.168.1.20'; // true

if (isIpAllowed($testIp, $allowedList)) {
    echo "$testIp is allowed.<br /><br />";
} else {
    echo "$testIp is not allowed.<br /><br />";
}

// Test the CIDR in allowed list
$testIp = '10.10.1.90'; // false

if (isIpAllowed($testIp, $allowedList)) {
    echo "$testIp is allowed.<br /><br />";
} else {
    echo "$testIp is not allowed.<br /><br />";
}

$testIp = '10.10.1.44'; // true

if (isIpAllowed($testIp, $allowedList)) {
    echo "$testIp is allowed.<br /><br />";
} else {
    echo "$testIp is not allowed.<br /><br />";
}

// Test the IP address in allowed list
$testIp = '192.168.1.2'; // false

if (isIpAllowed($testIp, $allowedList)) {
    echo "$testIp is allowed.<br /><br />";
} else {
    echo "$testIp is not allowed.<br /><br />";
}

$testIp = '192.168.1.1'; // true

if (isIpAllowed($testIp, $allowedList)) {
    echo "$testIp is allowed.<br /><br />";
} else {
    echo "$testIp is not allowed.<br /><br />";
}
?>