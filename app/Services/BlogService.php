<?php

namespace Storylog\Services;

use Storylog\Model\Blog;
use Storylog\Model\Image;
use Storylog\Interfaces\BlogServiceInterface;

class BlogService implements BlogServiceInterface
{
    public function __construct(
        private readonly Blog $blog,
        private readonly Image $image
    )
    {
    }

    public function updateBlog()
    {

    }

    public function publishBlog(object $featuredImage, array $blogData)
    {
       
        // Check for empty fields        
        foreach ($blogData as $key => $value) {
            if ($key == 'slug') {
                continue;
            } elseif (empty($key) || $key == 'category' && $value == 'None') {
                return false;
            }
        }

        if ($this->image->exists($featuredImage)) {
            $imagePath = $this->image->save($featuredImage, 'posts');
        }
        
        $blogData += ['featured-image' => $imagePath ?? 0];

        // If verified means blog is stored
        if ($this->blog->verify($blogData) !== true) {
            return $this->blog->publish();
        }

        return false;
    }

    public function deleteBlog()
    {
        
    }

}