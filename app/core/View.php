<?php
/**
 * View Class
 * Handles rendering of views with layout support
 */

class View {
    private $viewPath;
    private $layoutPath = 'layouts/main';
    private $data = [];

    /**
     * Render view
     * @param string $view View file path (without .php)
     * @param array $data Data to pass to view
     * @param string|null $layout Layout to use (null for no layout)
     */
    public function render($view, $data = [], $layout = null) {
        $this->data = $data;
        
        // Extract data variables
        extract($data);

        // Set layout
        if ($layout !== null) {
            $this->layoutPath = $layout;
        }

        // Build view file path
        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new Exception("View file not found: {$viewFile}");
        }

        // Start output buffering
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Render with layout if specified
        if ($this->layoutPath) {
            $layoutFile = __DIR__ . '/../views/' . $this->layoutPath . '.php';
            
            if (file_exists($layoutFile)) {
                // Make content and data available to layout
                extract($data);
                require $layoutFile;
            } else {
                echo $content;
            }
        } else {
            echo $content;
        }
    }

    /**
     * Include a partial view
     * @param string $partial Partial view path
     * @param array $data Data to pass
     */
    public function partial($partial, $data = []) {
        extract($data);
        $partialFile = __DIR__ . '/../views/' . $partial . '.php';
        
        if (file_exists($partialFile)) {
            require $partialFile;
        } else {
            throw new Exception("Partial view not found: {$partialFile}");
        }
    }

    /**
     * Escape HTML to prevent XSS
     * @param string $string String to escape
     * @return string
     */
    public function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Generate URL
     * @param string $path URL path
     * @return string
     */
    public function url($path) {
        return Router::url($path);
    }

    /**
     * Get asset URL
     * @param string $path Asset path
     * @return string
     */
    public function asset($path) {
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        return $basePath . '/' . ltrim($path, '/');
    }

    /**
     * Display flash message
     * @param string $type Message type
     * @return string|null
     */
    public function flash($type = null) {
        if ($type) {
            return Session::getFlash($type);
        }
        return Session::getAllFlash();
    }

    /**
     * Get CSRF token input field
     * @return string
     */
    public function csrfField() {
        $token = Security::generateCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    /**
     * Get CSRF token value
     * @return string
     */
    public function csrfToken() {
        return Security::generateCsrfToken();
    }
}
