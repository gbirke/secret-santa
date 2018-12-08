<?php

namespace App\Repository;

use App\Entity\Donor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Donor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Donor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Donor[]    findAll()
 * @method Donor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Donor::class);
    }

    public function countSubmissions(): int {
    	$qb = $this->getEntityManager()->createQueryBuilder();
    	$qb->select( 'COUNT(donor.id)' )
			->from( Donor::class, 'donor' )
			->where( 'donor.submitted != 0' );
    	return $qb->getQuery()->getSingleScalarResult();
	}

	public function countMissingSubmissions(): int {
		$qb = $this->getEntityManager()->createQueryBuilder();
		$qb->select( 'COUNT(donor.id)' )
			->from( Donor::class, 'donor' )
			->where( 'donor.submitted = 0' );
		return $qb->getQuery()->getSingleScalarResult();
	}


	/**
	 * @throws \Doctrine\ORM\NoResultException
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function findOneByAccessCode( string $accessCode ): ?Donor
	{
		return $this->createQueryBuilder('d')
			->andWhere('d.accessCode = :code')
			->setParameter('code', $accessCode)
			->getQuery()
			->getSingleResult()
			;
	}

	public function getReceiversForDonor( Donor $donor )
	{
		return $this->createQueryBuilder('d')
			->andWhere('d.id != :id')
			->setParameter('id', $donor->getId())
			->orderBy('d.name', 'ASC')
			->getQuery()
			->getResult()
			;
	}

    // /**
    //  * @return Donor[] Returns an array of Donor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Donor
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
