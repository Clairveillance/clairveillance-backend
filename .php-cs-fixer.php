<?php

use PhpCsFixer\Finder;

$project_path = getcwd();
$finder = Finder::create()
    ->in([
        $project_path . '/bootstrap',
        $project_path . '/config',
        $project_path . '/database',
        $project_path . '/public',
        $project_path . '/resources',
        $project_path . '/src',
        $project_path . '/storage',
        $project_path . '/stubs',
        $project_path . '/tests',
    ])
    ->exclude(['cache', 'Swagger'])
    ->name('*.php')
    ->notName(['*.blade.php'])
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return \ShiftCS\styles($finder);
