<?php

// these are obviously not exhaustive...
class OutputTest extends TestCase {

	public function testBasicExample()
	{
		$crawler = $this->client->request('GET', '/v1/states/MA/cities.json');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

  public function testInvalidState()
  {
    $this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
		$this->call('GET', '/v1/states/A/cities.json');
  }

  public function testRadiusSearch()
  {
    $response = $this->call( 'GET', '/v1/states/PA/cities/Bethlehem.json?radius=100' );
    $this->assertResponseOk();
  }

}
