<?php 

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class CustomAccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // If user is authenticated but doesn't have access, handle it as per your requirement
            // For example, show a custom access denied page
            // return new Response('Access Denied!', 403);
        }

        // Redirect unauthenticated users to the login page
        return new RedirectResponse('/login');
    }
}
