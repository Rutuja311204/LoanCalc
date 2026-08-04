<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (! $session->get('isLoggedIn')) {
            $session->setFlashdata('error', 'Please login to continue.');

            return redirect()->to('/login');
        }

        if ($session->get('role') !== 'admin') {
            $session->setFlashdata('error', 'You are not authorized to access the admin panel.');

            return redirect()->to('/dashboard');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after.
    }
}
