<?php
namespace CSPect\Model;

use xPDO\xPDO;

/**
 * Class CSPViolation
 *
 * @property string $context_key
 * @property integer $age
 * @property string $type
 * @property string $url
 * @property string $user_agent
 * @property array $body
 *
 * @property \MODX\Revolution\modContext $Context
 *
 * @package CSPect\Model
 */
class CSPViolation extends \xPDO\Om\xPDOSimpleObject
{
}
