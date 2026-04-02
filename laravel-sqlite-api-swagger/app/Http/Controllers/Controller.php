<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Laravel Students API",
    version: "1.0.0",
    description: "API for managing students",
    contact: new OA\Contact(email: "admin@example.com")
)]
abstract class Controller
{
    //
}
