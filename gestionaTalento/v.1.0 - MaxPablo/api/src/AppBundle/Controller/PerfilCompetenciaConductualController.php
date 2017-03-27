<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\PerfilCompetenciaConductual;

class PerfilCompetenciaConductualController extends FOSRestController {

  /**
     * @Rest\Get("/perfilCompetenciaConductual")
     */
    public function getAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:PerfilCompetenciaConductual')->findAll();
        if ($restresult === null) {
          return new View("no hay registros de perfilCompetencia", Response::HTTP_NOT_FOUND);
     }
        return $restresult;
    }

  /**
  * @Rest\Get("/perfilCompetenciaConductual/{id}")
  */
  public function idAction($id)
  {
    $singleresult = $this->getDoctrine()->getRepository('AppBundle:PerfilCompetenciaConductual')->find($id);
    if ($singleresult === null) {
    return new View("PerfilCompetenciaConductual no encontrado", Response::HTTP_NOT_FOUND);
    }
  return $singleresult;
  }

  /**
  * @Rest\Post("/perfilCompetenciaConductual")
  */
  public function postAction(Request $request)
  {
    $data = new PerfilCompetenciaConductual;
    $perfilId = $request->get('perfilId');
    $competenciaConductualId = $request->get('competenciaConductualId');
  if(empty($perfilId) || empty($competenciaConductualId))
  {
    return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
  }
   $data->setPerfilId($perfilId);
   $data->setCompetenciaConductualId($competenciaConductualId);
   $em = $this->getDoctrine()->getManager();
   $em->persist($data);
   $em->flush();
   return new View("PerfilCompetenciaConductual agregado correctamente", Response::HTTP_OK);
  }

  /**
  * @Rest\Put("/perfilCompetenciaConductual/{id}")
  */
  public function updateAction($id,Request $request)
  {
  $data = new PerfilCompetenciaConductual;
  $perfilId = $request->get('perfilId');
  $competenciaConductualId = $request->get('competenciaConductualId');
  $sn = $this->getDoctrine()->getManager();
  $perfilCompetenciaConductual = $this->getDoctrine()->getRepository('AppBundle:PerfilCompetenciaConductual')->find($id);
 if (empty($perfilCompetenciaConductual)) {
    return new View("PerfilCompetenciaConductual no encontrado", Response::HTTP_NOT_FOUND);
  }
 elseif(!empty($perfilId) && !empty($competenciaConductualId)){
    $perfilCompetenciaConductual->setPerfilId($perfilId);
    $perfilCompetenciaConductual->setCompetenciaConductualId($competenciaConductualId);
    $sn->flush();
    return new View("PerfilCompetenciaConductual actualizado correctamente", Response::HTTP_OK);
  }
 else return new View("perfilId o competenciaConductualId no pueden estar vacios!", Response::HTTP_NOT_ACCEPTABLE);
  }

/**
 * @Rest\Delete("/perfilCompetenciaConductual/{id}")
 */
 public function deleteAction($id)
 {
  $data = new PerfilCompetenciaConductual;
  $sn = $this->getDoctrine()->getManager();
  $perfilCompetenciaConductual = $this->getDoctrine()->getRepository('AppBundle:PerfilCompetenciaConductual')->find($id);
if (empty($perfilCompetenciaConductual)) {
  return new View("perfilCompetenciaConductual no encontrado", Response::HTTP_NOT_FOUND);
 }
 else {
  $sn->remove($perfilCompetenciaConductual);
  $sn->flush();
 }
  return new View("borrado exitosamente", Response::HTTP_OK);
}


}
