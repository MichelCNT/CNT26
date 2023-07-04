<?php

namespace App\Repository;

use App\Entity\Article;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $entity, bool $flush = false): void
    {
        $entity->setCreatedAt(new DateTimeImmutable);
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findByCategory($actualArticle, $cat, $limit): array
   {
       $result = $this->createQueryBuilder('article')
           ->andWhere('article.categorie = :cat')
           ->andWhere('article.id != :actualArticle')
           ->setParameter('cat', $cat)
           ->setParameter('actualArticle', $actualArticle)
           ->orderBy('article.createdAt', 'DESC')
           ->getQuery()
           ->getResult();

       if (sizeof($result) > $limit) {
           return array_slice($result, 0, $limit);
       } else return $result;
   }

    public function getLatestArticle($limit)
    {
        return $this->createQueryBuilder('article')
            ->orderBy('article.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
