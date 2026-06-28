<?php

namespace SigmaPHP\Core\Models;

use SigmaPHP\Core\Interfaces\Models\BaseModelInterface;
use SigmaPHP\Collections\Collection;
use SigmaPHP\DB\ORM\Model;

/**
 * Core Base Model Class
 */
abstract class BaseModel extends Model implements BaseModelInterface
{
    /**
     * BaseModel Constructor
     *
     * @param Connector $dbConnection
     * @param string $dbName
     * @param array $values
     * @param bool $isNew
     */
    public function __construct(
        $dbConnection = null,
        $dbName = '',
        $values = [],
        $isNew = true
    ) {
        parent::__construct(
            container('db'),
            config('database.database_connection.name'),
            $values
        );
    }

    /**
     * Fetch all models and return them as Collection.
     *
     * @return Collection<static>
     */
    public function all()
    {
        return new Collection(parent::all());
    }

    /**
     * Get one/many models in another table
     * related to this model.
     *
     * @param Model $model
     * @param string $foreignKey
     * @param string $localKey
     * @return Collection<static>
     */
    public function hasRelation($model, $foreignKey, $localKey)
    {
        return new Collection(
            parent::hasRelation($model, $foreignKey, $localKey)
        );
    }
}
