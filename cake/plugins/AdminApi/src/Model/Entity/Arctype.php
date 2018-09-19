<?php
namespace AdminApi\Model\Entity;

use Cake\ORM\Entity;

/**
 * Arctype Entity
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property int $level
 * @property int $sort
 * @property int $type
 * @property string $image
 * @property int $isshow
 * @property string $keywords
 * @property string $description
 * @property string $href
 * @property string $enable_columns
 *
 * @property \AdminApi\Model\Entity\Arctype $parent_arctype
 * @property \AdminApi\Model\Entity\Arctype[] $child_arctypes
 * @property \AdminApi\Model\Entity\Article[] $articles
 */
class Arctype extends Entity
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
        'name' => true,
        'parent_id' => true,
        'sort' => true,
        'type' => true,
        'image' => true,
        'isshow' => true,
        'keywords' => true,
        'description' => true,
        'href' => true,
        'enable_columns' => true,
        'select_path' => true,
        'parent_arctype' => true,
        'child_arctypes' => true,
        'articles' => true
    ];
}
