<?php

namespace App\Validator\Constraint;

use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OnlineValidator extends ConstraintValidator
{
    public function __construct(public HttpClientInterface $httpClient)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!str_starts_with($value, 'http')) {
            $value = 'https://' . $value;
        }

        try {
            $statusCode = $this->httpClient->request('HEAD', $value)->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();

            return;
        }

        if ($statusCode === 404 || $statusCode >= 500) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
