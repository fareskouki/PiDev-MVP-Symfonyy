<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function save(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    public function findByProductName($term)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.nom LIKE :term')
            ->setParameter('term', '%'.$term.'%')
            ->getQuery()
            ->getResult();
    }
    
    public function findByCategorie($categorieId)
{
    return $this->createQueryBuilder('p')
        ->andWhere('p.id_categorie = :categorieId')
        ->setParameter('categorieId', $categorieId)
        ->getQuery()
        ->getResult();
}

    
    
    public function search($searchTerm)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.nom LIKE :searchTerm OR p.description LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->getQuery()
            ->getResult();
    }
    public function findByFilters($filters)
    {
        $qb = $this->createQueryBuilder('p');

        if (isset($filters['nom_produit'])) {
            $qb->andWhere('p.nom_produit LIKE :nom_produit')
                ->setParameter('nom_produit', '%' . $filters['nom_produit'] . '%');
        }

        if (isset($filters['prix_min'])) {
            $qb->andWhere('p.prix >= :prix_min')
                ->setParameter('prix_min', $filters['prix_min']);
        }

        if (isset($filters['prix_max'])) {
            $qb->andWhere('p.prix <= :prix_max')
                ->setParameter('prix_max', $filters['prix_max']);
        }

        if (isset($filters['categorie'])) {
            $qb->andWhere('p.id_categorie = :categorie')
                ->setParameter('categorie', $filters['categorie']);
        }

        return $qb->getQuery()->getResult();
    }
    public function findByExampleField($value): array
        {
            return $this->createQueryBuilder('p')
                ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
                ->orderBy('p.id', 'ASC')
                ->setMaxResults(2)
                ->getQuery()
                ->getResult()
        ;
    }

//    /**
//     * @return Produit[] Returns an array of Produit objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
