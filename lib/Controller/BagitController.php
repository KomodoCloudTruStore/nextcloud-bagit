<?php
namespace OCA\Bagit\Controller;

use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\IServerContainer;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;

use OCA\Bagit\Service\BagitService;

class BagitController extends Controller
{

    use Errors;

    private $service;
    private $activityManager;

    public function __construct($AppName, IRequest $request, IServerContainer $server, BagitService $service)
    {

        parent::__construct($AppName, $request);

        $this->service = $service;
        $this->activityManager = $server->getActivityManager();

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
