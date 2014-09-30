<?php

/*
* Copyright 2014 HLP-Nebula authors, see NOTICE file
4
*
* Licensed under the EUPL, Version 1.1 or – as soon they
will be approved by the European Commission - subsequent
versions of the EUPL (the "Licence");
* You may not use this work except in compliance with the
Licence.
* You may obtain a copy of the Licence at:
*
*
http://ec.europa.eu/idabc/eupl
5
*
* Unless required by applicable law or agreed to in
writing, software distributed under the Licence is
distributed on an "AS IS" basis,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
express or implied.
* See the Licence for the specific language governing
permissions and limitations under the Licence.
*/ 

namespace HLP\NebulaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FSModRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FSModRepository extends EntityRepository
{
  public function findSingleMod($ownerNameCanonical, $modId)
  {
    $qb = $this->_em->createQueryBuilder();
    $qb->select('m')
       ->from('HLPNebulaBundle:FSMod', 'm')
       ->leftJoin('m.userAsOwner', 'uo')
       ->addSelect('uo')
       ->leftJoin('m.teamAsOwner', 'to')
       ->addSelect('to')
       ->leftJoin('m.branches', 'b')
       ->addSelect('b')
       ->leftJoin('b.builds', 'u')
       ->addSelect('PARTIAL u.{id, updated}')
       ->orderBy('u.updated', 'DESC')
       ->where('uo.usernameCanonical = :nameCanonical OR to.nameCanonical = :nameCanonical')
       ->andWhere('m.modId = :modId')
       ->setParameter('nameCanonical', $ownerNameCanonical)
       ->setParameter('modId', $modId);
         

    return $qb->getQuery()
              ->getOneOrNullResult();
  }
}