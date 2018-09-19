<?php
namespace AdminApi\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Menus Model
 *
 * @property \AdminApi\Model\Table\MenusTable|\Cake\ORM\Association\BelongsTo $ParentMenus
 * @property \AdminApi\Model\Table\MenusTable|\Cake\ORM\Association\HasMany $ChildMenus
 *
 * @method \AdminApi\Model\Entity\Menu get($primaryKey, $options = [])
 * @method \AdminApi\Model\Entity\Menu newEntity($data = null, array $options = [])
 * @method \AdminApi\Model\Entity\Menu[] newEntities(array $data, array $options = [])
 * @method \AdminApi\Model\Entity\Menu|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminApi\Model\Entity\Menu|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminApi\Model\Entity\Menu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminApi\Model\Entity\Menu[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminApi\Model\Entity\Menu findOrCreate($search, callable $callback = null, $options = [])
 */
class MenusTable extends Table
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

        $this->setTable('ad_menus');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentMenus', [
            'className' => 'AdminApi.Menus',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildMenus', [
            'className' => 'AdminApi.Menus',
            'foreignKey' => 'parent_id'
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
            ->scalar('title')
            ->maxLength('title', 32)
            ->allowEmpty('title');

        $validator
            ->scalar('name')
            ->maxLength('name', 32)
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('path')
            ->maxLength('path', 80)
            ->requirePresence('path', 'create')
            ->notEmpty('path');

        $validator
            ->scalar('redirect')
            ->maxLength('redirect', 80)
            ->allowEmpty('redirect');

        $validator
            ->requirePresence('hidden', 'create')
            ->notEmpty('hidden');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 32)
            ->allowEmpty('icon');

        $validator
            ->scalar('component')
            ->maxLength('component', 32)
            ->requirePresence('component', 'create')
            ->notEmpty('component');

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
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }


    /**
     * 格式化菜单栏 返回vue-router
     * @param $menus
     * @param array $data
     * @return array
     */
    public function formatMenus($menus = [])
    {
        foreach ($menus as &$item) {
            $item['hidden'] = ($item['hidden'] == 1);
            if (!empty($item['title'])) {
                $item['meta'] = [
                    'icon' => $item['icon'],
                    'title' => $item['title']
                ];
            }
            unset($item['id'], $item['parent_id'], $item['icon'], $item['title']);
            if (empty($item['redirect'])) {
                unset($item['redirect']);
            }
            if (!empty($item['children'])) {
                $item['children'] = $this->formatMenus($item['children']);
            } else {
                unset($item['children']);
            }
        }

        return $menus;
    }
}
