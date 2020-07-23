<?php declare(strict_types=1);

namespace DavidBadura\XsdBuilder;

class Restriction
{
    private string $base;
    private ?int $minLength;
    private ?int $maxLength;
    private ?int $minInclusive;
    private ?int $maxInclusive;
    private ?array $enumeration;
    private ?string $pattern;

    public static function regex(string $regex): self
    {
        $self = new self();
        $self->base = Type::STRING;
        $self->pattern = $regex;

        return $self;
    }

    public static function length(int $min, int $max): self
    {
        $self = new self();
        $self->base = Type::STRING;
        $self->minLength = $min;
        $self->maxLength = $max;

        return $self;
    }

    public static function range(int $min, int $max): self
    {
        $self = new self();
        $self->base = Type::INTEGER;
        $self->minInclusive = $min;
        $self->maxInclusive = $max;

        return $self;
    }

    public static function enum(array $values): self
    {
        $self = new self();
        $self->base = Type::STRING;
        $self->enumeration = $values;

        return $self;
    }

    public function createDomElement(\DOMDocument $dom): \DOMElement
    {
        $el = $dom->createElement('xs:restriction');
        $el->setAttribute('base', $this->base);

        if ($this->pattern) {
            $restriction = $dom->createElement('xs:pattern');
            $restriction->setAttribute('value', $this->pattern);
            $el->appendChild($restriction);

            return $el;
        }

        throw new \RuntimeException();
    }
}
