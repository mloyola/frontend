<?php

namespace Ecoin\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CiudadRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CiudadRepository extends EntityRepository
{
	public function findByPaisId($pais_id)
    {
        $query = $this->getEntityManager()->createQuery("
            SELECT ciudad
            FROM BackendBundle:Ciudad ciudad
            LEFT JOIN ciudad.pais pais
            WHERE pais.id = :pais_id
        ")->setParameter('pais_id', $pais_id);

        return $query->getResult();
    }
}