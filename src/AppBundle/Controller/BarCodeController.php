<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 09/07/2018
 * Time: 16:53
 */

namespace AppBundle\Controller;


use AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BarCodeController extends Controller
{
    public function indexAction(Request $request)
    {


        return $this->render('@App/CodeBarre/index.html.twig', array(
            'barcodename' => $request->get('barcodename')
        ));


    }

}