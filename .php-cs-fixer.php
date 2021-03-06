<?php

use PhpCsFixer\Finder;

$project_path = getcwd();
$finder = Finder::create()
    ->in([
        $project_path . '/bootstrap',
        $project_path . '/config',
        $project_path . '/database',
        $project_path . '/src',
        $project_path . '/storage',
        $project_path . '/stubs',
        $project_path . '/tests',
    ])
    ->exclude(['cache', 'Swagger', 'PhpDocumentor'])
    ->name('*.php')
    ->notName(['*.blade.php'])
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return \ShiftCS\styles($finder);
