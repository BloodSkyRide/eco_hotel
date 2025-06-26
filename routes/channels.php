<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('realtime-channel', function ($user) {
    // Este canal es público, por lo tanto no hay restricciones

    return true;
});

Broadcast::channel('user-{id}', function ($user, $id) {
    // Asegúrate de que la cédula del usuario coincida con el ID
    return (int) $user->cedula == (int) $id;
}, ['middleware' => ['auth:api']]);
