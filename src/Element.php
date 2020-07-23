<?php declare(strict_types=1);

namespace DavidBadura\XsdBuilder;

class Element
{
    private string $name;
    private ?string $type = null;
    private ?ComplexType $complexType = null;
    private ?SimpleType $simpleType = null;
    private ?string $default = null;
    private bool $unbounded = false;

    private function __construct()
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function setDefault($default): void
    {
        $this->default = $default;
    }

    public function default(): ?string
    {
        return $this->default;
    }

    public function setUnbounded(bool $unbounded = true): void
    {
        $this->unbounded = $unbounded;
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

    public static function simpleType(string $name, SimpleType $simpleType): self
    {
        $self = new self();
        $self->name = $name;
        $self->simpleType = $simpleType;

        return $self;
    }

    public static function complexType(string $name, ComplexType $complexType): self
    {
        $self = new self();
        $self->name = $name;
        $self->complexType = $complexType;

        return $self;
    }

    public function createDomElement(\DOMDocument $dom): \DOMElement
    {
        $el = $dom->createElement('xs:element');
        $el->setAttribute('name', $this->name);

        if ($this->unbounded) {
            $el->setAttribute('maxOccurs', 'unbounded');
        }

        if ($this->type) {
            $el->setAttribute('type', $this->type);

            if ($this->default) {
                $el->setAttribute('default', $this->default);
            }

            return $el;
        }

        if ($this->simpleType) {
            $el->appendChild($this->simpleType->createDomElement($dom));

            return $el;
        }

        if ($this->complexType) {
            $el->appendChild($this->complexType->createDomElement($dom));

            return $el;
        }

        throw new \RuntimeException();
    }
}
