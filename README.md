# Sanitizer

```php
namespace Dziuperman\Sanitizer;

use Dziuperman\Sanitizer\Type\ArrayTypeHandler;
use Dziuperman\Sanitizer\Type\FieldType;use Dziuperman\Sanitizer\Type\FieldTypeHandler;
use Dziuperman\Sanitizer\Type\FloatType;
use Dziuperman\Sanitizer\Type\FloatTypeHandler;
use Dziuperman\Sanitizer\Type\IntType;use Dziuperman\Sanitizer\Type\IntTypeHandler;
use Dziuperman\Sanitizer\Type\StringType;
use Dziuperman\Sanitizer\Type\StringTypeHandler;
use Dziuperman\Sanitizer\Type\StructType;use Dziuperman\Sanitizer\Type\StructTypeHandler;
use Dziuperman\Sanitizer\TypeHandlerRegistry\InMemoryTypeHandlerRegistry;

$sanitizer = new Sanitizer(
    new InMemoryTypeHandlerRegistry([
        new StringTypeHandler(),
        new IntTypeHandler(),
        new FloatTypeHandler(),
        new ArrayTypeHandler(),
        new StructTypeHandler(),
        new FieldTypeHandler(),
    ])
)

$client = [
    'name' => 'Name'
    'age' => 35,
    'height' => 175.5,
]

$result = $sanitizer->sanitize(
    $client,
    new StructType(
        new FieldType('name', new StringType())
        new FieldType('age', new IntType())
        new FieldType('height', new FloatType())
    )
)
```