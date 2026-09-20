#!/usr/bin/env php
<?php

// Compares this build's line coverage with the last successful master build's
// and fails when it went down. It replaces the CircleCI version, which did the
// same by reading CircleCI's artifact API and posting a commit status; on GitHub
// Actions the job's own result is the status, and the baseline is the `coverage`
// artifact of the latest successful master run of ci.yml. Needs the gh CLI and
// GH_TOKEN, both present on GitHub-hosted runners.

$new = coverageValue('docs/coverage/coverage.txt');
$old = baselineValue();

if ($old === null) {
    $message = "Coverage: $new% (no earlier master build to compare with)";
    $ok = true;
} else {
    $message = "Coverage: $new% (master: $old%)";
    $ok = $new >= $old;
}

echo $message, PHP_EOL;

if ($summary = getenv('GITHUB_STEP_SUMMARY')) {
    file_put_contents($summary, ($ok ? '' : '**Coverage went down.** ') . $message . PHP_EOL, FILE_APPEND);
}

exit($ok ? 0 : 1);

/**
 * The "Lines: 12.34% (n/m)" percentage from PHPUnit's text coverage report.
 */
function coverageValue($report)
{
    if (!preg_match('/^\s*Lines:\s+([\d.]+)%/m', file_get_contents($report), $match)) {
        fwrite(STDERR, "No line coverage found in $report" . PHP_EOL);
        exit(2);
    }

    return (float) $match[1];
}

/**
 * Line coverage of the latest successful master run, or null when there isn't
 * one (a new repository, or artifacts that have expired).
 */
function baselineValue()
{
    $run = trim((string) shell_exec(
        'gh run list --workflow ci.yml --branch master --status success --limit 1 --json databaseId --jq ".[0].databaseId" 2>/dev/null'
    ));

    if ($run === '') {
        return null;
    }

    $dir = sys_get_temp_dir() . '/coverage-baseline';
    shell_exec('rm -rf ' . escapeshellarg($dir));
    shell_exec('gh run download ' . escapeshellarg($run) . ' --name coverage --dir ' . escapeshellarg($dir) . ' 2>/dev/null');

    $report = "$dir/coverage.txt";

    return is_file($report) ? coverageValue($report) : null;
}
