<?php
namespace AdminApi\Model\Table;

use Cake\Filesystem\File;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Validation\Validator;

/**
 * Articles Model
 *
 * @property \AdminApi\Model\Table\ArctypesTable|\Cake\ORM\Association\BelongsTo $Arctypes
 * @property \AdminApi\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \AdminApi\Model\Entity\Article get($primaryKey, $options = [])
 * @method \AdminApi\Model\Entity\Article newEntity($data = null, array $options = [])
 * @method \AdminApi\Model\Entity\Article[] newEntities(array $data, array $options = [])
 * @method \AdminApi\Model\Entity\Article|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminApi\Model\Entity\Article|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminApi\Model\Entity\Article patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminApi\Model\Entity\Article[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminApi\Model\Entity\Article findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ArticlesTable extends Table
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

        $this->setTable('ad_articles');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Arctypes', [
            'foreignKey' => 'arctype_id',
            'className' => 'AdminApi.Arctypes'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'AdminApi.Users'
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
            ->maxLength('title', 100)
            ->allowEmpty('title');

        $validator
            ->scalar('shorttitle')
            ->maxLength('shorttitle', 36)
            ->allowEmpty('shorttitle');

        $validator
            ->scalar('color')
            ->maxLength('color', 10)
            ->allowEmpty('color');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->allowEmpty('description');

        $validator
            ->scalar('keywords')
            ->maxLength('keywords', 100)
            ->allowEmpty('keywords');

        $validator
            ->scalar('content')
            ->maxLength('content', 16777215)
            ->allowEmpty('content');

        $validator
            ->dateTime('pubdate')
            ->allowEmpty('pubdate');

        $validator
            ->scalar('image')
            ->maxLength('image', 200)
            ->allowEmpty('image');

        $validator
            ->allowEmpty('autoimage');

        $validator
            ->scalar('tag')
            ->maxLength('tag', 100)
            ->allowEmpty('tag');

        $validator
            ->allowEmpty('isshow');

        $validator
            ->allowEmpty('istop');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->allowEmpty('url');

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
        $rules->add($rules->existsIn(['arctype_id'], 'Arctypes'));

        return $rules;
    }

    /**
     * 格式化data数据
     */
    public function formatData($data)
    {
        if (!empty($data['image']) && (new File($data['image'], false))->exists()) {
            $data['image'] = Router::url($data['image'], true);
        } else {
            $data['image'] = '';
        }

        $data['pubdate'] = date('Y-m-d H:i:s', strtotime($data['pubdate']));
        return $data;
    }
}
