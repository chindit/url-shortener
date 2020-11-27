<?php


namespace App\Service;


use App\Repository\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;

final class TokenService
{
    public function __construct(
        public LinkRepository $linkRepository
    )
    {}

    public function getUniqueToken(): string
    {
        $chars = array_merge(range('A', 'Z'), range('a', 'z'), array_map('strval', range(0, 9)));
        $length = 3;

        while(true) {
            for ($loop = 0; $loop < 3; $loop++) {
                shuffle($chars);
                $token = implode('', array_slice($chars, 0, $length));

                if (!$this->linkRepository->tokenExists($token)) {
                    return $token;
                }
            }

            $length++;
        }
    }
}