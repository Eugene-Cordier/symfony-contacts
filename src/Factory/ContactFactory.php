<?php

namespace App\Factory;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Contact>
 *
 * @method        Contact|Proxy                     create(array|callable $attributes = [])
 * @method static Contact|Proxy                     createOne(array $attributes = [])
 * @method static Contact|Proxy                     find(object|array|mixed $criteria)
 * @method static Contact|Proxy                     findOrCreate(array $attributes)
 * @method static Contact|Proxy                     first(string $sortedField = 'id')
 * @method static Contact|Proxy                     last(string $sortedField = 'id')
 * @method static Contact|Proxy                     random(array $attributes = [])
 * @method static Contact|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ContactRepository|RepositoryProxy repository()
 * @method static Contact[]|Proxy[]                 all()
 * @method static Contact[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Contact[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Contact[]|Proxy[]                 findBy(array $attributes)
 * @method static Contact[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Contact[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ContactFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public ?\Transliterator $transliterator;

    public function __construct()
    {
        parent::__construct();
        $this->transliterator = transliterator_create('Any-Latin; Latin-ASCII');
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'firstname' => preg_replace('/[^a-z]/', '-', self::faker()->firstName($gender = null | 'male' | 'female')),
            'lastname' => preg_replace('/[^a-z]/', '-', self::faker()->lastName()),
            self::faker()->domainName(),
            'email' => preg_replace('/[^a-z]/', '-', mb_strtolower(transliterator_transliterate(transliterator_create('Any-Latin; Latin-ASCII'), self::faker()->safeEmail(), 0, -1))),
        ];

    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Contact $contact): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Contact::class;
    }

    protected function normalizeName(string $string): string
    {
        return preg_replace('/[^a-z]/', '-', mb_strtolower(transliterator_transliterate($this->transliterator, $string, 0, -1)));
    }

}
