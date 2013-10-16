<?php

use Mockery as m;

class TestCase extends Illuminate\Foundation\Testing\TestCase {

    protected $testMessagesConfig = array(
            'test_string',
            'test' => array('string')
        );

    protected $testMessages = array(
            'test_string' => 'This is: test_string',
            'test.string' => 'This is: test.string'
        );

    /**
     * Creates the application.
     *
     * @return Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__.'/../../../../bootstrap/start.php';
    }

    public function setUp ()
    {
        parent::setUp();

        $this->updateMessagesConfig($this->testMessagesConfig);
        $this->mockLang();
    }

    protected function updateMessagesConfig (array $config)
    {
        Config::set('js-localization::config.messages', $config);
    }

    protected function mockLang ($locale = "en")
    {
        Illuminate\Support\Facades\Lang::swap($lang = m::mock('LangMock'));

        $lang->shouldReceive('setLocale');
        $lang->shouldReceive('locale')->andReturn($locale);

        foreach ($this->testMessages as $key=>$message) {
            $lang->shouldReceive('get')
                ->with($key)->andReturn($message);
        }
    }

    public function tearDown ()
    {
        m::close();

        parent::tearDown();
    }

}