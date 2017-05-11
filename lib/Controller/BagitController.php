<?php
namespace OCA\Bagit\Controller;

use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;

use OCA\Bagit\Service\BagitService;

class BagitController extends Controller
{

    use Errors;

    private $service;

    public function __construct($AppName, IRequest $request, BagitService $service)
    {

        parent::__construct($AppName, $request);

        $this->service = $service;

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
     * @param int $id
     */

    public function show($id)
    {
        return new DataResponse($this->service->show($id));
    }

    /**
     * @NoAdminRequired
     */

    public function create($id)
    {
        return $this->service->create($id);
    }

}
