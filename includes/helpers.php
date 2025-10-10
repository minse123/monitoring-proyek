<?php
if (! function_exists('base_path')) {
    function base_path(): string
    {
        static $basePath = null;

        if ($basePath !== null) {
            return $basePath;
        }

        $projectRoot = realpath(__DIR__ . '/..');
        $documentRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : false;

        $calculated = '';

        if ($projectRoot !== false && $documentRoot !== false) {
            $projectRoot = str_replace('\\', '/', $projectRoot);
            $documentRoot = str_replace('\\', '/', $documentRoot);

            if (strpos($projectRoot, $documentRoot) === 0) {
                $calculated = rtrim(substr($projectRoot, strlen($documentRoot)), '/');
            }
        }

        if ($calculated === '' || $calculated === '/') {
            $basePath = '';
        } else {
            $basePath = '/' . ltrim($calculated, '/');
        }

        return $basePath;
    }
}

if (! function_exists('base_url')) {
    function base_url(string $path = ''): string
    {
        $basePath = base_path();
        $trimmedPath = ltrim($path, '/');

        if ($trimmedPath === '') {
            return $basePath === '' ? '/' : $basePath . '/';
        }

        return ($basePath === '' ? '' : $basePath) . '/' . $trimmedPath;
    }
}

if (! function_exists('asset_url')) {
    function asset_url(string $path = ''): string
    {
        $trimmedPath = ltrim($path, '/');

        if ($trimmedPath === '') {
            return base_url('assets');
        }

        return base_url('assets/' . $trimmedPath);
    }
}

