<?php
namespace AdminApi\Model\Entity;

use Cake\ORM\Entity;

/**
 * Menu Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property string $name
 * @property string $path
 * @property string $redirect
 * @property int $hidden
 * @property string $icon
 * @property string $component
 *
 * @property \AdminApi\Model\Entity\Menu $parent_menu
 * @property \AdminApi\Model\Entity\Menu[] $child_menus
 */
class Menu extends Entity
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
        'parent_id' => true,
        'title' => true,
        'name' => true,
        'path' => true,
        'redirect' => true,
        'hidden' => true,
        'icon' => true,
        'component' => true,
        'sort' => true,
        'select_path' => true,
        'parent_menu' => true,
        'child_menus' => true
    ];
}
