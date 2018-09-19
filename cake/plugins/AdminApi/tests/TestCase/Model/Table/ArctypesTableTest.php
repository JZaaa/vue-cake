<?php
namespace AdminApi\Test\TestCase\Model\Table;

use AdminApi\Model\Table\ArctypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminApi\Model\Table\ArctypesTable Test Case
 */
class ArctypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminApi\Model\Table\ArctypesTable
     */
    public $Arctypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.admin_api.arctypes',
        'plugin.admin_api.articles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Arctypes') ? [] : ['className' => ArctypesTable::class];
        $this->Arctypes = TableRegistry::getTableLocator()->get('Arctypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Arctypes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
