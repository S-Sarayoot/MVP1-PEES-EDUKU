<?php
// app/helpers.php
const VIEW_PATH = __DIR__ . '/views';

/**
 * คืนค่า HTML ของไฟล์ view โดย inject ตัวแปรเข้าไป
 */
function render(string $view, array $data = []): string {
    $file = VIEW_PATH . '/' . ltrim($view, '/');
    if (!is_file($file)) {
        throw new RuntimeException("View not found: $file");
    }
    extract($data, EXTR_SKIP);
    ob_start();
    include $file;
    return ob_get_clean();
}

/**
 * ครอบ content ด้วย layout ที่กำหนด
 */
function layout(string $layout, string $content, array $data = []): string {
    // ทำให้ $content ใช้ในไฟล์ layout ได้
    return render($layout, array_merge($data, ['content' => $content]));
}

/**
 * เรียก component แบบ echo ตรงๆ
 */
function component(string $view, array $data = []): void {
    echo render($view, $data);
}
