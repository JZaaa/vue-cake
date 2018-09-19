<?php
namespace AdminApi\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $nickname
 * @property int $role_id
 * @property int $state
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \AdminApi\Model\Entity\Role $role
 * @property \AdminApi\Model\Entity\AdArticle[] $ad_articles
 * @property \AdminApi\Model\Entity\Order[] $order
 * @property \AdminApi\Model\Entity\OrderItem[] $order_item
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'nickname' => true,
        'role_id' => true,
        'state' => true,
        'created' => true,
        'modified' => true,
        'role' => true,
        'ad_articles' => true,
        'order' => true,
        'order_item' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }
}
