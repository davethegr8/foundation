#!/usr/bin/env php
<?php

$statusURL = 'https://api.github.com/v3/repos/'.getenv('CIRCLE_PROJECT_USERNAME').'/'.getenv('CIRCLE_PROJECT_REPONAME').'/statuses/'.getenv('CIRCLE_SHA1');
echo $statusURL, PHP_EOL;
$statusData = [
    'state' => 'pending',
    'target_url' => getenv('CIRCLE_BUILD_URL'),
    'description' => '',
    'context' => 'davethegr8/code-coverage'
];

echo postJSON($statusURL, $statusData), PHP_EOL;

$artifacts = shell_exec('curl -s https://circleci.com/api/v1.1/project/github/davethegr8/foundation/latest/artifacts?circle-token='.getenv('CI_TOKEN').'&branch=master&filter=successful');

$data = [];

$old_report = json_decode($artifacts, true)[0]['url'];
$data['old'] = getCoverageValue($old_report);

$new_report = 'docs/coverage/coverage.txt';
$data['new'] = getCoverageValue($new_report);

$data['message'] = 'Coverage: '.$data['new'].' (old: '.$data['old'].')';

$statusData['description'] = $data['message'];
if($data['new'] >= $data['old']) {
    $statusData['state'] = 'success';
}
else {
    $statusData['state'] = 'error';
}

echo postJSON($statusURL, $statusData), PHP_EOL;

// echo json_encode($data);

function getCoverageValue($report) {
    $lines = explode("\n", file_get_contents($report));
    preg_match('/([\d\.]+)%/', $lines[8], $match);
    return $match[1];
}

function postJSON($url, $data) {
    $data_string = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: davethegr8/code-coverage',
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
