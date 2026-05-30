<?php
$errors = new \Illuminate\Support\MessageBag();
\Illuminate\Support\Facades\View::share('errors', clone $errors);
$html = view('admin.services', ['services' => App\Models\Service::paginate(10)])->render();
file_put_contents('c:/xampp/htdocs/refers/test_view.html', $html);
echo "View rendered.\n";
