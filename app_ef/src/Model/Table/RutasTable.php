<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class RutasTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('rutas');
        $this->setPrimaryKey('idruta');
        $this->setDisplayField('idruta');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->requirePresence('origen', 'create')
            ->notEmptyString('origen')
            ->requirePresence('destino', 'create')
            ->notEmptyString('destino')
            ->requirePresence('distancia_km', 'create')
            ->numeric('distancia_km')
            ->requirePresence('tiempo_estimado', 'create')
            ->integer('tiempo_estimado')
            ->requirePresence('tipo_ruta', 'create')
            ->inList('tipo_ruta', ['nacional', 'internacional']);

        return $validator;
    }
}
