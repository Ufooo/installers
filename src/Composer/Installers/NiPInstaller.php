<?php
namespace Composer\Installers;

class NiPInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'app/Modules/{$name}/',
        'theme' => 'app/Themes/{$name}/'
    );

    /**
     * Format package name.
     *
     * For package type nip-module, cut off a trailing '-plugin' if present.
     *
     * For package type nip-theme, cut off a trailing '-theme' if present.
     *
     */
    public function inflectPackageVars($vars)
    {
        if ($vars['type'] === 'nip-module') {
            return $this->inflectPluginVars($vars);
        }

        if ($vars['type'] === 'nip-theme') {
            return $this->inflectThemeVars($vars);
        }

        return $vars;
    }

    protected function inflectPluginVars($vars)
    {
        $vars['name'] = preg_replace('/-module$/', '', $vars['name']);
        $vars['name'] = str_replace(array('-', '_'), ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));

        return $vars;
    }

    protected function inflectThemeVars($vars)
    {
        $vars['name'] = preg_replace('/-theme$/', '', $vars['name']);
        $vars['name'] = str_replace(array('-', '_'), ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));

        return $vars;
    }
}
