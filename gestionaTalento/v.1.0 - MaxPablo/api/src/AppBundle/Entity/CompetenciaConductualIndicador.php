<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompetenciaConductualIndicador
 *
 * @ORM\Table(name="competenciaConductualIndicador")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompetenciaConductualIndicadorRepository")
 */
class CompetenciaConductualIndicador
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
     * @ORM\Column(name="competenciaConductual_id", type="integer")
     */
    private $competenciaConductualId;

    /**
     * @var int
     *
     * @ORM\Column(name="indicador_id", type="integer")
     */
    private $indicadorId;


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
     * Set competenciaConductualId
     *
     * @param integer $competenciaConductualId
     *
     * @return CompetenciaConductualIndicador
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

    /**
     * Set indicadorId
     *
     * @param integer $indicadorId
     *
     * @return CompetenciaConductualIndicador
     */
    public function setIndicadorId($indicadorId)
    {
        $this->indicadorId = $indicadorId;

        return $this;
    }

    /**
     * Get indicadorId
     *
     * @return int
     */
    public function getIndicadorId()
    {
        return $this->indicadorId;
    }
}
