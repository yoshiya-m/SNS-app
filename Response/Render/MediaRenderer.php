<?php


namespace Response\Render;

use Response\HTTPRenderer;

class MediaRenderer implements HTTPRenderer {
    public function __construct(private string $filepathBase, private string $type) {}

    public function getFields(): array {
        return [
            'Content-Type' => $this->getTypeDetails()['content_type']
        ];
    }

    public function getFileName(): string{
        $base = __DIR__ . '/../..';
        $filename = sprintf("%s/%s.%s", $base, $this->filepathBase, $this->getTypeDetails()['extension']);
        if(file_exists($filename)) return $filename;
        else return sprintf("%s/%s", $base, "public/images/file-not-found.jpeg");
    }

    public function getContent(): string {
        ob_start();
        readfile($this->getFileName());
        return ob_get_clean();
    }

    private function getTypeDetails(): array{
        $supportedContentTypes = [
            'jpg' => [
                'content_type' => 'image/jpeg',
                'extension' => 'jpg',
            ],
            'jpeg' => [
                'content_type' => 'image/jpeg',
                'extension' => 'jpeg',
            ],
            'png' => [
                'content_type' => 'image/png',
                'extension' => 'png',
            ],
            'gif' => [
                'content_type' => 'image/gif',
                'extension' => 'gif',
            ],
            'mp3' => [
                'content_type' => 'audio/mpeg',
                'extension' => 'mp3',
            ],
            'mp4' => [
                'content_type' => 'video/mp4',
                'extension' => 'mp4',
            ],
        ];

        if (isset($supportedContentTypes[$this->type])) {
            return $supportedContentTypes[$this->type];
        } else {
            throw new \InvalidArgumentException(sprintf("Media type %s is an invalid type", $this->type));
        }
    }
}