<?php


use SweetAlert2\Laravel\Swal;

//Success alert
if (!function_exists('alertSuccess')) {
    function alertSuccess(string $message, array $options = [])
    {
        $defaults = [
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timerProgressBar' => true,
            'title' => $message,
            'timer' => 2000,
        ];

        Swal::toastSuccess(array_merge($defaults, $options));
    }
}
//Warning alert
if (!function_exists('alertWarning')) {
    function alertWarning(string $message, array $options = [])
    {
        $defaults = [
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timerProgressBar' => true,
            'title' => $message,
            'timer' => 2000,
        ];

        Swal::toastWarning(array_merge($defaults, $options));
    }
}
//Error alert
if (!function_exists('alertError')) {
    function alertError(string $message, array $options = [])
    {
        $defaults = [
            'position' => 'top-end',
            'showConfirmButton' => false,
            'timerProgressBar' => true,
            'title' => $message,
            'timer' => 2000,
        ];

        Swal::toastError(array_merge($defaults, $options));
    }
}
//per page helper
if (!function_exists('perPage')) {
    function perPage()
    {
        return request('per_page', 10);
    }
}

