<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdProjectContainerUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
        }

        if (0 === strpos($pathinfo, '/empresa')) {
            // app_empresa_get
            if ($pathinfo === '/empresa') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_app_empresa_get;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\EmpresaController::getAction',  '_route' => 'app_empresa_get',);
            }
            not_app_empresa_get:

            // app_empresa_id
            if (preg_match('#^/empresa/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_app_empresa_id;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_empresa_id')), array (  '_controller' => 'AppBundle\\Controller\\EmpresaController::idAction',));
            }
            not_app_empresa_id:

            if (0 === strpos($pathinfo, '/empresa/r')) {
                // app_empresa_rut
                if (0 === strpos($pathinfo, '/empresa/rut') && preg_match('#^/empresa/rut/(?P<rut>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_empresa_rut;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_empresa_rut')), array (  '_controller' => 'AppBundle\\Controller\\EmpresaController::rutAction',));
                }
                not_app_empresa_rut:

                // app_empresa_razonsocial
                if (0 === strpos($pathinfo, '/empresa/razonSocial') && preg_match('#^/empresa/razonSocial/(?P<razonSocial>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_empresa_razonsocial;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_empresa_razonsocial')), array (  '_controller' => 'AppBundle\\Controller\\EmpresaController::razonSocialAction',));
                }
                not_app_empresa_razonsocial:

            }

            // app_empresa_post
            if ($pathinfo === '/empresa') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_app_empresa_post;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\EmpresaController::postAction',  '_route' => 'app_empresa_post',);
            }
            not_app_empresa_post:

        }

        // app_empresa_update
        if (0 === strpos($pathinfo, '/perfil') && preg_match('#^/perfil/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            if ($this->context->getMethod() != 'PUT') {
                $allow[] = 'PUT';
                goto not_app_empresa_update;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_empresa_update')), array (  '_controller' => 'AppBundle\\Controller\\EmpresaController::updateAction',));
        }
        not_app_empresa_update:

        // app_empresa_delete
        if (0 === strpos($pathinfo, '/empresa') && preg_match('#^/empresa/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            if ($this->context->getMethod() != 'DELETE') {
                $allow[] = 'DELETE';
                goto not_app_empresa_delete;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_empresa_delete')), array (  '_controller' => 'AppBundle\\Controller\\EmpresaController::deleteAction',));
        }
        not_app_empresa_delete:

        if (0 === strpos($pathinfo, '/per')) {
            if (0 === strpos($pathinfo, '/perfil')) {
                // app_perfil_get
                if ($pathinfo === '/perfil') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_perfil_get;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PerfilController::getAction',  '_route' => 'app_perfil_get',);
                }
                not_app_perfil_get:

                // app_perfil_id
                if (preg_match('#^/perfil/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_perfil_id;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_perfil_id')), array (  '_controller' => 'AppBundle\\Controller\\PerfilController::idAction',));
                }
                not_app_perfil_id:

                // app_perfil_nombre
                if (0 === strpos($pathinfo, '/perfil/nombre') && preg_match('#^/perfil/nombre/(?P<nombre>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_perfil_nombre;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_perfil_nombre')), array (  '_controller' => 'AppBundle\\Controller\\PerfilController::nombreAction',));
                }
                not_app_perfil_nombre:

                // app_perfil_reporta
                if (0 === strpos($pathinfo, '/perfil/reporta') && preg_match('#^/perfil/reporta/(?P<reporta>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_perfil_reporta;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_perfil_reporta')), array (  '_controller' => 'AppBundle\\Controller\\PerfilController::reportaAction',));
                }
                not_app_perfil_reporta:

                // app_perfil_post
                if ($pathinfo === '/perfil') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_app_perfil_post;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PerfilController::postAction',  '_route' => 'app_perfil_post',);
                }
                not_app_perfil_post:

                // app_perfil_update
                if (preg_match('#^/perfil/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_app_perfil_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_perfil_update')), array (  '_controller' => 'AppBundle\\Controller\\PerfilController::updateAction',));
                }
                not_app_perfil_update:

                // app_perfil_delete
                if (preg_match('#^/perfil/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_app_perfil_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_perfil_delete')), array (  '_controller' => 'AppBundle\\Controller\\PerfilController::deleteAction',));
                }
                not_app_perfil_delete:

            }

            if (0 === strpos($pathinfo, '/persona')) {
                // app_persona_get
                if ($pathinfo === '/persona') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_persona_get;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PersonaController::getAction',  '_route' => 'app_persona_get',);
                }
                not_app_persona_get:

                // app_persona_id
                if (preg_match('#^/persona/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_persona_id;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_persona_id')), array (  '_controller' => 'AppBundle\\Controller\\PersonaController::idAction',));
                }
                not_app_persona_id:

                // app_persona_rut
                if (0 === strpos($pathinfo, '/persona/rut') && preg_match('#^/persona/rut/(?P<rut>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_persona_rut;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_persona_rut')), array (  '_controller' => 'AppBundle\\Controller\\PersonaController::rutAction',));
                }
                not_app_persona_rut:

                // app_persona_nombre
                if (0 === strpos($pathinfo, '/persona/nombre') && preg_match('#^/persona/nombre/(?P<nombre>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_persona_nombre;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_persona_nombre')), array (  '_controller' => 'AppBundle\\Controller\\PersonaController::nombreAction',));
                }
                not_app_persona_nombre:

                if (0 === strpos($pathinfo, '/persona/apellido')) {
                    // app_persona_paterno
                    if (0 === strpos($pathinfo, '/persona/apellidoPaterno') && preg_match('#^/persona/apellidoPaterno/(?P<apellidoPaterno>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_app_persona_paterno;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_persona_paterno')), array (  '_controller' => 'AppBundle\\Controller\\PersonaController::paternoAction',));
                    }
                    not_app_persona_paterno:

                    // app_persona_materno
                    if (0 === strpos($pathinfo, '/persona/apellidoMaterno') && preg_match('#^/persona/apellidoMaterno/(?P<apellidoMaterno>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_app_persona_materno;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_persona_materno')), array (  '_controller' => 'AppBundle\\Controller\\PersonaController::maternoAction',));
                    }
                    not_app_persona_materno:

                }

                // app_persona_post
                if ($pathinfo === '/persona') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_app_persona_post;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PersonaController::postAction',  '_route' => 'app_persona_post',);
                }
                not_app_persona_post:

                // app_persona_update
                if (preg_match('#^/persona/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_app_persona_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_persona_update')), array (  '_controller' => 'AppBundle\\Controller\\PersonaController::updateAction',));
                }
                not_app_persona_update:

                // app_persona_delete
                if (preg_match('#^/persona/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_app_persona_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_persona_delete')), array (  '_controller' => 'AppBundle\\Controller\\PersonaController::deleteAction',));
                }
                not_app_persona_delete:

            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
