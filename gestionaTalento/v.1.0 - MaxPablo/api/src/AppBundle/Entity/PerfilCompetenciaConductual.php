<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PerfilCompetenciaConductual
 *
 * @ORM\Table(name="perfilCompetenciaConductual")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PerfilCompetenciaConductualRepository")
 */
class PerfilCompetenciaConductual
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="perfil_id", type="integer")
     */
    private $perfilId;

    /**
     * @var int
     *
     * @ORM\Column(name="competenciaConductual_id", type="integer")
     */
    private $competenciaConductualId;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set perfilId
     *
     * @param integer $perfilId
     *
     * @return PerfilCompetenciaConductual
     */
    public function setPerfilId($perfilId)
    {
        $this->perfilId = $perfilId;

        return $this;
    }

    /**
     * Get perfilId
     *
     * @return int
     */
    public function getPerfilId()
    {
        return $this->perfilId;
    }

    /**
     * Set competenciaConductualId
     *
     * @param integer $competenciaConductualId
     *
     * @return PerfilCompetenciaConductual
     */
    public function setCompetenciaConductualId($competenciaConductualId)
    {
        $this->competenciaConductualId = $competenciaConductualId;

        return $this;
    }

    /**
     * Get competenciaConductualId
     *
     * @return int
     */
    public function getCompetenciaConductualId()
    {
        return $this->competenciaConductualId;
    }
}
