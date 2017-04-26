<?php

namespace OCA\BagIt\Controller;

use OCA\BagIt\Service\BagItService;
use OCP\AppFramework\Http\RedirectResponse;
use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;


class ViewController extends Controller {

    protected $service;
    protected $fileView;

    public function __construct($appName, IRequest $request, BagItService $service) {

        parent::__construct($appName, $request);

        $this->service = $service;


    }

    /**
     * CAUTION: the @Stuff turns off security checks; for this page no admin is
     *          required and no CSRF check. If you don't know what CSRF is, read
     *          it up in the docs or you might create a security hole. This is
     *          basically the only required method to add this exemption, don't
     *          add it to any other method if you don't exactly know what it does
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     */

    public function index() {
        return new TemplateResponse('bagit', 'index');  // templates/index.php
    }

    public function availableBags()
    {

        return new DataResponse($this->service->getBags());

    }

    public function create($id)
    {

        $this->service->createBag($id);

        return new DataResponse($id);

    }

    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     */

    public function show($id)
    {

        return new TemplateResponse('bagit', 'show', ['items' => $this->service->getABag($id)]);

    }

}
