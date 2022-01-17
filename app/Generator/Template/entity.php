<?php

/**
 * @var $filename
 * @var $allowedFields
 * @var $tableDescription
 * @var $prefixCount
 */
echo "<?php namespace App\Entities;
use App\Entities\MyEntitiy;

class $filename extends MyEntitiy
{
    protected \$datamap = [\n";
foreach ($tableDescription as $row) {
    echo "        '" . lcfirst(substr($row['Field'], $prefixCount)) . "' => '$row[Field]',\n";
}
echo "    ];

    protected \$show = [\n\t\t";
foreach ($tableDescription as $row) {
    echo "'" . lcfirst(substr($row['Field'], $prefixCount)) . "',\n";
}
echo "\n    ];
}";
