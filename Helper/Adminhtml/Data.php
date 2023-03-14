<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Faonni\ReCaptcha\Helper\Adminhtml;

use Faonni\ReCaptcha\Helper\Data as AbstractHelper;

/**
 * Adminhtml Helper
 */
class Data extends AbstractHelper
{
    /**
     * Enabled config path
     */
    protected const XML_ENABLED = 'admin/recaptcha/enabled';

    /**
     * Site Key config path
     */
    protected const XML_SITE_KEY = 'admin/recaptcha/site_key';

    /**
     * Secret Key config path
     */
    protected const XML_SECRET_KEY = 'admin/recaptcha/secret_key';

    /**
     * Allowed forms config path
     */
    protected const XML_FORMS = 'admin/recaptcha/forms';

    /**
     * Type of ReCaptcha config path
     */
    protected const XML_TYPE = 'admin/recaptcha/type';

    /**
     * Size of ReCaptcha config path
     */
    protected const XML_SIZE = 'admin/recaptcha/size';

    /**
     * Color theme of ReCaptcha config path
     */
    protected const XML_THEME = 'admin/recaptcha/theme';
}
