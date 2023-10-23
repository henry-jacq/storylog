<?php

namespace Storylog\Controllers;

use Storylog\Core\View;
use Storylog\Core\Config;
use Storylog\Core\Controller;
use Storylog\Services\BlogService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogController extends Controller
{    
    public function __construct(
        private readonly View $view,
        private readonly Config $config,
        private readonly BlogService $blog
    )
    {
        parent::__construct($view, $config);
    }
    
    public function index(Request $request, Response $response)
    {
        $slug = $request->getAttribute('blogname');
        $sess_user = $request->getAttribute('userData');
        $blogData = $this->blog->getBlog($slug);
        
        $args = [
            'title' => $blogData['title'],
            'blogData' => $blogData,
            'sessionUser' => $sess_user
        ];
        return $this->render($response, 'blog/blog', $args);
    }

    public function create(Request $request, Response $response)
    {
        $args = [
            'title' => 'Create a Blog',
            'app_host' => $this->config->get('app.host')
        ];
        return $this->render($response, 'blog/create', $args);
    }

    public function edit(Request $request, Response $response)
    {
        $slug = $request->getAttribute('slug');
        $sess_user = $request->getAttribute('userData');
        $blogData = $this->blog->getBlog($slug);

        $args = [
            'title' => 'Edit Blog',
            'blogData' => $blogData,
            'app_host' => $this->config->get('app.host')
        ];
        
        // If the blog owner equals to session owner, then edit operation is done
        if (!$this->blog->slugExists($slug) || $blogData['uid'] != $sess_user['id']) {
            return $this->render($response, 'error', $args);
        }

        return $this->render($response, 'blog/edit', $args);
    }

    /**
     * Render requested images
     */
    public function files(Request $request, Response $response, array $args)
    {
        $pathName = '/' . $args['category'] . '/' . $args['image'];

        if (!$this->blog->imageExists($pathName)) {
            return $response->withStatus(404);
        }
        $imgData = $this->blog->getImage($pathName);

        $response->getBody()->write($imgData);
        
        return $response->withHeader('Content-Type', mime_content_type(STORAGE_PATH.$pathName));
    }

    public function publish(Request $request, Response $response)
    {
        $blogData = $request->getParsedBody();
        $featuredImage = $request->getUploadedFiles()['featured-image'];
        $status = $this->blog->publishBlog($featuredImage, $blogData);
        return $this->respondAsJson($response, ['message' => $status]);
    }
}