<?php namespace Jhendess\FusionAuth;

use Backend;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use RainLab\User\Facades\Auth;
use System\Classes\PluginBase;
use Jhendess\FusionAuth\Classes\FusionLoginCheck;

/**
 * fusionAuth Plugin Information File
 */
class Plugin extends PluginBase {

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return [
            "name" => "PHP Fusion User Authentication Plugin",
            "description" => "Provides user authentication for migrated PHP Fusion users",
            'author' => 'Jakob Hendeß',
            'icon' => 'icon-user',
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot() {
        Event::listen('rainlab.user.beforeAuthenticate', function ($component, $credentials) {
            $login = array_get($credentials, 'login');
            $password = array_get($credentials, 'password');

            /*
             * No such user exists
             */
            if (!$user = Auth::findUserByLogin($login)) {
                return;
            }

            /*
             * The user is logging in with his old PHP Fusion account
             * for the first time. Rehash his password using the new
             * October system.
             */
            if ($user->fusion_algo !== null) {
                if (FusionLoginCheck::checkPassword($password, $user->password, $user->fusion_salt, $user->fusion_algo)) {
                    $user->password = $user->password_confirmation = $password;
                    $user->fusion_salt = null;
                    $user->fusion_algo = null;
                    $user->forceSave();
                    Log::info("User migration for user " . $user->name . " succeeded");
                } else {
                    Log::warning("User migration for user ".$user->name." failed");
                }
            }
        });
    }
}
