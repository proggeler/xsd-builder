<?php declare(strict_types=1);

namespace DavidBadura\XsdBuilder;

class SimpleType
{
    private ?string $name = null;
    private ?string $type = null;
    private ?Restriction $restriction = null;

    private function __construct()
    {
    }

    public static function string(string $name): self
    {
        return self::create($name, Type::STRING);
    }

    public static function decimal(string $name): self
    {
        return self::create($name, Type::DECIMAL);
    }

    public static function integer(string $name): self
    {
        return self::create($name, Type::INTEGER);
    }

    public static function boolean(string $name): self
    {
        return self::create($name, Type::BOOLEAN);
    }

    public static function date(string $name): self
    {
        return self::create($name, Type::DATE);
    }

    public static function time(string $name): self
    {
        return self::create($name, Type::TIME);
    }

    public static function create(string $name, string $type): self
    {
        $self = new self();
        $self->name = $name;
        $self->type = $type;

        return $self;
    }

    public static function withRestriction(string $name, Restriction $restriction): self
    {
        $self = new self();
        $self->name = $name;
        $self->restriction = $restriction;

        return $self;
    }

    public function name():?string
    {
        return $this->name;
    }

    public function type(): ?string
    {
        return $this->type;
    }

    public function restriction(): ?Restriction
    {
        return $this->restriction;
    }

    public function createDomElement(\DOMDocument $dom): \DOMElement
    {
        $el = $dom->createElement('xs:simpleType');

        if ($this->name) {
            $el->setAttribute('name', $this->name);
        }

        if ($this->type) {
            $el->setAttribute('type', $this->type);

            return $el;
        }

        if ($this->restriction) {
            $el->appendChild($this->restriction->createDomElement($dom));

            return $el;
        }

        throw new \RuntimeException();
    }
}
