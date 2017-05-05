<?php

namespace OCA\Bagit\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;

use OCA\BagIt\Service\BagitService;

class BagItController extends Controller
{

    use Errors;

    private $service;
    private $activityManager;

    public function __construct($appName, IRequest $request, BagitService $service)
    {

        parent::__construct($appName, $request);

        $this->service = $service;
        $this->activityManager = \OC::$server->getActivityManager();


    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */

    public function indexView()
    {

        return new TemplateResponse('bagit', 'index');
    }

    /**
     * @NoAdminRequired
     */
    public function index() {
        return new DataResponse($this->service->index());
    }

    /**
     * @NoAdminRequired
     *
     * @param int $file_id
     */
    public function show($id)
    {
        return $this->handleNotFound(function () use ($id) {
            return $this->service->show($id);
        });
    }

    /**
     * @NoAdminRequired
     *
     * @param string $title
     * @param string $content
     */

    public function create($id)
    {
        return $this->service->create($id);
    }

    public function validate()
    {
        $valid = $this->service->validate();
        return $valid;
    }

}
