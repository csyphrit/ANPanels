<?php
/**
 * Test Registration
 */
class RegistrationTest extends CTestCase {
    public function testGetEventsByUser() {
        $model = new Registration();
        $data = array(
            array(
                'eventid' => '4',
                'confirmed' => '0'
            ),
            array(
                'eventid' => '5',
                'confirmed' => '0'
            )
        );
        $this->assertEquals($data, $model->getEventsByUser(4));
    }

    public function testSetData() {
        $model = new Registration();
        $data = array(
            'userid' => '123',
            'eventid' => '4',
            'description' => 'Test description',
            'comments' => 'Comments',
            'confirmed' => '0',
            'moderator' => '1',
        );
        $model->setData($data);

        $this->assertEquals('123', $model->userid);
        $this->assertEquals('4', $model->eventid);
        $this->assertEquals('Test description', $model->description);
        $this->assertEquals('Comments', $model->comments);
        $this->assertEquals('0', $model->confirmed);
        $this->assertEquals('1', $model->moderator);
    }

    public function testAttributeNames() {
        $model = new Registration();
        $this->assertEquals(array('userid', 'eventid', 'description', 'comments', 'confirmed', 'moderator', 'added'), $model->attributeNames());
    }

    public function testBadCreate() {
        $model = new Registration();
        $this->assertEquals(FALSE, $model->create(array()));
    }

    public function testCreateSaveDelete() {
        $model = new Registration();
        $data = array(
            'userid' => '123',
            'eventid' => '4',
            'description' => 'Test description',
            'comments' => 'Comments',
            'confirmed' => '0',
            'moderator' => '1',
        );
        $model->setData($data);
        $this->assertTrue($model->create());

        $testData = $model->search('userid', '123');
        $data['added'] = $testData[0]['added'];
        $this->assertEquals($testData, array($data));

        $model->delete();
    }
} 