<?php
namespace OCA\BagIt\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Bag extends Entity implements JsonSerializable
{

    protected $userId;
	protected $fileId;
	protected $bagId;
    protected $hashType;
	protected $hashValue;
    protected $created;
	protected $updated;


    public function jsonSerialize()
    {

        return [

            'id' => $this->id,
            'user_id' => $this->userId,
			'file_id' => $this->fileId,
			'bag_id' => $this->bagId,
			'hash_type' => $this->hashType,
            'hash_value' => $this->hashValue,
            'created' => $this->created,
			'updated' => $this->updated

        ];

    }


}