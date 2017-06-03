<?php
namespace OCA\BagIt\Db;

use OCP\IDBConnection;
use OCP\AppFramework\Db\Mapper;

class BagMapper extends Mapper
{

    public function __construct(IDBConnection $db) {

        parent::__construct($db, 'bagit_bags', '\OCA\BagIt\Db\Bag');

    }

    public function findByBagId($bagId, $userId) {

        $sql = 'SELECT * FROM *PREFIX*bagit_bags WHERE bag_id = ? AND user_id = ?';
        return $this->findEntities($sql, [$bagId, $userId]);

    }

	public function findByFileId($fileId, $userId) {

		$sql = 'SELECT * FROM *PREFIX*bagit_bags WHERE file_id = ? AND user_id = ?';
		return $this->findEntities($sql, [$fileId, $userId]);

	}

    public function findAll($userId) {
        $sql = 'SELECT * FROM *PREFIX*bagit_bags WHERE user_id = ?';
        return $this->findEntities($sql, [$userId]);
    }

}