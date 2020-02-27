<?php
class Renderer {

    private $baseViewsPath;

    public function __construct(string $baseViewsPath)
    {
        $this->baseViewsPath =$baseViewsPath;
    }

    public function renderView(string $viewFile, array $arguments)
    {
        $fullPath = $this->baseViewsPath . $viewFile;

        ob_start();

        extract($arguments);

        require $fullPath;

        $content = ob_get_contents();

        ob_get_clean();

        $stream = Stream::createFromString($content);
        $response = new Response($stream);

        return $response;


    }

    public function renderJson(array $data) {
        $json = json_encode($data);
        $stream = Stream::createFromString($json);
        $response = new Response($stream);

        return $response;
    }
}

// require __DIR__ . '/views/user.phtml';