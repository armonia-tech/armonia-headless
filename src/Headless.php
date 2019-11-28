<?php
namespace ArmoniaHeadless;

use HeadlessChromium\BrowserFactory;

class Headless
{
    private $browser;
    private $page;

    /**
     * Construct
     *
     * @author Seon <keangsiang.pua@armonia-tech.com>
     * @param  string $url
     * @param  array  $settings
     * @return void
     */
    public function __construct(string $url, array $settings = ['noSandbox' => true])
    {
        $browserFactory = new BrowserFactory('chromium-browser');

        // starts headless chrome
        $this->browser = $browserFactory->createBrowser($settings);

        // creates a new page and navigate to an url
        $this->page = $this->browser->createPage();
        $this->page->navigate($url)->waitForNavigation();
        $this->page->addScriptTag([
            'url' => 'https://code.jquery.com/jquery-3.4.1.min.js'
        ])->waitForResponse();
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
