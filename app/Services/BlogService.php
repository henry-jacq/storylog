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

        if ($this->image->checkError($featuredImage)) {
            $imagePath = $this->image->save($featuredImage, 'posts');
        }
        
        $blogData += ['featured-image' => $imagePath ?? 0];

        // If verified means blog is stored
        if ($this->blog->verifySlug($blogData) !== true) {
            return $this->blog->publish();
        }

        return false;
    }

    public function updateBlog(int $blogId, array $data)
    {
        $this->blog->update($blogId, $data);
    }

    public function getBlog(string $slug)
    {
        $blog = $this->blog->getBlog($slug);
        
        if ($blog['featured_image'] != 0) {
            $old = $blog['featured_image'];
            $blog['featured_image'] = '/files' . $old;
        }

        return $blog;
    }

    public function getUserBlogs(int $uid)
    {
        $this->blog->getUserBlogs($uid);
    }

    public function getAllBlogs()
    {
        return $this->blog->getAllBlogs();
    }
    
    public function deleteBlog(int $blogId)
    {
        return $this->blog->delete($blogId);
    }

    /**
     * Check if the file exist in storage
     */
    public function imageExists(string $path)
    {
        return $this->image->exists($path);
    }

    public function getImage(string $path)
    {
        return $this->image->getImage($path);
    }
}