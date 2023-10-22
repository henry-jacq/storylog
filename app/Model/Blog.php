<?php

declare(strict_types=1);

namespace Storylog\Model;

use Exception;
use Carbon\Carbon;
use Storylog\Model\User;
use Storylog\Core\Database;

class Blog
{
    private $blogData;
    private $table = 'blog';
    
    public function __construct(
        private readonly User $user,
        private readonly Database $db,
    )
    {
        $this->db->setTable($this->table);
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

        try {
            $this->db->insert($publishBlog);
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Verify if the slug of the blog exists or not
     */
    public function verifySlug(array $data)
    {
        $this->blogData = $data;

        // Update the slug
        $this->blogData['slug'] = $this->CreateSlug($data['slug']);
        
        try {
            $query = "SELECT * FROM $this->table WHERE slug = ?";

            if ($this->db->getCount($query, [$this->blogData['slug']]) == 1) {
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

    /**
     * Delete a blog post
     */
    public function delete(string $blogId)
    {
        try {
            $this->db->delete(['id' => $blogId], $limit = 1);
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update a blog post
     */
    public function update(int $blogId, array $data)
    {        
        $newData = [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'featured_image' => $data['featured-image'],
            'category' => $data['category'],
            'excerpt' => $data['excerpt'],
            'content' => $data['content'],
            'updated_at' => now(),
        ];

        // here check for empty key and then remove those keys

        try {
            $this->db->update($newData, ['id' => $blogId]);
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Return all blog entries
     */
    public function getAllBlogs()
    {
        $blogData = $this->db->run("SELECT * FROM $this->table ORDER BY `published_at` DESC")->fetchAll();

        $updatedData = [];

        foreach ($blogData as $key => $value) {           
            $value['published_at'] = $this->formatTime($value['published_at']);
            $value['updated_at'] = $this->formatTime($value['updated_at']);
            $value['user_data'] = $this->user->getUserById($value['uid']);
            $updatedData[$key] = $value;
        }

        return $updatedData;
    }

    /**
     * Return blog by slug
     */
    public function getBlog(string $slug)
    {
        try {
            $blog = $this->db->run("SELECT * FROM $this->table WHERE slug = ?", [$slug])->fetch();
            
            $blog['published_at'] = $this->formatTime($blog['published_at']);
            $blog['updated_at'] = $this->formatTime($blog['updated_at']);
            $blog['user_data'] = $this->user->getUserById($blog['uid']);

            return $blog;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getUserBlogs(int $uid)
    {
        try {
            return $this->db->run("SELECT * FROM $this->table WHERE uid = ?", [$uid])->fetchAll();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function formatTime($time)
    {
        $time = Carbon::parse($time);
        return $time->diffForHumans();
    }
}