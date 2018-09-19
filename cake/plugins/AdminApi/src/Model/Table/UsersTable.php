<?php
namespace AdminApi\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \AdminApi\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \AdminApi\Model\Table\AdArticlesTable|\Cake\ORM\Association\HasMany $AdArticles
 * @property \AdminApi\Model\Table\OrderTable|\Cake\ORM\Association\HasMany $Order
 * @property \AdminApi\Model\Table\OrderItemTable|\Cake\ORM\Association\HasMany $OrderItem
 *
 * @method \AdminApi\Model\Entity\User get($primaryKey, $options = [])
 * @method \AdminApi\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \AdminApi\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \AdminApi\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminApi\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminApi\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminApi\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminApi\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('ad_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'className' => 'AdminApi.Roles'
        ]);
        $this->hasMany('AdArticles', [
            'foreignKey' => 'user_id',
            'className' => 'AdminApi.AdArticles'
        ]);
        $this->hasMany('Order', [
            'foreignKey' => 'user_id',
            'className' => 'AdminApi.Order'
        ]);
        $this->hasMany('OrderItem', [
            'foreignKey' => 'user_id',
            'className' => 'AdminApi.OrderItem'
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
            ->scalar('username')
            ->maxLength('username', 50)
            ->allowEmpty('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 100)
            ->allowEmpty('password');

        $validator
            ->scalar('nickname')
            ->maxLength('nickname', 50)
            ->allowEmpty('nickname');

        $validator
            ->allowEmpty('state');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
