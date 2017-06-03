<?php
namespace OCA\BagIt\Controller;

use Exception;

use OCP\IRequest;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;

use OCA\BagIt\Service\BagService;

class BagController extends Controller {

    private $service;
    private $userId;

    use Errors;

    public function __construct($AppName, IRequest $request, BagService $service, $UserId)
    {

        parent::__construct($AppName, $request);

        $this->service = $service;
        $this->userId = $UserId;

    }

    /**
     * @NoAdminRequired
	 *
	 * @param int $bagId
	 * @param int $fileId
     */

    public function index($bagId=null, $fileId=null)
    {

        if (!is_null($bagId)) {

			return new DataResponse($this->service->findByBagId($bagId, $this->userId));

		} elseif (!is_null($fileId)) {

			return new DataResponse($this->service->findByFileId($fileId, $this->userId));

		} else {

			return new DataResponse($this->service->findAll($this->userId));

		}

    }

    /**
     * @NoAdminRequired
     *
     * @param int $id
     */
    public function show($id)
    {

		return new DataResponse($this->service->showContent($id, $this->userId));

    }

    /**
     * @NoAdminRequired
     */

    public function create($fileId, $hash) {

        return $this->service->create($fileId, $this->userId, $hash);

    }

    /**
     * @NoAdminRequired
     */

    public function update() {

        return [];

    }

    /**
     * @NoAdminRequired
     *
     * @param int $id
     */

    public function destroy($id) {

        return $this->handleNotFound(function () use ($id) {

			return $this->service->delete($id, $this->userId);

        });

    }


}