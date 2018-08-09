<?php

declare(strict_types=1);

namespace Brain\Common\Database;

use Brain\Common\Database\Repository\AbstractEntityRepository;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

interface DatabaseInterface
{
    /**
     * Return the doctrine entity manager.
     */
    public function getEntityManager(): EntityManagerInterface;

    /**
     * Return the doctrine connection.
     */
    public function getConnection(): Connection;

    /**
     * Return the entity repository for the given entity.
     */
    public function getRepository(string $entity): AbstractEntityRepository;
}
