<?php
/**
 * Event test case
 */
class EventTest extends CTestCase {
    public function testSetData() {
        $model = new Event();
        $data = array(
            'id' => 123,
            'name' => 'Test Event',
            'type' => 2,
            'description' => 'Description',
            'section' => 2,
            'closed' => 1,
            'contacted' => 1,
            'av' => 1,
            'av_requested' => 1,
            'adult' => 1,
            'desc_final' => 1,
        );

        //Test default data
        $model->setData(array('name' => 'Test'));
        $this->assertEquals('Test', $model->name);
        $this->assertEquals(NULL, $model->id);
        $this->assertEquals(1, $model->type);
        $this->assertEquals('', $model->description);
        $this->assertEquals(1, $model->section);
        $this->assertEquals(0, $model->closed);
        $this->assertEquals(0, $model->contacted);
        $this->assertEquals(0, $model->av);
        $this->assertEquals(0, $model->av_requested);
        $this->assertEquals(0, $model->adult);
        $this->assertEquals(0, $model->desc_final);

        //Test set data
        $model->setData($data);
        $this->assertEquals(123, $model->id);
        $this->assertEquals('Test Event', $model->name);
        $this->assertEquals(2, $model->type);
        $this->assertEquals('Description', $model->description);
        $this->assertEquals(2, $model->section);
        $this->assertEquals(1, $model->closed);
        $this->assertEquals(1, $model->contacted);
        $this->assertEquals(1, $model->av);
        $this->assertEquals(1, $model->av_requested);
        $this->assertEquals(1, $model->adult);
        $this->assertEquals(1, $model->desc_final);
    }

    public function testAttributeNames() {
        $model = new Event();
        $data = array('id', 'name', 'type', 'description', 'section', 'closed', 'contacted', 'av', 'av_requested', 'adult', 'desc_final');
        $this->assertEquals($data, $model->attributeNames());
    }

    public function testCreateSaveDelete() {
        $model = new Event();
        $data = array(
            'id' => 1,
            'name' => 'Test Event',
            'type' => '2',
            'description' => 'Description',
            'section' => '2',
            'closed' => '1',
            'contacted' => '1',
            'av' => '1',
            'av_requested' => '1',
            'adult' => '1',
            'desc_final' => '1',
        );
        $model->setData($data);
        $model->create();
        $id = $model->id;
        $data['id'] = $id;

        $this->assertNotEquals('0', $id);

        $testData = $model->search('id', $id);
        $data['last_updated'] = $testData['last_updated'];
        $this->assertEquals($testData, $data);

        $data = array(
            'id' => $id,
            'name' => 'New Event',
            'type' => '1',
            'description' => 'New Description',
            'section' => '1',
            'closed' => '0',
            'contacted' => '0',
            'av' => '0',
            'av_requested' => '0',
            'adult' => '0',
            'desc_final' => '0',
        );
        $model->setData($data);
        $model->save();

        $testData = $model->search('id', $id);
        $data['last_updated'] = $testData['last_updated'];
        $this->assertEquals($testData, $data);

        $model->delete();
    }
} 