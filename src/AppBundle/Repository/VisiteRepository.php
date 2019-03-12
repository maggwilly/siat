<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use AppBundle\Entity\PointVente;
use AppBundle\Entity\Client;
/**
 * VisiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VisiteRepository extends EntityRepository
{

  /**
  *Nombre de point de vente ayant des affiches
  * Nombre de point de vente qui s'approvisionne chez un agent commercial
  */

  public function excAppPeriode ($region=null, $startDate=null, $endDate=null){
    $em = $this->_em;
  $RAW_QUERY =($region!=null) ?'select avg(exc) as exc, avg(aff) as aff, avg(map) as map,avg(rpd) as rpd, avg(rpp) as rpp, avg(pas_client) as pasclient from( select avg( case when v.exc then 1 else 0 end) as exc, avg(case when v.aff then 1 else 0 end) as aff, avg(case when v.map then 1 else 0 end) as map, avg(case when v.rpd then 1 else 0 end) as rpd, avg(case when v.rpp then 1 else 0 end) as rpp, avg(case when v.pas_client then 1 else 0 end) as pas_client from visite v join point_vente pv on pv.id=v.point_vente_id and v.date>=:startDate and v.date<=:endDate and pv.ville=:region group by pv.id) pdv;':'select avg(exc) as exc, avg(aff) as aff, avg(map) as map,avg(rpd) as rpd, avg(rpp) as rpp, avg(pas_client) as pasclient from( select avg( case when v.exc then 1 else 0 end) as exc, avg(case when v.aff then 1 else 0 end) as aff, avg(case when v.map then 1 else 0 end) as map, avg(case when v.rpd then 1 else 0 end) as rpd, avg(case when v.rpp then 1 else 0 end) as rpp, avg(case when v.pas_client then 1 else 0 end) as pas_client from visite v join point_vente pv on pv.id=v.point_vente_id and v.date>=:startDate and v.date<=:endDate group by pv.id) pdv;';
  $statement = $em->getConnection()->prepare($RAW_QUERY);
        if($region!=null){
   $statement->bindValue('region', $region);
          }
    $startDate=new \DateTime($startDate);
    $endDate=new \DateTime($endDate);
     $statement->bindValue('startDate', $startDate->format('Y-m-d'));
     $statement->bindValue('endDate',  $endDate->format('Y-m-d'));
     $statement->execute();

      return  $result = $statement->fetchAll();
  }

  /**

  */

  public function excAppPeriodePDV ( PointVente $pointVente,$startDate=null, $endDate=null){
    $em = $this->_em;
  $RAW_QUERY ='select avg(exc) as exc, avg(aff) as aff, avg(map) as map, avg(rpd) as rpd, avg(rpp) as rpp, avg(pas_client) as pasclient, avg(sapp) as sapp, avg(pre) as pre from( select avg( case when v.exc then 1 else 0 end) as exc, avg(case when v.aff then 1 else 0 end) as aff, avg(case when v.sapp then 1 else 0 end) as sapp, avg(case when v.map then 1 else 0 end) as map, avg(case when v.pre then 1 else 0 end) as pre, avg(case when v.rpd then 1 else 0 end) as rpd, avg(case when v.rpp then 1 else 0 end) as rpp, avg(case when v.pas_client then 1 else 0 end) as pas_client from visite v join point_vente pv on pv.id=v.point_vente_id and v.date>=:startDate and v.date<=:endDate and v.point_vente_id=:pdv group by pv.id) pdv;';
  $statement = $em->getConnection()->prepare($RAW_QUERY);
   $statement->bindValue('pdv', $pointVente->getId());
    $startDate=new \DateTime($startDate);
    $endDate=new \DateTime($endDate);
     $statement->bindValue('startDate', $startDate->format('Y-m-d'));
     $statement->bindValue('endDate',  $endDate->format('Y-m-d'));
     $statement->execute();

      return  $result = $statement->fetchAll();
  }
  /**
  *Nombre de point de vente ayant des affiches

  * Nombre de point de vente qui s'approvisionne chez un agent commercial
  */
