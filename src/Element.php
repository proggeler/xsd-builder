<?php declare(strict_types=1);

namespace DavidBadura\XsdBuilder;

class Element
{
    private string $name;
    private ?string $type = null;
    private ?ComplexType $complexType = null;
    private ?SimpleType $simpleType = null;
    private ?Key $key = null;
    private ?Unique $unique = null;
    private array $keyRefs = [];
    private ?string $default = null;
    private ?int $maxOccurs = null;
    private ?int $minOccurs = null;
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

    public function setMinOccurs(int $number): void
    {
        $this->minOccurs = $number;
    }

    public function setMaxOccurs(int $number): void
    {
        $this->maxOccurs = $number;
    }

    public function setKey(Key $key): void
    {
        $this->key = $key;
    }

    public function setUnique(Unique $unique): void
    {
        $this->unique = $unique;
    }

    public function addKeyRef(KeyRef $keyRef): void
    {
        $this->keyRefs[] = $keyRef;
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

    public static function id(string $name): self
    {
        return self::create($name, Type::ID);
    }

    public static function idRef(string $name): self
    {
        return self::create($name, Type::IDREF);
    }

    public static function idRefs(string $name): self
    {
        return self::create($name, Type::IDREFS);
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

        if ($this->unbounded && $this->maxOccurs) {
            throw new \RuntimeException();
        }

        if ($this->unbounded) {
            $el->setAttribute('maxOccurs', 'unbounded');
        }

        if ($this->maxOccurs !== null) {
            $el->setAttribute('maxOccurs', (string)$this->maxOccurs);
        }

        if ($this->minOccurs !== null) {
            $el->setAttribute('minOccurs', (string)$this->minOccurs);
        }

        if ($this->type) {
            $el->setAttribute('type', $this->type);

            if ($this->default) {
                $el->setAttribute('default', $this->default);
            }
        }

        if ($this->simpleType) {
            $el->appendChild($this->simpleType->createDomElement($dom));
        }

        if ($this->complexType) {
            $el->appendChild($this->complexType->createDomElement($dom));
        }

        if ($this->unique) {
            $el->appendChild($this->unique->createDomElement($dom));
        }

        if ($this->key) {
            $el->appendChild($this->key->createDomElement($dom));
        }

        foreach ($this->keyRefs as $keyRef) {
            $el->appendChild($keyRef->createDomElement($dom));
        }

        return $el;
    }
}
