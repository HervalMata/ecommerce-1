<?php
if (isset($_GET[‘tx’])) {
    $txn_id = $_GET[‘tx’];
    $ch = curl_init();
    curl_setopt_array($ch, array (
        CURLOPT_URL => ‘https://www.sandbox.paypal.com/cgi-bin/webscr’,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query(array (
            ‘cmd’ => ‘_notify-synch’,
            ‘tx’ => $txn_id,
            ‘at’ => PAYPAL_IDENTITY_TOKEN,
            )),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false
    ));
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($status === 200) {
        $lines = explode(“\n”, urldecode($response));
        $data = array();
        $data[‘result’] = array_shift($lines);
        foreach ($lines as $line) {
            if (stristr($line, ‘=’)) {
                list ($k, $v) = explode(‘=’, $line);
                $data[$k] = $v;
            }
        }
        if ( ($data[‘result’] === ‘SUCCESS’)
        && isset($data[‘payment_status’])
        && ($data[‘payment_status’] === ‘Completed’)
        && ($data[‘receiver_email’] === ‘seller_1281297018_biz@mac.com’)
        && ($data[‘mc_gross’] == 10.00)
        && ($data[‘mc_currency’] === ‘USD’)
        ) {
            $q = “SELECT id FROM orders WHERE transaction_id=’$txn_id’;
            $r = mysqli_query($dbc, $q);
            if (mysqli_num_rows($r) === 0) {
                $uid = (isset($_POST[‘custom’])) ? (int) $_POST‘custom’] : 0;
                $amount = (int) ($_POST[‘mc_gross’] * 100);
                $q = “INSERT INTO orders (user_id, transaction_id, payment_status, payment_amount) VALUES ($uid, ‘$txn_id’, ‘{$data[‘result’]}’, $amount)”;
                $r = mysqli_query($dbc, $q);
                if (mysqli_affected_rows($dbc) === 1) {
                    if ($uid > 0) {
                        $q = “UPDATE users SET date_expires = IF(date_expires > NOW(), ADDDATE(date_expires, INTERVAL 1 YEAR), ADDDATE(NOW(), INTERVAL 1 YEAR)), date_modified=NOW() WHERE id=$uid”;
                        $r = mysqli_query($dbc, $q);
                        if (mysqli_affected_rows($dbc) !== 1) {
                            trigger_error(‘The user\’s expiration date  could not be updated!’);
                        }
                    } // No user ID.
                } else { // Problem inserting the order!
                    trigger_error(‘The transaction could not be stored in the orders table!’);
                } // The order has already been stored, nothing to do!
            } // Not valid response.
        } // Can’t confirm the PDT.
    }
} // No $_GET[‘tx’].
?>