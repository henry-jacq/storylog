<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    /**
     * Storage Path for the user avatars
     */
    private string $storagePath = STORAGE_PATH . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR;

    public function __construct(private EntityManagerInterface $em)
    {
        if (!file_exists($this->storagePath)) {
            mkdir($this->storagePath, 0777, true);
        }
    }

    /**
     * Create a new user
     */
    public function createUser(User $user): User
    {
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     * Delete the user
     */
    public function deleteUser(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    /**
     * Get the user by id
     */
    public function getUserById(int $id): ?User
    {
        $user = $this->em->getRepository(User::class)->find($id);
        return $user;
    }

    /**
     * Get the user by email or username
     */
    public function getByUsername(string $username): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy(['username' => $username]);
    }
}