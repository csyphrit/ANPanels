<?php
/**
 * Profile test case
 */
class ProfileTest extends CTestCase {
    public function testSetData() {
        $model = new Profile();
        $data = array(
            'userid' => 123,
            'name' => 'Test Profile',
            'alias' => 'Profile',
            'address' => '123 Test Rd',
            'city' => 'Test City',
            'state' => 'NY',
            'zip' => '12345',
            'country' => 'USA',
            'phone' => '(716) 123-4567',
            'email' => 'test@anpanels.com',
            'age' => '18+',
            'forumName' => 'test',
            'reg_status' => 'Y',
            'comments' => 'Comment',
            'unavailable' => 'Unavailable'
        );

        //Test default data
        $model->setData($data);
        $this->assertEquals('Test Profile', $model->name);
        $this->assertEquals(123, $model->userid);
        $this->assertEquals('Profile', $model->alias);
        $this->assertEquals('123 Test Rd', $model->address);
        $this->assertEquals('Test City', $model->city);
        $this->assertEquals('NY', $model->state);
        $this->assertEquals('12345', $model->zip);
        $this->assertEquals('USA', $model->country);
        $this->assertEquals('(716) 123-4567', $model->phone);
        $this->assertEquals('test@anpanels.com', $model->email);
        $this->assertEquals('18+', $model->age);
        $this->assertEquals('test', $model->forumName);
        $this->assertEquals('Y', $model->regStatus);
        $this->assertEquals('Comment', $model->comments);
        $this->assertEquals('Unavailable', $model->unavailable);
    }

    public function testAttributeNames() {
        $model = new Profile();
        $data = array('userid', 'name', 'alias', 'address', 'city', 'state', 'zip', 'country', 'phone', 'email', 'age', 'forumName', 'regStatus', 'comments', 'unavailable');
        $this->assertEquals($data, $model->attributeNames());
    }

    public function testCreateSaveDelete() {
        $model = new Profile();
        $data = array(
            'userid' => '123',
            'name' => 'Test Profile',
            'alias' => 'Profile',
            'address' => '123 Test Rd',
            'city' => 'Test City',
            'state' => 'NY',
            'zip' => '12345',
            'country' => 'USA',
            'phone' => '(716) 123-4567',
            'email' => 'test@anpanels.com',
            'age' => '18+',
            'forumName' => 'test',
            'reg_status' => 'Y',
            'comments' => 'Comment',
            'unavailable' => 'Unavailable'
        );
        $model->setData($data);
        $model->create();

        $testData = $model->search('userid', '123');
        $this->assertEquals($testData, $data);

        $data = array(
            'userid' => '123',
            'name' => 'New User',
            'alias' => 'User',
            'address' => '233 Test Rd',
            'city' => 'City',
            'state' => 'PA',
            'zip' => '23456',
            'country' => 'Canada',
            'phone' => '(555) 123-4567',
            'email' => 'test2@anpanels.com',
            'age' => '15-0',
            'forumName' => 'test2',
            'reg_status' => 'N',
            'comments' => 'Test Comment',
            'unavailable' => 'Test Unavailable'
        );
        $model->setData($data);
        $model->save();

        $testData = $model->search('userid', '123');
        $this->assertEquals($testData, $data);

        $model->delete();
    }
} 