<?php

declare(strict_types=1);

namespace Admin\View;

use Laminas\View\Helper\AbstractHelper;

/**
 * Class PhpInfo
 *
 * @package Admin\View
 */
class PhpInfo extends AbstractHelper
{
    /**
     * @return mixed|string
     */
    public function __invoke()
    {
        ob_start();
        phpinfo(INFO_MODULES);
        $phpInfo = ob_get_contents();
        ob_end_clean();

        preg_match_all('#<body[^>]*>(.*)</body>#siU', $phpInfo, $output);

        $output = (count($output[1]) > 0) ? $output[1][0] : $phpInfo;
        $output = preg_replace('#<table#', '<table class="table table-bordered"', $output);
        $output = preg_replace('#(\w),(\w)#', '\1, \2', $output);
        $output = preg_replace('#border="0" cellpadding="3" width="600"#', '', $output);
        $output = preg_replace('#<hr />#', '', $output);
        $output = str_replace('<div class="center">', '', $output);
        $output = str_replace('</div>', '', $output);

        return $output;
    }
}