//doit se voir
  public function excAppDerniere ($region=null, $startDate=null, $endDate=null, PointVente $pointVente=null){
    $em = $this->_em;
   $RAW_QUERY =($region!=null) ?'select count(v.id) as nombre,count(v.aff) as aff, count(v.exc) as exc, count(v.pas_client) as pas_client, count(v.sapp) as sapp, count(v.map) as map, count(v.rpd) as rpd from (select v.id,v.date,v.aff, v.exc,v.pas_client, v.sapp,v.map,v.rpd from (select pv.id as pv , max(v.date) as date from point_vente pv join visite v  on pv.id=v.point_vente_id and v.date>=:startDate and v.date<=:endDate and pv.ville=:region group by  pv.id order by pv.id) as u  join  visite v on (u.pv=v.point_vente_id and u.date=v.date)) v;':'select count(v.id) as nombre,count(v.aff) as aff,count(v.pas_client) as pas_client, count(v.exc) as exc, count(v.sapp) as sapp, count(v.map) as map, count(v.rpd) as rpd from (select v.id,v.date,v.aff, v.exc,v.pas_client, v.sapp ,v.map ,v.rpd from (select pv.id as pv , max(v.date) as date from point_vente pv join visite v  on pv.id=v.point_vente_id and v.date>=:startDate and v.date<=:endDate  group by  pv.id order by pv.id) as u  join  visite v on (u.pv=v.point_vente_id and u.date=v.date)) v;';
  $statement = $em->getConnection()->prepare($RAW_QUERY);
        if($region!=null){
   $statement->bindValue('region', $region);
          }
    $startDate=new \DateTime($startDate);
    $endDate=new \DateTime($endDate);

     $statement->bindValue('startDate', $startDate->format('Y-m-d'));
     $statement->bindValue('endDate',  $endDate->format('Y-m-d'));
     $statement->execute();

      return  $result = $statement->fetchAll();
  }



   public function excAppParSemaine ($region=null, $startDate=null, $endDate=null){
    $em = $this->_em;
  $RAW_QUERY =($region!=null) ?'select v.weektext,count(v.map) as map, count(v.aff) as aff, count(v.exc) as exc, count(v.rpd) as rpd ,count(v.pre) as pre , count(v.pas_client) as presence,count(distinct pv) as nombre from (select pv, weektext,v.date,aff, exc,sapp,map,id, rpd,rpp,pre,pas_client from (select distinct pv.id as pv, v.week_text as weektext, max(v.date) as date from point_vente pv join visite v  on pv.id=v.point_vente_id and v.date>=:startDate and v.date<=:endDate and pv.ville=:region group by  pv.id,v.week_text order by date) u join visite v on v.point_vente_id=u.pv and u.date=v.date) v group by v.weektext;':'select v.weektext,count(v.map) as map, count(v.aff) as aff, count(v.exc) as exc, count(v.rpd) as rpd ,count(v.pre) as pre ,count(v.pas_client) as presence, count(distinct pv) as nombre from (select pv, weektext,v.date,aff, exc,sapp,map,id, rpd,rpp,pre,pas_client from (select distinct pv.id as pv, v.week_text as weektext, max(v.date) as date from point_vente pv join visite v  on pv.id=v.point_vente_id and v.date>=:startDate and v.date<=:endDate  group by  pv.id,v.week_text order by date) u join visite v on v.point_vente_id=u.pv and u.date=v.date) v group by v.weektext;';
    $statement = $em->getConnection()->prepare($RAW_QUERY);
        if($region!=null){
    $statement->bindValue('region', $region);
          }
    $startDate=new \DateTime($startDate);
    $endDate=new \DateTime($endDate);
     $statement->bindValue('startDate', $startDate->format('Y-m-d'));
     $statement->bindValue('endDate',  $endDate->format('Y-m-d'));
     $statement->execute();
      return  $result = $statement->fetchAll();
  }
  /**
  *Nombre total de visite effectue 
  */
    public function nombreVisite ($region=null, $startDate=null, $endDate=null, PointVente $pointVente=null){

        $qb = $this->createQueryBuilder('v')->join('v.pointVente','pv');
        if($region!=null){
           $qb->where('pv.ville=:ville')
          ->setParameter('ville', $region);
          }
          if($startDate!=null){
           $qb->andWhere('v.date>=:startDate')->setParameter('startDate', new \DateTime($startDate));
          }
          if($endDate!=null){
           $qb->andWhere('v.date<=:endDate')->setParameter('endDate',new \DateTime($endDate));
          }
   try {
     $qb->select('count(v.id) as nombreVisite');
         return $qb->getQuery()->getSingleScalarResult();  
   } catch (NoResultException $e) {
        return 0;
     }
  }



    /**
  *Nombre total de visite effectue par point de vente 
  */
  public function visites(Client $user=null,$region=null, $startDate=null, $endDate=null, PointVente $pointVente=null){

       $qb = $this->createQueryBuilder('v')->leftJoin('v.pointVente','pv');
        if($region!=null){
           $qb->where('pv.ville=:ville') ->setParameter('ville', $region);
          }
          if($user!=null){
           $qb->andWhere('v.user=:user') ->setParameter('user', $user);
          }
          if($startDate!=null){
           $qb->andWhere('v.date>=:startDate')->setParameter('startDate', new \DateTime($startDate));
          }
          if($endDate!=null){
           $qb->andWhere('v.date<=:endDate')->setParameter('endDate',new \DateTime($endDate));
          }
           if($pointVente!=null){
           $qb->andWhere('pv=:pointVente')->setParameter('pointVente',$pointVente);
          }
           $qb->orderBy('v.date','DESC');
          return $qb->getQuery()->getResult();
  }


    /**
  *Nombre total de visite effectue par point de vente 
  */
  public function visitesDetaillees($region=null, $startDate=null, $endDate=null){

  $em = $this->_em;
  $RAW_QUERY =($region!=null) ?'select v.id,v.auditeur, v.nom,v.matricule,v.date,v.map,v.exc,v.pre,v.rpd,v.rpp,v.sapp,v.pas_client,v.raison_pas_client,v.pas_ouvert,v.raison_pas_ouvert,v.commentaire,sum((case when produit=\'FKS\' then stock else 0 end)) as fks,sum((case when produit=\'FKL\' then stock else 0 end)) as fkl,sum((case when produit=\'FMT\' then stock else 0 end)) as fmt,sum((case when produit=\'FKM\' then stock else 0 end)) as fkm,sum((case when produit=\'DUNHIL\' then stock else 0 end)) as dunhil,sum((case when produit=\'L-M\' then stock else 0 end)) as l_m,sum((case when produit=\'MALBORO\' then stock else 0 end)) as malboro,sum((case when produit=\'SUPER MATCH\' then stock else 0 end)) as super_match  from (select v.id,c.nom as auditeur, pv.nom,pv.matricule,v.date, v.map,v.exc,v.pre,v.rpd,v.rpp,v.sapp,v.pas_client,v.raison_pas_client,v.pas_ouvert,v.raison_pas_ouvert,v.commentaire, s.produit_id as produit, s.stock from  point_vente pv   join  visite v on (pv.id=v.point_vente_id and v.date>=:startDate and v.date<=:endDate  and pv.ville=:region) join client c on c.id=v.user_id   join situation s on s.visite_id=v.id join produit p on s.produit_id=p.id ) v group by v.id, v.nom,v.map,v.exc,v.pre,v.rpd,v.rpp,v.sapp,v.pas_client,v.raison_pas_client,v.pas_ouvert,v.raison_pas_ouvert,v.commentaire,v.date,v.auditeur,v.matricule;
':'select v.id,v.auditeur, v.nom,v.matricule,v.date,v.map,v.exc,v.pre,v.rpd,v.rpp,v.sapp,v.pas_client,v.raison_pas_client,v.pas_ouvert,v.raison_pas_ouvert,v.commentaire,sum((case when produit=\'FKS\' then stock else 0 end)) as fks,sum((case when produit=\'FKL\' then stock else 0 end)) as fkl,sum((case when produit=\'FMT\' then stock else 0 end)) as fmt,sum((case when produit=\'FKM\' then stock else 0 end)) as fkm,sum((case when produit=\'DUNHIL\' then stock else 0 end)) as dunhil,sum((case when produit=\'L-M\' then stock else 0 end)) as l_m,sum((case when produit=\'MALBORO\' then stock else 0 end)) as malboro,sum((case when produit=\'SUPER MATCH\' then stock else 0 end)) as super_match  from (select v.id,c.nom as auditeur, pv.nom,pv.matricule,v.date, v.map,v.exc,v.pre,v.rpd,v.rpp,v.sapp,v.pas_client,v.raison_pas_client,v.pas_ouvert,v.raison_pas_ouvert,v.commentaire, s.produit_id as produit, s.stock from  point_vente pv   join  visite v on (pv.id=v.point_vente_id and v.date>=:startDate and v.date<=:endDate) join client c on c.id=v.user_id   join situation s on s.visite_id=v.id join produit p on s.produit_id=p.id ) v group by v.id, v.nom,v.map,v.exc,v.pre,v.rpd,v.rpp,v.sapp,v.pas_client,v.raison_pas_client,v.pas_ouvert,v.raison_pas_ouvert,v.commentaire,v.date,v.auditeur,v.matricule;
';
    $statement = $em->getConnection()->prepare($RAW_QUERY);
        if($region!=null){
    $statement->bindValue('region', $region);
          }
    $startDate=new \DateTime($startDate);
    $endDate=new \DateTime($endDate);
     $statement->bindValue('startDate', $startDate->format('Y-m-d'));
     $statement->bindValue('endDate',  $endDate->format('Y-m-d'));
     $statement->execute();
      return  $result = $statement->fetchAll();
    }
   /**
  *Nombre total de visite effectue par point de vente 
  */
 

   public function visitesParPDVDetaillees ($region=null, $startDate=null, $endDate=null){
    $em = $this->_em;

  $RAW_QUERY =($region!=null) ? 'select v.id,v.auditeur,v.matricule, v.nom,v.date,v.map,v.exc,v.pre,v.rpd,v.rpp,v.sapp,v.pas_client,v.raison_pas_client,v.pas_ouvert,v.raison_pas_ouvert,v.commentaire,v.nombre,v.aff ,sum((case when produit=\'FKS\' then stock else 0 end)) as fks,sum((case when produit=\'FKL\' then stock else 0 end)) as fkl,sum((case when produit=\'FMT\' then stock else 0 end)) as fmt,sum((case when produit=\'FKM\' then stock else 0 end)) as fkm,sum((case when produit=\'DUNHIL\' then stock else 0 end)) as dunhil,sum((case when produit=\'L-M\' then stock else 0 end)) as l_m,sum((case when produit=\'MALBORO\' then stock else 0 end)) as malboro,sum((case when produit=\'SUPER MATCH\' then stock else 0 end)) as super_match  from (select v.id,c.nom as auditeur, pv.nom,pv.matricule,v.date, v.map,v.exc,v.pre,v.rpd,v.rpp,v.sapp,v.pas_client,v.raison_pas_client,v.pas_ouvert,v.raison_pas_ouvert,v.commentaire, s.produit_id as produit, s.stock, v.nombre,v.aff from  point_vente pv  left OUTER join  (select  v.id,v.date,v.aff,v.map,v.pre,v.pas_ouvert,v.pas_client,v.raison_pas_ouvert,v.raison_pas_client,v.commentaire, v.exc, v.sapp,v.rpd,v.rpp,v.point_vente_id,v.user_id,u.nombre from (select pv.id as pv ,pv.ville, max(v.date) as date, count(v.id) as nombre from point_vente pv join visite v  on (pv.id=v.point_vente_id and v.date>=:startDate and v.date<=:endDate )  group by  pv.id order by pv.id,pv.ville) as u  join   visite v on (u.pv=v.point_vente_id and u.date=v.date )) v on pv.id=v.point_vente_id left join client c on c.id=v.user_id  left join situation s on s.visite_id=v.id left join produit p on s.produit_id=p.id where pv.ville=:region) v group by v.id, v.nom,v.map,v.exc,v.pre,v.rpd,v.rpp,v.sapp,v.pas_client,v.raison_pas_client,v.pas_ouvert,v.raison_pas_ouvert,v.commentaire,v.aff,v.date,v.auditeur,v.matricule,v.nombre;
' :'select v.id,v.auditeur,v.matricule, v.nom,v.date,v.map,v.exc,v.pre,v.rpd,v.rpp,v.sapp,v.pas_client,v.raison_pas_client,v.pas_ouvert,v.raison_pas_ouvert,v.commentaire,v.nombre,v.aff ,sum((case when produit=\'FKS\' then stock else 0 end)) as fks,sum((case when produit=\'FKL\' then stock else 0 end)) as fkl,sum((case when produit=\'FMT\' then stock else 0 end)) as fmt,sum((case when produit=\'FKM\' then stock else 0 end)) as fkm,sum((case when produit=\'DUNHIL\' then stock else 0 end)) as dunhil,sum((case when produit=\'L-M\' then stock else 0 end)) as l_m,sum((case when produit=\'MALBORO\' then stock else 0 end)) as malboro,sum((case when produit=\'SUPER MATCH\' then stock else 0 end)) as super_match  from (select v.id,c.nom as auditeur, pv.nom,pv.matricule,v.date, v.map,v.exc,v.pre,v.rpd,v.rpp,v.sapp,v.pas_client,v.raison_pas_client,v.pas_ouvert,v.raison_pas_ouvert,v.commentaire, s.produit_id as produit, s.stock, v.nombre,v.aff from  point_vente pv  left OUTER join  (select  v.id,v.date,v.aff,v.map,v.pre,v.pas_ouvert,v.pas_client,v.raison_pas_ouvert,v.raison_pas_client,v.commentaire, v.exc, v.sapp,v.rpd,v.rpp,v.point_vente_id,v.user_id,u.nombre from (select pv.id as pv ,pv.ville, max(v.date) as date, count(v.id) as nombre from point_vente pv join visite v  on (pv.id=v.point_vente_id and v.date>=:startDate and v.date<=:endDate )  group by  pv.id order by pv.id,pv.ville) as u  join   visite v on (u.pv=v.point_vente_id and u.date=v.date )) v on pv.id=v.point_vente_id left join client c on c.id=v.user_id  left join situation s on s.visite_id=v.id left join produit p on s.produit_id=p.id ) v group by v.id, v.nom,v.map,v.exc,v.pre,v.rpd,v.rpp,v.sapp,v.pas_client,v.raison_pas_client,v.pas_ouvert,v.raison_pas_ouvert,v.commentaire,v.aff,v.date,v.auditeur,v.matricule,v.nombre;
';
    $statement = $em->getConnection()->prepare($RAW_QUERY);
        if($region!=null){
    $statement->bindValue('region', $region);
          }
     $startDate=new \DateTime($startDate);
     $endDate=new \DateTime($endDate);
     $statement->bindValue('startDate', $startDate->format('Y-m-d'));
     $statement->bindValue('endDate',  $endDate->format('Y-m-d'));
     $statement->execute();
      return  $result = $statement->fetchAll();
  } 
}
