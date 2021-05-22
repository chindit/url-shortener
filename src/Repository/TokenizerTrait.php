<?php

namespace App\Repository;

trait TokenizerTrait
{
    public function tokenExists(string $token): int
    {
        return $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->where('l.token = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
