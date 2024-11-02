<?php

namespace Response\Render;

use Response\HTTPRenderer;
use Helpers\Authenticate;

class HTMLRenderer implements HTTPRenderer
{
    private string $viewFile;
    private array $data;

    public function __construct(string $viewFile, array $data = []) {
        $this->viewFile = $viewFile;
        $this->data = $data;
    }

    public function getFields(): array {
        return [
            'Content-Type' => 'text/html; charset=UTF-8',
        ];
    }

    public function getContent(): string {
        $viewPath = $this->getViewPath($this->viewFile);

        if (!file_exists($viewPath)) {
            throw new \Exception("View file {$viewPath} does not exist.");
        }

        ob_start();
        extract($this->data);
        require $viewPath;
        return $this->getHeader() . ob_get_clean() . $this->getFooter();
    }

    private function getHeader(): string{
        ob_start();
        // ユーザーへのアクセスを提供します
        $user = Authenticate::getAuthenticatedUser();
        require $this->getViewPath('layout/header');
        // require $this->getViewPath('component/navigator');
        // require $this->getViewPath('component/message-boxes');
        return ob_get_clean();
    }
    
    private function getFooter(): string {
        ob_start();
        require $this->getViewPath('layout/footer');
        return ob_get_clean();
    }

    private function getViewPath(string $path): string {
        return sprintf("%s/%s/Views/%s.php", __DIR__, '../..', $path);
    }

}