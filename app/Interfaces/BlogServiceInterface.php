<?php

namespace Storylog\Interfaces;

use Storylog\Model\Image;
use Storylog\Model\Blog;

interface BlogServiceInterface
{
    public function __construct(Blog $blog, Image $image);

    public function publishBlog(object $featuredImage, array $blogData);
}