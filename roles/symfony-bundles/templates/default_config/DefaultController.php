<?php

namespace {{namespace}}\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package {{namespace}}\Controller
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@{{ project_name|title }}{{core_bundle_name}}/Default/index.html.twig');
    }
}
