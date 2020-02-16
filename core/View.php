<?php


namespace core;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;


class View
{
    /**
     * @var Environment
     */
    private $twig;

    private $view_name;
    private $view_context = [];

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->set_twig();
    }

    /**
     * Set twig
     */
    private function set_twig() {
        $_twig_loader = new FilesystemLoader(_VIEW_DIR);
        $this->twig = new Environment($_twig_loader, [
            'debug' => _DEBUG_VIEW
            #'cache' => _ROOT.'/storage/twig_cache/',
        ]);

        $this->twig->addExtension(new DebugExtension());
    }

    /**
     * @param $view
     * @return $this
     *
     * set view_name
     */
    public function name ($view) {

        $view = str_replace(".", "/", $view);

        $this->view_name = $view.".twig";
        return $this;
    }

    /**
     * @param array $context
     * @return $this
     * set view arguments
     */
    public function context($context = []) {
        $this->view_context = $context;
        return $this;
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     *
     * print view
     */
    public function render() {
        $_system = [
            'name_view' => $this->view_name
        ];
        $this->view_context += [
            '_system' => $_system,
            '_service' => services()
        ];
        echo $this->twig->render($this->view_name, $this->view_context);
    }
}