<?php
namespace AdminApi\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ArticlesFixture
 *
 */
class ArticlesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '自增id', 'autoIncrement' => true, 'precision' => null],
        'arctype_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '栏目id', 'precision' => null, 'autoIncrement' => null],
        'title' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '标题', 'precision' => null, 'fixed' => null],
        'shorttitle' => ['type' => 'string', 'length' => 36, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '短标题', 'precision' => null, 'fixed' => null],
        'color' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '颜色', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '描述', 'precision' => null, 'fixed' => null],
        'keywords' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '关键字', 'precision' => null, 'fixed' => null],
        'content' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '内容', 'precision' => null],
        'pubdate' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '发布时间', 'precision' => null],
        'image' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '缩略图', 'precision' => null, 'fixed' => null],
        'autoimage' => ['type' => 'tinyinteger', 'length' => 2, 'unsigned' => false, 'null' => true, 'default' => '2', 'comment' => '是否提取图片，1是，2否。提取内容中第一个图片为缩略图', 'precision' => null],
        'tag' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '标签', 'precision' => null, 'fixed' => null],
        'isshow' => ['type' => 'tinyinteger', 'length' => 2, 'unsigned' => false, 'null' => true, 'default' => '1', 'comment' => '是否显示，1显示，2隐藏', 'precision' => null],
        'istop' => ['type' => 'tinyinteger', 'length' => 2, 'unsigned' => false, 'null' => true, 'default' => '2', 'comment' => '是否置顶，1是，2否', 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '管理员id', 'precision' => null, 'autoIncrement' => null],
        'url' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '跳转链接', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '创建时间', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '修改时间', 'precision' => null],
        '_indexes' => [
            'created' => ['type' => 'index', 'columns' => ['created'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'MyISAM',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'arctype_id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'shorttitle' => 'Lorem ipsum dolor sit amet',
                'color' => 'Lorem ip',
                'description' => 'Lorem ipsum dolor sit amet',
                'keywords' => 'Lorem ipsum dolor sit amet',
                'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'pubdate' => '2018-09-14 13:23:18',
                'image' => 'Lorem ipsum dolor sit amet',
                'autoimage' => 1,
                'tag' => 'Lorem ipsum dolor sit amet',
                'isshow' => 1,
                'istop' => 1,
                'user_id' => 1,
                'url' => 'Lorem ipsum dolor sit amet',
                'created' => '2018-09-14 13:23:18',
                'modified' => '2018-09-14 13:23:18'
            ],
        ];
        parent::init();
    }
}
