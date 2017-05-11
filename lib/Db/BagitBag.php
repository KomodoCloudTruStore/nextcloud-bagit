<?php

namespace OCA\Bagit\Db;

use OCP\AppFramework\Db\Entity;
use JsonSerializable;

class BagitBag extends Entity implements JsonSerializable
{

    protected $fileId;
    protected $name;
    protected $replicaD;
    protected $replicaSm;
    protected $size;
    protected $timestamp;

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'replica_d' => $this->replicaD,
            'replica_sm' => $this->replicaSm,
            'size' => $this->size,
            'timestamp' => $this->timestamp
        ];
    }
}