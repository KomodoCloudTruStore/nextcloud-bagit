<?php

namespace OCA\Bagit\Db;

use OCP\IDBConnection;
use OCP\AppFramework\Db\Mapper;

class BagitBagMapper extends Mapper
{
    public function __construct(IDBConnection $db)
    {
        parent::__construct($db, 'bagit_bags', '\OCA\Bagit\Db\BagitBag');
    }

    /**
     * @throws \OCP\AppFramework\Db\DoesNotExistException if not found
     * @throws \OCP\AppFramework\Db\MultipleObjectsReturnedException if more than one result
     */
    public function find($id)
    {
        $sql = 'SELECT * FROM `*PREFIX*bagit_bags` ' .
            'WHERE `id` = ?';
        return $this->findEntity($sql, [$id]);
    }

    public function findAll()
    {
        $sql = 'SELECT * FROM `*PREFIX*bagit_bags`';
        return $this->findEntities($sql);
    }

    public function show($file_id)
    {
        $sql = 'SELECT * FROM `*PREFIX*bagit_bags` ' .
            'WHERE `file_id` = ?';
        return $this->findEntities($sql, [$file_id]);
    }
}