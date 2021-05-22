<?php


namespace App\Service;

use App\Contracts\TokenizableRepository;

final class TokenService
{
    public static function getUniqueToken(TokenizableRepository $repository
    ): string
    {
        $chars = array_merge(range('A', 'Z'), range('a', 'z'), array_map('strval', range(0, 9)));
        $length = 3;

        while(true) {
            for ($loop = 0; $loop < 3; $loop++) {
                shuffle($chars);
                $token = implode('', array_slice($chars, 0, $length));

                if (!$repository->tokenExists($token)) {
                    return $token;
                }
            }

            $length++;
        }
    }
}
