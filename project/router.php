<?php
// Router script để xử lý static files và PHP files
$requestUri = $_SERVER['REQUEST_URI'];
$filePath = ltrim($requestUri, '/');

// Xử lý các file tĩnh (images, css, js)
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|avif|webp|svg|ico)$/', $filePath)) {
    if (file_exists($filePath)) {
        // Xác định content type
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $contentTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'avif' => 'image/avif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon'
        ];
        
        if (isset($contentTypes[$ext])) {
            header('Content-Type: ' . $contentTypes[$ext]);
        }
        
        readfile($filePath);
        return true;
    } else {
        http_response_code(404);
        echo "File not found: " . $filePath;
        return true;
    }
}

// Xử lý PHP files hoặc default routing
if (empty($filePath) || $filePath === '/') {
    include 'home.php';
    return true;
}

if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
    include $filePath;
    return true;
}

// Default fallback cho các PHP files không có extension
if (file_exists($filePath . '.php')) {
    include $filePath . '.php';
    return true;
}

// 404 for everything else
http_response_code(404);
echo "Page not found: " . $filePath;
return false;
?>
