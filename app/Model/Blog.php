<?php

namespace Storylog\Model;

use Exception;
use Storylog\Core\Database;

class Blog
{
    private $blogData;
    private $table = 'blog';
    
    public function __construct(private readonly Database $conn)
    {

        $this->conn->setTable($this->table);
    }

    /**
     * Publish the blog
     */
    public function publish()
    {
        $publishBlog = [
            'uid' => 6,
            'title' => $this->blogData['title'],
            'slug' => $this->blogData['slug'],
            'featured_image' => $this->blogData['featured-image'],
            'category' => $this->blogData['category'],
            'excerpt' => $this->blogData['excerpt'],
            'content' => $this->blogData['content'],
            'published_at' => now(),
            'updated_at' => now(),
        ];

        return $this->conn->insert($publishBlog);
    }

    /**
     * Verify the blog data
     */
    public function verify(array $data)
    {
        $this->blogData = $data;
                
        // Update the slug
        $this->blogData['slug'] = $this->CreateSlug($data['slug']);
        
        return $this->slugExists($this->blogData['slug']);
    }

    /**
     * Check if the slug of the blog exists
     */
    public function slugExists(string $slug): bool
    {
        try {
            $query = "SELECT * FROM $this->table WHERE slug = ?";

            if ($this->conn->getCount($query, [$slug]) == 1) {
                return true;
            }

            return false;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Create a SEO friendly slug for blog post
     */
    public function createSlug($slug, $separator = '-')
    {
        // Remove special characters & replace spaces with the separator
        $slug = preg_replace('/[^a-z0-9]+/', $separator, strtolower($slug));

        // Trim leading/trailing separator
        $slug = trim($slug, $separator);

        // If the final slug is empty, create a default slug
        if (empty($slug)) {
            $slug = 'untitled-' . md5(uniqid().microtime());
        }

        return $slug;
    }
}