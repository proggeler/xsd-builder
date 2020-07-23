XsdBuilder
==========

Installation
------------

You can easily install this package over composer

```shell script
composer require 'davidbadura/xsd-builder'
```

Example
-------

### PHP Code

```php
<?php

use DavidBadura\XsdBuilder\Builder;
use DavidBadura\XsdBuilder\ComplexType;
use DavidBadura\XsdBuilder\Element;

$user = new ComplexType();
$user->addElement(Element::string('name'));
$user->addElement(Element::integer('age'));

$builder = new Builder();
$builder->addElement(Element::complexType('user', $user));

echo $builder->toString();
```

### Result

```xml
<?xml version="1.0" encoding="UTF-8"?>
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema">
  <xs:element name="user">
    <xs:complexType>
      <xs:sequence>
        <xs:element name="name" type="xs:string"/>
        <xs:element name="age" type="xs:integer"/>
      </xs:sequence>
    </xs:complexType>
  </xs:element>
</xs:schema>
```
