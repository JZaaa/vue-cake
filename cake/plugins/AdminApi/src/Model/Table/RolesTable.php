<?php
namespace AdminApi\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Roles Model
 *
 * @property \AdminApi\Model\Table\AdUsersTable|\Cake\ORM\Association\HasMany $AdUsers
 *
 * @method \AdminApi\Model\Entity\Role get($primaryKey, $options = [])
 * @method \AdminApi\Model\Entity\Role newEntity($data = null, array $options = [])
 * @method \AdminApi\Model\Entity\Role[] newEntities(array $data, array $options = [])
 * @method \AdminApi\Model\Entity\Role|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminApi\Model\Entity\Role|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminApi\Model\Entity\Role patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminApi\Model\Entity\Role[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminApi\Model\Entity\Role findOrCreate($search, callable $callback = null, $options = [])
 */
class RolesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('ad_roles');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('AdUsers', [
            'foreignKey' => 'role_id',
            'className' => 'AdminApi.AdUsers'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->allowEmpty('name');

        $validator
            ->scalar('menus')
            ->allowEmpty('menus');

        $validator
            ->scalar('note')
            ->maxLength('note', 100)
            ->allowEmpty('note');

        $validator
            ->integer('sort')
            ->allowEmpty('sort');

        return $validator;
    }
}
