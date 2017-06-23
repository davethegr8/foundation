#!/usr/bin/env php
<?php

$artifacts = shell_exec('curl -s https://circleci.com/api/v1.1/project/github/davethegr8/foundation/latest/artifacts?circle-token='.getenv('CI_TOKEN').'&branch=master&filter=successful');

$data = [];

$old_report = json_decode($artifacts, true)[0]['url'];
$data['old'] = getCoverageValue($old_report);

$new_report = 'docs/coverage/coverage.txt';
$data['new'] = getCoverageValue($new_report);

$data['message'] = 'Coverage: '.$data['new'].' (old: '.$data['old'].')';

echo json_encode($data);

function getCoverageValue($report) {
    $lines = explode("\n", file_get_contents($report));
    preg_match('/([\d\.]+)%/', $lines[8], $match);
    return $match[1];
}
