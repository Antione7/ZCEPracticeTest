<?php

/**
 * PHP version 5.5
 *
 * @category Service
 * @package  Core
 * @author   Antoine Caplain <acaplain@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\Service;

use Doctrine\ORM\EntityManager;

/**
 * Close sessions timeout service.
 * 
 * Contains functions to be used by
 * the Close session timeout command.
 *
 * @category Service
 * @package  Core
 * @author   Antoine Caplain <acaplain@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class CloseSessionsTimeout
{
	/**
     * @var EntityManagerInterface
     */
    private $em;

	/**
	 * Constructor
	 *
     * @param Doctrine\ORM\EntityManager
     */
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	/**
     * Close sessions timeout
     * 
     * @return integer
     */
	public function closeSessionsTimeout()
	{
		$conn = $this->em->getConnection();
		$nbClosedSessions = $conn->executeUpdate('UPDATE zce_session SET status = 2 WHERE status IS NULL
		AND CURRENT_DATE() > DATE_ADD(dateStart, INTERVAL 90 MINUTE)');

		return (int) $nbClosedSessions;
	}
}