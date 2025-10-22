<?php

namespace App\Session;

use Illuminate\Session\DatabaseSessionHandler;

class CustomDatabaseSessionHandler extends DatabaseSessionHandler
{
     /**
      * Get the user ID for the session.
      *
      * @return mixed
      */
     protected function userId()
     {
          return $this->container->bound('auth') && $this->container->make('auth')->check()
               ? $this->container->make('auth')->user()->getAuthIdentifier()
               : null;
     }

     /**
      * Add the user information to the session payload.
      *
      * @param  array  $payload
      * @return $this
      */
     protected function addUserInformation(&$payload)
     {
          if ($this->container->bound('auth')) {
               $payload['id_user'] = $this->userId(); // Ubah dari user_id ke id_user
          }

          return $this;
     }
}
