<?php declare(strict_types=1);

namespace DavidBadura\XsdBuilder;

class Restriction
{
    private string $base;
    private ?int $minLength = null;
    private ?int $maxLength = null;
    private ?int $minInclusive = null;
    private ?int $maxInclusive = null;
    private ?array $enumeration = null;
    private ?string $pattern = null;

    private function __construct()
    {
    }

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

        if ($this->enumeration) {
            foreach ($this->enumeration as $value) {
                $restriction = $dom->createElement('xs:enumeration');
                $restriction->setAttribute('value', $value);
                $el->appendChild($restriction);
            }

            return $el;
        }

        if ($this->minLength !== null && $this->maxLength !== null) {
            $restriction = $dom->createElement('xs:minLength');
            $restriction->setAttribute('value', (string) $this->minLength);
            $el->appendChild($restriction);

            $restriction = $dom->createElement('xs:maxLength');
            $restriction->setAttribute('value', (string) $this->maxLength);
            $el->appendChild($restriction);

            return $el;
        }

        if ($this->minInclusive !== null && $this->maxInclusive !== null) {
            $restriction = $dom->createElement('xs:minInclusive');
            $restriction->setAttribute('value', (string) $this->minInclusive);
            $el->appendChild($restriction);

            $restriction = $dom->createElement('xs:maxInclusive');
            $restriction->setAttribute('value', (string) $this->maxInclusive);
            $el->appendChild($restriction);

            return $el;
        }

        throw new \RuntimeException();
    }
}
