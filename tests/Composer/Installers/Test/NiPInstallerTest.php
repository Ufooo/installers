<?php
namespace Composer\Installers\Test;

use Composer\Installers\NiPInstaller;
use Composer\Package\Package;
use Composer\Composer;
use PHPUnit\Framework\TestCase;

class NiPInstallerTest extends TestCase
{
    /**
     * @var NiPInstaller
     */
    private $installer;

    public function setUp()
    {
        $this->installer = new NiPInstaller(
            new Package('NyanCat', '4.2', '4.2'),
            new Composer()
        );
    }

    /**
     * @dataProvider packageNameInflectionProvider
     */
    public function testInflectPackageVars($type, $vendor, $name, $expectedVendor, $expectedName)
    {
        $this->assertEquals(
            $this->installer->inflectPackageVars(array(
                'vendor' => $vendor,
                'name' => $name,
                'type' => $type
            )),
            array('vendor' => $expectedVendor, 'name' => $expectedName, 'type' => $type)
        );
    }

    public function packageNameInflectionProvider()
    {
        return array(
            // Should keep module name StudlyCase
            array(
                'nip-module',
                'user-profile',
                'UserProfile'
            ),
            array(
                'nip-module',
                'nip-module',
                'NiP'
            ),
            array(
                'nip-module',
                'blog',
                'Blog'
            ),
            // tests that exactly one '-module' is cut off
            array(
                'nip-module',
                'some-module-module',
                'SomeModule',
            ),
            // tests that exactly one '-theme' is cut off
            array(
                'nip-theme',
                'some-theme-theme',
                'SomeTheme',
            ),
            // tests that names without '-theme' suffix stay valid
            array(
                'nip-theme',
                'someothertheme',
                'Someothertheme',
            ),
            // Should keep theme name StudlyCase
            array(
                'nip-theme',
                'adminlte-advanced',
                'AdminlteAdvanced'
            ),
        );
    }
}
