<?php
namespace OCA\BagIt\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Bag extends Entity implements JsonSerializable
{

    protected $userId;
	protected $fileId;
	protected $bagId;
    protected $status;
    protected $timestamp;


    public function jsonSerialize()
    {

        return [

            'id' => $this->id,
            'user_id' => $this->userId,
			'file_id' => $this->fileId,
			'bag_id' => $this->bagId,
            'status' => $this->status,
            'timestamp' => $this->timestamp

        ];

    }


}