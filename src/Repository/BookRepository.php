<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findByCategory(string $categoryName): array
    {
        return $this->createQueryBuilder('b')
            ->join('b.categories', 'c')
            ->andWhere('c.name = :name')
            ->setParameter('name', $categoryName)
            ->getQuery()
            ->getResult();
    }

    public function findByFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('b');

        if (!empty($filters['titre'])) {
            $qb->andWhere('LOWER(b.titre) LIKE :titre')
                ->setParameter('titre', '%' . strtolower($filters['titre']) . '%');
        }

        if (!empty($filters['auteur'])) {
            $qb->andWhere('LOWER(b.auteur) LIKE :auteur')
                ->setParameter('auteur', '%' . strtolower($filters['auteur']) . '%');
        }

        if (!empty($filters['categorie'])) {
            $qb->join('b.categories', 'c')
                ->andWhere('LOWER(c.name) LIKE :categorie')
                ->setParameter('categorie', '%' . strtolower($filters['categorie']) . '%');
        }

        return $qb->getQuery()->getResult();
    }

}
