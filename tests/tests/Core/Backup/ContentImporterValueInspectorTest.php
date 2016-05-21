<?php

class ContentImporterValueInspectorTest extends FileStorageTestCase
{
    
    protected function setUp()
    {
        $this->tables = array_merge($this->tables, array(
            'Files',
            'FileVersions',
            'Users',
            'PermissionAccessEntityTypes',
        ));
        parent::setUp();
    }

    public function testMake()
    {
        $inspector = Core::make('import/value_inspector/core');
        $this->assertInstanceOf('\Concrete\Core\Backup\ContentImporter\ValueInspector\ValueInspectorInterface', $inspector);
    }

    public function testRegister()
    {
        $inspector = Core::make('import/value_inspector/core');
        $inspector->registerInspectionRoutine(new \Concrete\Core\Backup\ContentImporter\ValueInspector\InspectionRoutine\PageRoutine());
        $this->assertEquals(1, count($inspector->getInspectionRoutines()));
    }

    public function testMakeCore()
    {
        $inspector = Core::make('import/value_inspector');
        $this->assertEquals(6, count($inspector->getInspectionRoutines()));
    }

    public function providerMatchedSimpleValues()
    {
        return array(
            array('{ccm:export:page:/ok/here/we-go}', '/ok/here/we-go', '\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageItem'),
            array('{ccm:export:file:house.jpg}', 'house.jpg', '\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\FileItem'),
            array('{ccm:export:pagetype:blog}', 'blog', '\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageTypeItem'),
            array('{ccm:export:pagefeed:rss}', 'rss', '\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageFeedItem'),
            array('{ccm:export:image:my_cool_pic.jpg}', 'my_cool_pic.jpg', '\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ImageItem'),
            array('<concrete-picture file="avatar.jpg"></concrete-picture>', 'avatar.jpg', '\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PictureItem'),
        );
    }

    /**
     * @dataProvider providerMatchedSimpleValues
     */
    public function testMatchedSimpleValues($content, $reference, $itemClass)
    {
        $inspector = Core::make('import/value_inspector');
        $result = $inspector->inspect($content, false);
        $items = $result->getMatchedItems();
        $this->assertEquals(1, count($items));
        $item = $items[0];
        $this->assertInstanceOf('\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ItemInterface', $item);
        $this->assertEquals($reference, $item->getReference());
        $this->assertInstanceOf($itemClass, $item);
    }

    public function testMatchedContentPageAndImage()
    {
        $content = <<<EOL
        <p>This is a content block. It is amazing. <a href="{ccm:export:page:/path/to/page}">Link 1</a>.
        Don't forget a second <a href="{ccm:export:page:/about}">link.</a>. Also, we're going to embed a picture
        here too. <concrete-picture alt="cats are cool"  file="cats.jpg">. It's a pretty good one. <a href="thumbs_up.html">Thumbs up!</a>

        Excellent! <a href="{ccm:export:page:/}">See you later!</a>
EOL;

        $inspector = Core::make('import/value_inspector');
        $result = $inspector->inspect($content);
        $items = $result->getMatchedItems();
        $this->assertEquals(4, count($items));
        $this->assertEquals($items[0]->getReference(), '/path/to/page');
        $this->assertEquals($items[1]->getReference(), '/about');
        $this->assertEquals($items[2]->getReference(), '/');
        $this->assertEquals($items[3]->getReference(), 'cats.jpg');
        $this->assertInstanceOf('\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageItem', $items[0]);
        $this->assertInstanceOf('\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageItem', $items[1]);
        $this->assertInstanceOf('\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageItem', $items[2]);
        $this->assertInstanceOf('\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PictureItem', $items[3]);
    }

    public function testMatchedContentFilePageTypePageFeed()
    {
        $content = <<<EOL
        <p>Here is a link to an <a href="{ccm:export:pagefeed:blog}">rss feed</a>. We're also linking to a
        <a href="{ccm:export:file:filename1.jpg}">couple</a> of <A href="{ccm:export:file:filename2.JPG}">files.</a>.
        Finally, we're also going to link to a pagetype here: {ccm:export:pagetype:blog_entry}.
EOL;

        $inspector = Core::make('import/value_inspector');
        $result = $inspector->inspect($content);
        $items = $result->getMatchedItems();
        $this->assertEquals(4, count($items));
        $this->assertEquals($items[0]->getReference(), 'filename1.jpg');
        $this->assertEquals($items[1]->getReference(), 'filename2.JPG');
        $this->assertEquals($items[2]->getReference(), 'blog');
        $this->assertEquals($items[3]->getReference(), 'blog_entry');
        $this->assertInstanceOf('\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\FileItem', $items[0]);
        $this->assertInstanceOf('\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\FileItem', $items[1]);
        $this->assertInstanceOf('\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageFeedItem', $items[2]);
        $this->assertInstanceOf('\Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageTypeItem', $items[3]);
    }

    public function testReplacedContent()
    {
        // create the default storage location first.
        mkdir($this->getStorageDirectory());
        $this->getStorageLocation();
        
        $importer = new Concrete\Core\File\Importer;
        $prefix = $importer->generatePrefix();
        Concrete\Core\File\File::add('test.jpg', $prefix);
        
        $content = <<<EOL
        <p><concrete-picture alt="Lorem ipsum" file="test.jpg">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip <concrete-picture file="test.jpg" alt="ex ea commodo consequat." width="200" height="100" style="border: 1px solid black;" /></p>
EOL;

        $expected = <<<EOL
        <p><concrete-picture fID="1" />Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip <concrete-picture fID="1" /></p>
EOL;
        
        $inspector = Core::make('import/value_inspector');
        $result = $inspector->inspect($content);
        
        $this->assertEquals($expected, $result->getReplacedContent());
    }

}
