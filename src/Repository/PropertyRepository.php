<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertyFilterSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Property $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Property $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Property[] Returns an array of the last 4 propereties published
     */
    public function findLatest()
    {
        return $this->findVisibleQuery()
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    /**
     * Select properties that have not been sold
     */
    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sold = false');
    }

    /**
     * Return list of properties by filtering
     *
     * @return Property[]
     */
    public function findBySearch(PropertyFilterSearch $search)
    {
        $query = $this->findVisibleQuery();

        if ($search->getMinSurface()) {
            $query = $query->andWhere('p.surface >= :minsurface');
            $query->setParameter('minsurface', $search->getMinSurface());
        }
        if ($search->getMaxSurface()) {
            $query = $query->andWhere('p.surface <= :minsurface');
            $query->setParameter('maxsurface', $search->getMaxSurface());
        }
        if ($search->getMinValue()) {
            $query = $query->andWhere('p.price >= :minprice');
            $query->setParameter('minprice', $search->getMinValue());
        }
        if ($search->getMaxValue()) {
            $query = $query->andWhere('p.price <= :maxprice');
            $query->setParameter('maxprice', $search->getMaxValue());
        }
        if ($search->getRooms()) {
            $query = $query->andWhere('p.rooms >= :minrooms');
            $query->setParameter('minrooms', $search->getRooms());
        }
        if ($search->getBedRooms()) {
            $query = $query->andWhere('p.bedrooms >= :minbedrooms');
            $query->setParameter('minbedrooms', $search->getBedRooms());
        }
        if ($search->getHeat()) {
            $query = $query->andWhere('p.heat >= :heat');
            $query->setParameter('heat', (int) $search->getHeat());
        }
        if ($search->getCity()) {
            $query = $query->andWhere('p.city LIKE :city');
            $query->setParameter('city', '%' . $search->getCity() . '%');
        }
        if ($search->getOptions()) {
            foreach ($search->getOptions() as $k => $option) {
                $query = $query
                    ->andWhere(":option$k MEMBER OF p.options")
                    ->setParameter("option$k", $option);
            }
        }


        return $query
            ->getQuery()
            ->getResult();
    }

    /**
     * returns the highest property price
     *
     * @return int
     */
    public function findMaxPrice()
    {
        return $this->findVisibleQuery()
            ->select('MAX(p.price)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value, $limit, $offset): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
