<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\CompetenciaConductualIndicador;

class CompetenciaConductualIndicadorController extends FOSRestController {
  /**
  * @Rest\Get("/competenciaConductualIndicador")
  */
 public function getAction()
 {
   $restresult = $this->getDoctrine()->getRepository('AppBundle:CompetenciaConductualIndicador')->findAll();
     if ($restresult === null) {
       return new View("no hay nada", Response::HTTP_NOT_FOUND);
  }
     return $restresult;
 }

 /**
  * @Rest\Get("/competenciaConductualIndicador/{id}")
  */
 public function idAction($id) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:CompetenciaConductualIndicador')->find($id);
     if ($singleresult === null) {
         return new View("CompetenciaConductualIndicador no encontrado", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

  /**
   * @Rest\Post("/competenciaConductualIndicador")
   */
  public function postAction(Request $request) {
      $data = new CompetenciaConductualIndicador;
      $competenciaConductualId = $request->get('competenciaConductualId');
      $indicadorId = $request->get('indicadorId');
      if (empty($competenciaConductualId) || empty($indicadorId)) {
          return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
      }
      $data->setCompetenciaConductualID($competenciaConductualId);
      $data->setIndicadorId($indicadorId);
      $em = $this->getDoctrine()->getManager();
      $em->persist($data);
      $em->flush();
      return new View("CompetenciaConductualIndicador Agregada Correctamente", Response::HTTP_OK);
  }

  /**
   * @Rest\Put("/competenciaConductualIndicador/{id}")
   */
  public function updateAction($id, Request $request) {
      $data = new CompetenciaConductualIndicador;
      $competenciaConductualId = $request->get('competenciaConductualId');
      $indicadorId = $request->get('indicadorId');
      $sn = $this->getDoctrine()->getManager();
      $competenciaConductualIndicador = $this->getDoctrine()->getRepository('AppBundle:CompetenciaConductualIndicador')->find($id);
      if (empty($competenciaConductualIndicador)) {
          return new View("competenciaConductualIndicador not found", Response::HTTP_NOT_FOUND);
      } elseif (!empty($competenciaConductualId) && !empty($indicadorId)) {
          $competenciaConductualIndicador->setCompetenciaConductualId($competenciaConductualId);
          $competenciaConductualIndicador->setIndicadorId($indicadorId);
          $sn->flush();
          return new View("competenciaConductualIndicador Actualizado Correctamente", Response::HTTP_OK);
      } else
          return new View("el nombre de la CompetenciaConductualIndicador no puede estar vacio!", Response::HTTP_NOT_ACCEPTABLE);
  }

  /**
   * @Rest\Delete("/competenciaConductualIndicador/{id}")
   */
  public function deleteAction($id) {
      $data = new CompetenciaConductualIndicador;
      $sn = $this->getDoctrine()->getManager();
      $competenciaConductualIndicador = $this->getDoctrine()->getRepository('AppBundle:CompetenciaConductualIndicador')->find($id);
      if (empty($competenciaConductualIndicador)) {
          return new View("No se encontro el CompetenciaConductualIndicador", Response::HTTP_NOT_FOUND);
      } else {
          $sn->remove($competenciaConductualIndicador);
          $sn->flush();
      }
      return new View("CompetenciaConductualIndicador borrado Exitosamente!", Response::HTTP_OK);
  }
}
