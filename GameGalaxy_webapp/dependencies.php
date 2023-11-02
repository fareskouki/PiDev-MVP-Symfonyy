<?php

require_once __DIR__.'/vendor/autoload.php';

use Composer\Semver\Semver;
use Symfony\Component\Yaml\Yaml;

// Load Symfony version from composer.lock file
$lockData = Yaml::parse(file_get_contents(__DIR__.'/composer.lock'));
$symfonyVersion = $lockData['packages-dev'][0]['version'];

// Load list of dependencies from composer.lock file
$packages = $lockData['packages'];
$packages += $lockData['packages-dev'];

// Check compatibility of each package with Symfony version
foreach ($packages as $package) {
    $name = $package['name'];
    $version = $package['version'];
    $requires = $package['require'];

    if (isset($requires['symfony/symfony'])) {
        $constraints = $requires['symfony/symfony'];
        if (!Semver::satisfies($symfonyVersion, $constraints)) {
            echo sprintf("%s %s requires Symfony %s, but your version is %s\n", $name, $version, $constraints, $symfonyVersion);
        }
    }
}