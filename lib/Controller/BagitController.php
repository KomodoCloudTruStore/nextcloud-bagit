<?php

namespace OCA\BagIt\Controller;

use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;

use OCA\BagIt\Service\BagItService;

class BagitController extends Controller
{

    use Errors;

    private $service;
    private $activityManager;

    public function __construct($appName, IRequest $request, BagItService $service)
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
        return new JSONResponse($this->service->index());
    }

    /**
     * @NoAdminRequired
     *
     * @param int $file_id
     */

    public function show($id)
    {
        return new JSONResponse($this->service->show($id));
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
