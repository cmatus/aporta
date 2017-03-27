<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Ucl;

class UclController extends FOSRestController {
  /**
  * @Rest\Get("/ucl")
  */
 public function getAction()
 {
   $restresult = $this->getDoctrine()->getRepository('AppBundle:Ucl')->findAll();
     if ($restresult === null) {
       return new View("no hay nada", Response::HTTP_NOT_FOUND);
  }
     return $restresult;
 }

 /**
  * @Rest\Get("/ucl/{id}")
  */
 public function idAction($id) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:Ucl')->find($id);
     if ($singleresult === null) {
         return new View("UCL no encontrado", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }

 /**
  * @Rest\Get("/ucl/nombre/{nombre}")
  */
 public function nombreAction($nombre) {
     $singleresult = $this->getDoctrine()->getRepository('AppBundle:Ucl')->findBy(array('nombre' => $nombre));
     if ($singleresult === null) {
         return new View("UCL no encontrado", Response::HTTP_NOT_FOUND);
     }
     return $singleresult;
 }



  /**
   * @Rest\Post("/ucl")
   */
  public function postAction(Request $request) {
      $data = new Ucl;
      $nombre = $request->get('nombre');
      $definicion = $request->get('definicion');
      if (empty($nombre) || empty($definicion)) {
          return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
      }
      $data->setNombre($nombre);
      $data->setDefinicion($definicion);
      $em = $this->getDoctrine()->getManager();
      $em->persist($data);
      $em->flush();
      return new View("UCL Agregado Correctamente", Response::HTTP_OK);
  }

  /**
   * @Rest\Put("/ucl/{id}")
   */
  public function updateAction($id, Request $request) {
      $data = new Ucl;
      $nombre = $request->get('nombre');
      $definicion = $request->get('definicion');
      $sn = $this->getDoctrine()->getManager();
      $ucl = $this->getDoctrine()->getRepository('AppBundle:Ucl')->find($id);
      if (empty($ucl)) {
          return new View("ucl not encontrado", Response::HTTP_NOT_FOUND);
      } elseif (!empty($nombre) && !empty($definicion)) {
          $ucl->setNombre($nombre);
          $ucl->setDefinicion($definicion);
          $sn->flush();
          return new View("ucl Actualizado Correctamente", Response::HTTP_OK);
      } else
          return new View("Los datos nombre y definicion de UCL no pueden estar vacios!", Response::HTTP_NOT_ACCEPTABLE);
  }

  /**
   * @Rest\Delete("/ucl/{id}")
   */
  public function deleteAction($id) {
      $data = new Ucl;
      $sn = $this->getDoctrine()->getManager();
      $ucl = $this->getDoctrine()->getRepository('AppBundle:Ucl')->find($id);
      if (empty($ucl)) {
          return new View("No se encontro el UCL", Response::HTTP_NOT_FOUND);
      } else {
          $sn->remove($ucl);
          $sn->flush();
      }
      return new View("UCL borrado Exitosamente!", Response::HTTP_OK);
  }
}
