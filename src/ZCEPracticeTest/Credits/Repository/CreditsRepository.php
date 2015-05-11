<?php

/**
 * PHP version 5.5
 *
 * @category Repository
 * @package  Credits
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Credits\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Answer entity
 *
 * @category Repository
 * @package  Credits
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class CreditsRepository extends EntityRepository
{
    public function loadCreditsData($userId)
    {
        $q = $this->createQueryBuilder('c')
            ->addSelect('u')
            ->leftJoin('c.user', 'u')
            ->where('u.id = :userId')
            ->setParameters(array(
                ':userId' => $userId,
            ))
        ;
        
        return $q->getQuery()->getOneOrNullResult();
    }
}
