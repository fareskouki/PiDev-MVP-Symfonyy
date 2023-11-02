<?php

namespace App\Repository;

use App\Entity\Reclamation;
use App\Entity\Repons;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Twilio\Rest\Client;

/**
 * @extends ServiceEntityRepository<Reclamation>
 *
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }

    public function save(Reclamation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reclamation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public  function sms()
    {
        // Your Account SID and Auth Token from twilio.com/console

        $sid = 'AC7a5eb816b1165309f12c5589afc6b543';
        $auth_token = '285d40520ef4fd61380f5cc126163dee';
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
        // A Twilio number you own with SMS capabilities
        $twilio_number = "+15676007363";

        $client = new Client($sid, $auth_token);
        $client->messages->create(
            // the number you'd like to send the message to
            '+21654804772',
            [
                // A Twilio phone number you purchased at twilio.com/console

                'from' => '+15676007363',
                // the body of the text message you'd like to send
                'body' => 'Une nouvelle reclamation a été ajouter merci de consulter la liste des reclamations pour plus de detail!'
            ]
        );
    }

    //    /**
    //     * @return Reclamation[] Returns an array of Reclamation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reclamation
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function searchReclamations($titre_rec)
    {
        $querybuilder = $this->createQueryBuilder('s')
            ->where('s.titre_rec LIKE :titre_rec')
            ->setParameter('titre_rec', '%' . $titre_rec . '%')
            ->getQuery()
            ->getResult();
        return $querybuilder;
    }
    public function orderByDest()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.Destination', 'ASC')
            ->getQuery()->getResult();
    }
    public function order_By_Nom()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.Nom_Voyage', 'ASC')
            ->getQuery()->getResult();
    }
    public function order_By_Date()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.date', 'ASC')
            ->getQuery()->getResult();
    }
    public function order_By_Prix()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.Prix_Voyage', 'ASC')
            ->getQuery()->getResult();
    }
}
