<?php
use \Concrete\Core\File\Type\Type as FileType;

return array(
    'allowed_types' => array(
        'jpg,jpeg,jpe'         => array(t('JPEG'), FileType::T_IMAGE, 'image', 'image', 'image'),
        'gif'                  => array(t('GIF'), FileType::T_IMAGE, 'image', 'image', 'image'),
        'png'                  => array(t('PNG'), FileType::T_IMAGE, 'image', 'image', 'image'),
        'bmp'                  => array(t('Windows Bitmap'), FileType::T_IMAGE, 'image'),
        'tif,tiff'             => array(t('TIFF'), FileType::T_IMAGE, 'image'),
        'htm,html'             => array(t('HTML'), FileType::T_IMAGE),
        'swf'                  => array(t('Flash'), FileType::T_IMAGE, 'image'),
        'ico'                  => array(t('Icon'), FileType::T_IMAGE),
        'svg'                  => array(t('SVG'), FileType::T_IMAGE),
        'asf,wmv'              => array(t('Windows Video'), FileType::T_VIDEO, false, 'video'),
        'mov,qt'               => array(t('Quicktime'), FileType::T_VIDEO, false, 'video'),
        'avi'                  => array(t('AVI'), FileType::T_VIDEO, false, 'video'),
        '3gp'                  => array(t('3GP'), FileType::T_VIDEO, false, 'video'),
        'txt'                  => array(t('Plain Text'), FileType::T_TEXT, false, 'text'),
        'csv'                  => array(t('CSV'), FileType::T_TEXT, false, 'text'),
        'xml'                  => array(t('XML'), FileType::T_TEXT),
        'php'                  => array(t('PHP'), FileType::T_TEXT),
        'doc,docx'             => array(t('MS Word'), FileType::T_DOCUMENT),
        'css'                  => array(t('Stylesheet'), FileType::T_TEXT),
        'mp4'                  => array(t('MP4'), FileType::T_VIDEO),
        'flv'                  => array(t('FLV'), FileType::T_VIDEO, 'flv'),
        'mp3'                  => array(t('MP3'), FileType::T_AUDIO, false, 'audio'),
        'm4a'                  => array(t('MP4'), FileType::T_AUDIO, false, 'audio'),
        'ra,ram'               => array(t('Realaudio'), FileType::T_AUDIO),
        'wma'                  => array(t('Windows Audio'), FileType::T_AUDIO),
        'rtf'                  => array(t('Rich Text'), FileType::T_DOCUMENT),
        'js'                   => array(t('JavaScript'), FileType::T_TEXT),
        'pdf'                  => array(t('PDF'), FileType::T_DOCUMENT),
        'psd'                  => array(t('Photoshop'), FileType::T_IMAGE),
        'mpeg,mpg'             => array(t('MPEG'), FileType::T_VIDEO),
        'xla,xls,xlsx,xlt,xlw' => array(t('MS Excel'), FileType::T_DOCUMENT),
        'pps,ppt,pptx,pot'     => array(t('MS Powerpoint'), FileType::T_DOCUMENT),
        'tar'                  => array(t('TAR Archive'), FileType::T_APPLICATION),
        'zip'                  => array(t('Zip Archive'), FileType::T_APPLICATION),
        'gz,gzip'              => array(t('GZip Archive'), FileType::T_APPLICATION),
        'ogg'                  => array(t('OGG'), FileType::T_AUDIO),
        'ogv'                  => array(t('OGG Video'), FileType::T_VIDEO),
        'webm'                 => array(t('WebM'), FileType::T_VIDEO),

    ),
    'importer'      => array(
        'attributes' => array(
            'width'    => array(t('Width'), 'NUMBER', false),
            'height'   => array(t('Height'), 'NUMBER', false),
            'duration' => array(t('Duration'), 'NUMBER', false),
        )
    )
);
