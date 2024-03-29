<?php
namespace ArmoniaHeadless;

use HeadlessChromium\BrowserFactory;

class Headless
{
    private $browser;
    private $page;

    const DISABLE_DEV_SHM_FLAG = '--disable-dev-shm-usage';

    /**
     * Construct
     *
     * @author Seon <keangsiang.pua@armonia-tech.com>
     * @param  string $url
     * @param  array  $settings
     * @param  string $pre_script default null
     * @param  string $timeout default 2000 ms = 2 seconds
     * @return void
     */
    public function __construct(string $url, array $settings = ['noSandbox' => true], string $pre_script = null, int $timeout = 2000)
    {
        $browserFactory = new BrowserFactory('chromium-browser');

        // force disable dev shm for all
        $settings['customFlags'][] = self::DISABLE_DEV_SHM_FLAG;

        // starts headless chrome
        $this->browser = $browserFactory->createBrowser($settings);

        // creates a new page and navigate to an url
        $this->page = $this->browser->createPage();

        if (isset($pre_script)) {
            $this->page->addPreScript($pre_script);
        }

        $this->page->navigate($url)->waitForNavigation();
        $this->page->addScriptTag([
            'url' => 'https://code.jquery.com/jquery-3.4.1.min.js'
        ])->waitForResponse($timeout);
    }

    /**
     * Get Page
     *
     * @author Seon <keangsiang.pua@armonia-tech.com>
     * @return object
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * Get Page
     *
     * @author Seon <keangsiang.pua@armonia-tech.com>
     * @return object
     */
    public function getPage()
    {
        return $this->page;
    }
}
