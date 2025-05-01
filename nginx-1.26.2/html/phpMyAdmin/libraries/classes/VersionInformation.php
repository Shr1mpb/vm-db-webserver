<?php
/​**​
 * Modified VersionInformation class that skips version checking
 */

declare(strict_types=1);

namespace PhpMyAdmin;

use stdClass;

/​**​
 * Modified to disable version checking
 */
class VersionInformation
{
    /​**​
     * Always returns null to skip version checking
     */
    public function getLatestVersion(): ?stdClass
    {
        return null;
    }

    /​**​
     * Empty implementation (not used when version checking is disabled)
     */
    public function versionToInt($version)
    {
        return 0;
    }

    /​**​
     * Empty implementation (not used when version checking is disabled)
     */
    public function getLatestCompatibleVersion(array $releases)
    {
        return null;
    }

    /​**​
     * Empty implementation (not used when version checking is disabled)
     */
    public function evaluateVersionCondition(string $type, string $condition)
    {
        return false;
    }

    /​**​
     * Empty implementation (not used when version checking is disabled)
     */
    protected function getPHPVersion()
    {
        return '';
    }

    /​**​
     * Empty implementation (not used when version checking is disabled)
     */
    protected function getMySQLVersion()
    {
        return null;
    }
}