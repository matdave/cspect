<?php
namespace CSPect\Model;

use xPDO\xPDO;

/**
 * Class CSPSource
 *
 * @property string $name
 * @property integer $rank
 *
 * @property \CSPect\Model\CSPSourceDirective[] $Directives
 * @property \CSPect\Model\CSPSourceContext[] $Contexts
 *
 * @package CSPect\Model
 */
class CSPSource extends \xPDO\Om\xPDOSimpleObject
{
}
