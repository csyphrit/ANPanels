<?php
/**
 * Created by PhpStorm.
 * User: Christie
 * Date: 12/17/13
 * Time: 10:58 PM
 */

class SectionsTest extends CTestCase {
    public function testSections() {
        $model = new Sections();
        $sections = $model->getAll();
        $this->assertTrue(in_array(array('id' => '1', 'name' => 'General', 'visible' => '1'), $sections));
    }
}