<?php

namespace Brain\Common\Database;

use Brain\Common\Database\Repository\AbstractEntityRepository;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

interface DatabaseInterface
{
    /**
     * Return the doctrine entity manager.
     *
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface;

    /**
     * Return the doctrine connection.
     *
     * @return Connection
     */
    public function getConnection(): Connection;

    /**
     * Return the entity repository for the given entity.
     *
     * @param string $entity
     *
     * @return AbstractEntityRepository
     */
    public function getRepository(string $entity): AbstractEntityRepository;
}
