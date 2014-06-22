<?php

return array(
    'version' => '5.7.0a6',

    /**
     * App Aliases
     */
    'aliases'   => array(
        'Request'                              => '\Concrete\Core\Http\Request',
        'Environment'                          => '\Concrete\Core\Foundation\Environment',
        'Localization'                         => '\Concrete\Core\Localization\Localization',
        'Response'                             => '\Concrete\Core\Http\Response',
        'Redirect'                             => '\Concrete\Core\Routing\Redirect',
        'URL'                                  => '\Concrete\Core\Routing\URL',
        'Cookie'                               => '\Concrete\Core\Cookie\Cookie',
        'Cache'                                => '\Concrete\Core\Cache\Cache',
        'CacheLocal'                           => '\Concrete\Core\Cache\CacheLocal',
        'CollectionAttributeKey'               => '\Concrete\Core\Attribute\Key\CollectionKey',
        'FileAttributeKey'                     => '\Concrete\Core\Attribute\Key\FileKey',
        'UserAttributeKey'                     => '\Concrete\Core\Attribute\Key\UserKey',
        'AttributeSet'                         => '\Concrete\Core\Attribute\Set',
        'AssetList'                            => '\Concrete\Core\Asset\AssetList',
        'Router'                               => '\Concrete\Core\Routing\Router',
        'RedirectResponse'                     => '\Concrete\Core\Routing\RedirectResponse',
        'Page'                                 => '\Concrete\Core\Page\Page',
        'PageEditResponse'                     => '\Concrete\Core\Page\EditResponse',
        'Controller'                           => '\Concrete\Core\Controller\Controller',
        'PageController'                       => '\Concrete\Core\Page\Controller\PageController',
        'SinglePage'                           => '\Concrete\Core\Page\Single',
        'Config'                               => '\Concrete\Core\Config\Config',
        'PageType'                             => '\Concrete\Core\Page\Type\Type',
        'PageTemplate'                         => '\Concrete\Core\Page\Template',
        'PageTheme'                            => '\Concrete\Core\Page\Theme\Theme',
        'PageList'                             => '\Concrete\Core\Page\PageList',
        'PageCache'                            => '\Concrete\Core\Cache\Page\PageCache',
        'Conversation'                         => '\Concrete\Core\Conversation\Conversation',
        'ConversationMessage'                  => '\Concrete\Core\Conversation\Message',
        'ConversationFlagType'                 => '\Concrete\Core\Conversation\FlagType\FlagType',
        'Queue'                                => '\Concrete\Core\Foundation\Queue',
        'Block'                                => '\Concrete\Core\Block\Block',
        'Marketplace'                          => '\Concrete\Core\Marketplace\Marketplace',
        'BlockType'                            => '\Concrete\Core\Block\BlockType\BlockType',
        'BlockTypeList'                        => '\Concrete\Core\Block\BlockType\BlockTypeList',
        'BlockTypeSet'                         => '\Concrete\Core\Block\BlockType\Set',
        'Package'                              => '\Concrete\Core\Package\Package',
        'Collection'                           => '\Concrete\Core\Page\Collection\Collection',
        'CollectionVersion'                    => '\Concrete\Core\Page\Collection\Version\Version',
        'Area'                                 => '\Concrete\Core\Area\Area',
        'GlobalArea'                           => '\Concrete\Core\Area\GlobalArea',
        'Stack'                                => '\Concrete\Core\Page\Stack\Stack',
        'StackList'                            => '\Concrete\Core\Page\Stack\StackList',
        'View'                                 => '\Concrete\Core\View\View',
        'Job'                                  => '\Concrete\Core\Job\Job',
        'Workflow'                             => '\Concrete\Core\Workflow\Workflow',
        'JobSet'                               => '\Concrete\Core\Job\Set',
        'File'                                 => '\Concrete\Core\File\File',
        'FileVersion'                          => '\Concrete\Core\File\Version',
        'FileSet'                              => '\Concrete\Core\File\Set\Set',
        'FileImporter'                         => '\Concrete\Core\File\Importer',
        'Group'                                => '\Concrete\Core\User\Group\Group',
        'GroupSet'                             => '\Concrete\Core\User\Group\GroupSet',
        'GroupSetList'                         => '\Concrete\Core\User\Group\GroupSetList',
        'GroupList'                            => '\Concrete\Core\User\Group\GroupList',
        'FileList'                             => '\Concrete\Core\File\FileList',
        'QueueableJob'                         => '\Concrete\Core\Job\QueueableJob',
        'Permissions'                          => '\Concrete\Core\Permission\Checker',
        'PermissionKey'                        => '\Concrete\Core\Permission\Key\Key',
        'PermissionKeyCategory'                => '\Concrete\Core\Permission\Category',
        'PermissionAccess'                     => '\Concrete\Core\Permission\Access\Access',
        'User'                                 => '\Concrete\Core\User\User',
        'UserInfo'                             => '\Concrete\Core\User\UserInfo',
        'UserList'                             => '\Concrete\Core\User\UserList',
        'StartingPointPackage'                 => '\Concrete\Core\Package\StartingPointPackage',
        'AuthenticationType'                   => '\Concrete\Core\Authentication\AuthenticationType',
        'ConcreteAuthenticationTypeController' => '\Concrete\Core\Authentication\Type\Concrete',
        'FacebookAuthenticationTypeController' => '\Concrete\Core\Authentication\Type\Facebook',
        'GroupTree'                            => '\Concrete\Core\Tree\Type\Group',
        'GroupTreeNode'                        => '\Concrete\Core\Tree\Node\Type\Group',
        'Zend_Queue_Adapter_Concrete5'         => '\Concrete\Core\Utility\ZendQueueAdapter',
        'Loader'                               => '\Concrete\Core\Legacy\Loader',
        'TaskPermission'                       => '\Concrete\Core\Legacy\TaskPermission',
        'FilePermissions'                      => '\Concrete\Core\Legacy\FilePermissions'
    ),
    /**
     * App Service providers
     */
    'providers' => array(
        '\Concrete\Core\File\FileServiceProvider',
        '\Concrete\Core\Encryption\EncryptionServiceProvider',
        '\Concrete\Core\Validation\ValidationServiceProvider',
        '\Concrete\Core\Localization\LocalizationServiceProvider',
        '\Concrete\Core\Feed\FeedServiceProvider',
        '\Concrete\Core\Html\HtmlServiceProvider',
        '\Concrete\Core\Mail\MailServiceProvider',
        '\Concrete\Core\Application\ApplicationServiceProvider',
        '\Concrete\Core\Utility\UtilityServiceProvider',
        '\Concrete\Core\Database\DatabaseServiceProvider',
        '\Concrete\Core\Form\FormServiceProvider',
        '\Concrete\Core\Session\SessionServiceProvider',
        '\Concrete\Core\Http\HttpServiceProvider',
        '\Concrete\Core\Events\EventsServiceProvider',
        '\Concrete\Core\Error\Provider\WhoopsServiceProvider',
        '\Concrete\Core\Logging\LoggingServiceProvider'
    ),
    /**
     * App Routes
     */
    'routes'    => array(

        /**
         * Install
         */
        '/install'                                                                      => array('\Concrete\Controller\Install::view'),
        '/install/select_language'                                                      => array('\Concrete\Controller\Install::select_language'),
        '/install/setup'                                                                => array('\Concrete\Controller\Install::setup'),
        '/install/test_url/{num1}/{num2}'                                               => array('\Concrete\Controller\Install::test_url'),
        '/install/configure'                                                            => array('\Concrete\Controller\Install::configure'),
        '/install/run_routine/{pkgHandle}/{routine}'                                    => array('\Concrete\Controller\Install::run_routine'),
        /**
         * Tools - legacy
         */
        '/tools/blocks/{btHandle}/{tool}'                                               => array(
            '\Concrete\Core\Legacy\Controller\ToolController::displayBlock',
            'blockTool',
            array('tool' => '[A-Za-z0-9_/.]+')),
        '/tools/{tool}'                                                                 => array(
            '\Concrete\Core\Legacy\Controller\ToolController::display',
            'tool',
            array('tool' => '[A-Za-z0-9_/.]+')),
        /**
         * Dialog
         */
        '/ccm/system/dialogs/page/delete/'                                              => array('\Concrete\Controller\Dialog\Page\Delete::view'),
        '/ccm/system/dialogs/page/delete/submit'                                        => array('\Concrete\Controller\Dialog\Page\Delete::submit'),
        '/ccm/system/dialogs/area/layout/presets/submit/{arLayoutID}'                   => array('\Concrete\Controller\Dialog\Area\Layout\Presets::submit'),
        '/ccm/system/dialogs/area/layout/presets/{arLayoutID}/{token}'                  => array('\Concrete\Controller\Dialog\Area\Layout\Presets::view'),
        '/ccm/system/dialogs/page/bulk/properties'                                      => array('\Concrete\Controller\Dialog\Page\Bulk\Properties::view'),
        '/ccm/system/dialogs/page/bulk/properties/update_attribute'                     => array('\Concrete\Controller\Dialog\Page\Bulk\Properties::updateAttribute'),
        '/ccm/system/dialogs/page/bulk/properties/clear_attribute'                      => array('\Concrete\Controller\Dialog\Page\Bulk\Properties::clearAttribute'),
        '/ccm/system/dialogs/page/design'                                               => array('\Concrete\Controller\Dialog\Page\Design::view'),
        '/ccm/system/dialogs/page/design/submit'                                        => array('\Concrete\Controller\Dialog\Page\Design::submit'),
        '/ccm/system/dialogs/user/search'                                               => array('\Concrete\Controller\Dialog\User\Search::view'),
        '/ccm/system/dialogs/group/search'                                              => array('\Concrete\Controller\Dialog\Group\Search::view'),
        '/ccm/system/dialogs/file/search'                                               => array('\Concrete\Controller\Dialog\File\Search::view'),
        '/ccm/system/dialogs/page/design/css'                                           => array('\Concrete\Controller\Dialog\Page\Design\Css::view'),
        '/ccm/system/dialogs/page/design/css/submit'                                    => array('\Concrete\Controller\Dialog\Page\Design\Css::submit'),
        '/ccm/system/dialogs/page/search'                                               => array('\Concrete\Controller\Dialog\Page\Search::view'),
        '/ccm/system/dialogs/page/attributes'                                           => array('\Concrete\Controller\Dialog\Page\Attributes::view'),
        '/ccm/system/dialogs/user/bulk/properties'                                      => array('\Concrete\Controller\Dialog\User\Bulk\Properties::view'),
        '/ccm/system/dialogs/user/bulk/properties/update_attribute'                     => array('\Concrete\Controller\Dialog\User\Bulk\Properties::updateAttribute'),
        '/ccm/system/dialogs/user/bulk/properties/clear_attribute'                      => array('\Concrete\Controller\Dialog\User\Bulk\Properties::clearAttribute'),
        '/ccm/system/dialogs/file/properties'                                           => array('\Concrete\Controller\Dialog\File\Properties::view'),
        '/ccm/system/dialogs/file/properties/save'                                      => array('\Concrete\Controller\Dialog\File\Properties::save'),
        '/ccm/system/dialogs/file/properties/update_attribute'                          => array('\Concrete\Controller\Dialog\File\Properties::update_attribute'),
        '/ccm/system/dialogs/file/properties/clear_attribute'                           => array('\Concrete\Controller\Dialog\File\Properties::clear_attribute'),
        '/ccm/system/dialogs/file/bulk/properties'                                      => array('\Concrete\Controller\Dialog\File\Bulk\Properties::view'),
        '/ccm/system/dialogs/file/bulk/properties/update_attribute'                     => array('\Concrete\Controller\Dialog\File\Bulk\Properties::updateAttribute'),
        '/ccm/system/dialogs/file/bulk/properties/clear_attribute'                      => array('\Concrete\Controller\Dialog\File\Bulk\Properties::clearAttribute'),
        '/ccm/system/dialogs/page/add_block'                                            => array('\Concrete\Controller\Dialog\Page\AddBlock::view'),
        '/ccm/system/dialogs/page/add_block/submit'                                     => array('\Concrete\Controller\Dialog\Page\AddBlock::submit'),
        '/ccm/system/dialogs/page/search/customize'                                     => array('\Concrete\Controller\Dialog\Page\Search\Customize::view'),
        '/ccm/system/dialogs/page/search/customize/submit'                              => array('\Concrete\Controller\Dialog\Page\Search\Customize::submit'),
        '/ccm/system/dialogs/file/search/customize'                                     => array('\Concrete\Controller\Dialog\File\Search\Customize::view'),
        '/ccm/system/dialogs/file/search/customize/submit'                              => array('\Concrete\Controller\Dialog\File\Search\Customize::submit'),
        '/ccm/system/dialogs/user/search/customize'                                     => array('\Concrete\Controller\Dialog\User\Search\Customize::view'),
        '/ccm/system/dialogs/user/search/customize/submit'                              => array('\Concrete\Controller\Dialog\User\Search\Customize::submit'),
        /**
         * Files
         */
        '/ccm/system/file/star'                                                         => array('\Concrete\Controller\Backend\File::star'),
        '/ccm/system/file/rescan'                                                       => array('\Concrete\Controller\Backend\File::rescan'),
        '/ccm/system/file/approve_version'                                              => array('\Concrete\Controller\Backend\File::approveVersion'),
        '/ccm/system/file/delete_version'                                               => array('\Concrete\Controller\Backend\File::deleteVersion'),
        '/ccm/system/file/get_json'                                                     => array('\Concrete\Controller\Backend\File::getJSON'),
        '/ccm/system/file/duplicate'                                                    => array('\Concrete\Controller\Backend\File::duplicate'),
        '/ccm/system/file/upload'                                                       => array('\Concrete\Controller\Backend\File::upload'),
        /**
         * Users
         */
        '/ccm/system/user/add_group'                                                    => array('\Concrete\Controller\Backend\User::addGroup'),
        '/ccm/system/user/remove_group'                                                 => array('\Concrete\Controller\Backend\User::removeGroup'),
        /**
         * Page actions - non UI
         */
        '/ccm/system/page/check_in/{cID}/{token}'                                       => array('\Concrete\Controller\Panel\Page\CheckIn::exitEditMode'),
        '/ccm/system/page/create/{ptID}'                                                => array('\Concrete\Controller\Backend\Page::create'),
        '/ccm/system/page/arrange_blocks/'                                              => array('\Concrete\Controller\Backend\Page\ArrangeBlocks::arrange'),
        /**
         * Misc
         */
        '/ccm/system/css/page/{cID}/{cvID}/{stylesheet}'                                => array('\Concrete\Controller\Frontend\Stylesheet::page'),
        '/ccm/system/css/layout/{bID}'                                                  => array('\Concrete\Controller\Frontend\Stylesheet::layout'),
        /**
         * Search Routes
         */
        '/ccm/system/search/pages/submit'                                               => array('\Concrete\Controller\Search\Pages::submit'),
        '/ccm/system/search/pages/field/{field}'                                        => array('\Concrete\Controller\Search\Pages::field'),
        '/ccm/system/search/files/submit'                                               => array('\Concrete\Controller\Search\Files::submit'),
        '/ccm/system/search/files/field/{field}'                                        => array('\Concrete\Controller\Search\Files::field'),
        '/ccm/system/search/users/submit'                                               => array('\Concrete\Controller\Search\Users::submit'),
        '/ccm/system/search/users/field/{field}'                                        => array('\Concrete\Controller\Search\Users::field'),
        '/ccm/system/search/groups/submit'                                              => array('\Concrete\Controller\Search\Groups::submit'),
        /**
         * Panels - top level
         */
        '/ccm/system/panels/dashboard'                                                  => array('\Concrete\Controller\Panel\Dashboard::view'),
        '/ccm/system/panels/sitemap'                                                    => array('\Concrete\Controller\Panel\Sitemap::view'),
        '/ccm/system/panels/add'                                                        => array('\Concrete\Controller\Panel\Add::view'),
        '/ccm/system/panels/page'                                                       => array('\Concrete\Controller\Panel\Page::view'),
        '/ccm/system/panels/page/attributes'                                            => array('\Concrete\Controller\Panel\Page\Attributes::view'),
        '/ccm/system/panels/page/design'                                                => array('\Concrete\Controller\Panel\Page\Design::view'),
        '/ccm/system/panels/page/design/preview_contents'                               => array('\Concrete\Controller\Panel\Page\Design::preview_contents'),
        '/ccm/system/panels/page/design/submit'                                         => array('\Concrete\Controller\Panel\Page\Design::submit'),
        '/ccm/system/panels/page/design/customize/preview/{pThemeID}'                   => array('\Concrete\Controller\Panel\Page\Design\Customize::preview'),
        '/ccm/system/panels/page/design/customize/apply_to_page/{pThemeID}'             => array('\Concrete\Controller\Panel\Page\Design\Customize::apply_to_page'),
        '/ccm/system/panels/page/design/customize/apply_to_site/{pThemeID}'             => array('\Concrete\Controller\Panel\Page\Design\Customize::apply_to_site'),
        '/ccm/system/panels/page/design/customize/reset_page_customizations'            => array('\Concrete\Controller\Panel\Page\Design\Customize::reset_page_customizations'),
        '/ccm/system/panels/page/design/customize/reset_site_customizations/{pThemeID}' => array('\Concrete\Controller\Panel\Page\Design\Customize::reset_site_customizations'),
        '/ccm/system/panels/page/design/customize/{pThemeID}'                           => array('\Concrete\Controller\Panel\Page\Design\Customize::view'),
        '/ccm/system/panels/page/check_in'                                              => array('\Concrete\Controller\Panel\Page\CheckIn::__construct'),
        '/ccm/system/panels/page/check_in/submit'                                       => array('\Concrete\Controller\Panel\Page\CheckIn::submit'),
        '/ccm/system/panels/page/versions'                                              => array('\Concrete\Controller\Panel\Page\Versions::view'),
        '/ccm/system/panels/page/versions/get_json'                                     => array('\Concrete\Controller\Panel\Page\Versions::get_json'),
        '/ccm/system/panels/page/versions/duplicate'                                    => array('\Concrete\Controller\Panel\Page\Versions::duplicate'),
        '/ccm/system/panels/page/versions/new_page'                                     => array('\Concrete\Controller\Panel\Page\Versions::new_page'),
        '/ccm/system/panels/page/versions/delete'                                       => array('\Concrete\Controller\Panel\Page\Versions::delete'),
        '/ccm/system/panels/page/versions/approve'                                      => array('\Concrete\Controller\Panel\Page\Versions::approve'),
        /**
         * Panel Details
         */

        '/ccm/system/panels/details/page/versions'                                      => array('\Concrete\Controller\Panel\Detail\Page\Versions::view'),
        '/ccm/system/panels/details/page/seo'                                           => array('\Concrete\Controller\Panel\Detail\Page\Seo::view'),
        '/ccm/system/panels/details/page/seo/submit'                                    => array('\Concrete\Controller\Panel\Detail\Page\Seo::submit'),
        '/ccm/system/panels/details/page/location'                                      => array('\Concrete\Controller\Panel\Detail\Page\Location::view'),
        '/ccm/system/panels/details/page/location/submit'                               => array('\Concrete\Controller\Panel\Detail\Page\Location::submit'),
        '/ccm/system/panels/details/page/preview'                                       => array('\Concrete\Controller\Panel\Page\Design::preview'),
        '/ccm/system/panels/details/page/composer'                                      => array('\Concrete\Controller\Panel\Detail\Page\Composer::view'),
        '/ccm/system/panels/details/page/composer/autosave'                             => array('\Concrete\Controller\Panel\Detail\Page\Composer::autosave'),
        '/ccm/system/panels/details/page/composer/publish'                              => array('\Concrete\Controller\Panel\Detail\Page\Composer::publish'),
        '/ccm/system/panels/details/page/composer/discard'                              => array('\Concrete\Controller\Panel\Detail\Page\Composer::discard'),
        '/ccm/system/panels/details/page/attributes'                                    => array('\Concrete\Controller\Panel\Detail\Page\Attributes::view'),
        '/ccm/system/panels/details/page/attributes/submit'                             => array('\Concrete\Controller\Panel\Detail\Page\Attributes::submit'),
        '/ccm/system/panels/details/page/attributes/add_attribute'                      => array('\Concrete\Controller\Panel\Detail\Page\Attributes::add_attribute'),
        '/ccm/system/panels/details/page/caching'                                       => array('\Concrete\Controller\Panel\Detail\Page\Caching::view'),
        '/ccm/system/panels/details/page/caching/submit'                                => array('\Concrete\Controller\Panel\Detail\Page\Caching::submit'),
        '/ccm/system/panels/details/page/caching/purge'                                 => array('\Concrete\Controller\Panel\Detail\Page\Caching::purge'),
        '/ccm/system/panels/details/page/permissions'                                   => array('\Concrete\Controller\Panel\Detail\Page\Permissions::view'),
        '/ccm/system/panels/details/page/permissions/save_simple'                       => array('\Concrete\Controller\Panel\Detail\Page\Permissions::save_simple'),
        /**
         * Special Dashboard
         */
        '/dashboard/blocks/stacks/list'                                                 => array(
            function () {
                return Redirect::to('/');
            })

    ),
    'facades'   => array(
        'Core'     => '\Concrete\Core\Support\Facade\Application',
        'Session'  => '\Concrete\Core\Support\Facade\Session',
        'Database' => '\Concrete\Core\Support\Facade\Database',
        'Events'   => '\Concrete\Core\Support\Facade\Events',
        'Route'    => '\Concrete\Core\Support\Facade\Route',
        'Log'      => '\Concrete\Core\Support\Facade\Log',
        'Image'    => '\Concrete\Core\Support\Facade\Image',
    )
);
