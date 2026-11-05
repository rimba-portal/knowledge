<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$errors = [];
$required = ['composer.json', 'config/bites.php', 'src/KnowledgeServiceProvider.php', 'README.md'];
foreach ($required as $file) {
    if (! is_file($root.'/'.$file)) { $errors[] = 'Missing '.$file; }
}
$composer = json_decode((string) file_get_contents($root.'/composer.json'), true, 512, JSON_THROW_ON_ERROR);
if (($composer['name'] ?? null) !== 'rimba/knowledge') { $errors[] = 'Wrong Composer package name.'; }
$phpFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
foreach ($phpFiles as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = (string) file_get_contents($file->getPathname());
        if (str_contains($content, 'Know'.'edge')) { $errors[] = 'Legacy package-name typo in '.$file->getPathname(); }
    }
}
if ($errors !== []) {
    fwrite(STDERR, implode(PHP_EOL, $errors).PHP_EOL);
    exit(1);
}
echo "Package structure validated.\n";
