<?php
$cpanel_url = "https://yourcpaneldomain:2083/json-api/cpanel";
$cpanel_user = "your_cpanel_username";
$cpanel_pass = "your_cpanel_password";
$domain = "example.com";
$emails = [
    "user1@example.com" => "password1",
    "user2@example.com" => "password2",
    "user3@example.com" => "password3",
];

foreach ($emails as $email => $password) {
    $username = explode('@', $email)[0];
    $query = [
        "cpanel_jsonapi_user" => $cpanel_user,
        "cpanel_jsonapi_apiversion" => "2",
        "cpanel_jsonapi_module" => "Email",
        "cpanel_jsonapi_func" => "add_pop",
        "domain" => $domain,
        "email" => $username,
        "password" => $password,
        "quota" => "100",  // Set quota in MB
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $cpanel_url . "?" . http_build_query($query));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $cpanel_user . ":" . $cpanel_pass);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    if ($result['cpanelresult']['error']) {
        echo "Error creating email {$email}: " . $result['cpanelresult']['error'] . "\n";
    } else {
        echo "Successfully created email: {$email}\n";
    }
}
?>

