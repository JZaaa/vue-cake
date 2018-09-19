<?php
namespace AdminApi\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Arctypes Model
 *
 * @property \AdminApi\Model\Table\ArctypesTable|\Cake\ORM\Association\BelongsTo $ParentArctypes
 * @property \AdminApi\Model\Table\ArctypesTable|\Cake\ORM\Association\HasMany $ChildArctypes
 * @property \AdminApi\Model\Table\ArticlesTable|\Cake\ORM\Association\HasMany $Articles
 *
 * @method \AdminApi\Model\Entity\Arctype get($primaryKey, $options = [])
 * @method \AdminApi\Model\Entity\Arctype newEntity($data = null, array $options = [])
 * @method \AdminApi\Model\Entity\Arctype[] newEntities(array $data, array $options = [])
 * @method \AdminApi\Model\Entity\Arctype|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminApi\Model\Entity\Arctype|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminApi\Model\Entity\Arctype patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminApi\Model\Entity\Arctype[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminApi\Model\Entity\Arctype findOrCreate($search, callable $callback = null, $options = [])
 */
class ArctypesTable extends Table
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

        $this->setTable('ad_arctypes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentArctypes', [
            'className' => 'AdminApi.Arctypes',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildArctypes', [
            'className' => 'AdminApi.Arctypes',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('Articles', [
            'foreignKey' => 'arctype_id',
            'className' => 'AdminApi.Articles'
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
            ->integer('sort')
            ->requirePresence('sort', 'create')
            ->notEmpty('sort');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->scalar('image')
            ->maxLength('image', 50)
            ->allowEmpty('image');

        $validator
            ->requirePresence('isshow', 'create')
            ->notEmpty('isshow');

        $validator
            ->scalar('keywords')
            ->maxLength('keywords', 255)
            ->allowEmpty('keywords')
            ->add('keywords', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmpty('description');

        $validator
            ->scalar('href')
            ->maxLength('href', 255)
            ->allowEmpty('href');

        $validator
            ->scalar('enable_columns')
            ->allowEmpty('enable_columns');

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
        $rules->add($rules->isUnique(['keywords']));

        return $rules;
    }
}
