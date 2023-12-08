<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Main\ApiController;

use Modules\Rest\Manager\AbstractManager;

/**
 * @OA\Info(
 *     title="SkeletonApp",
 *     version="1.0 Alfa",
 *     description="`SkeletonApp` nuzt **PHP Framework Slim 4**, **Eloquint ORM**, **Monolog Logger** und **OpenApi**.",
 *     termsOfService="http://example.com/terms/",
 *     @OA\Contact(
 *          name="Sergey Tevs",
 *          url="https://www.tevs.org/",
 *          email="sergey@tevs.org"
 *     ),
 *     @OA\License(
 *          name="Licence Apache 2.0",
 *          url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * ),
 * @OA\Server(
 *     url="/api/v1",
 *     description="Development",
 * ),
 * @OA\Server(
 *     url="https://www.tevs.org/api/v1",
 *     description="Production",
 * ),
 * @OA\SecurityScheme (
 *     type="oauth2",
 *     securityScheme="oauth2",
 *     @OA\Flow (
 *         flow="password",
 *         tokenUrl="/api/v1/oauth/token",
 *         refreshUrl="/api/v1/oauth/check_token?token=",
 *         scopes={
 *             "read": "read all",
 *             "trust": "trust all",
 *             "write": "write all"
 *         }
 *     )
 * )
 */
class IndexController extends AbstractManager {

    public function options(): array {
        return [];
    }

    protected function registerFunctions(): void {
        // TODO: Implement registerFunctions() method.
    }
}
