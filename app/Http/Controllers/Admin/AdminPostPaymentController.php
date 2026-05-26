<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PostPaymentDetail;
use App\Models\Order;

class AdminPostPaymentController extends Controller
{
    public function index()
    {
        $details = PostPaymentDetail::with(['user', 'order.service'])->latest()->get();
        return view('admin.post_payments.index', compact('details'));
    }

    public function export()
    {
        $details = PostPaymentDetail::with(['user', 'order'])->latest()->get();

        $filename = "post_payment_details_" . date('Y-m-d_H-i') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID', 'Order ID', 'Customer Name', 'Customer Email', 'Customer Phone', 
            'Service Name', 'Submitted At', 'Form Data (JSON)', 'Uploaded Files (Links)'
        ];

        $callback = function() use($details, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($details as $detail) {
                // Flatten files into a comma-separated string of URLs
                $fileUrls = [];
                if (is_array($detail->uploaded_files)) {
                    foreach ($detail->uploaded_files as $f) {
                        // Create absolute URL using asset helper
                        $fileUrls[] = asset($f['url']);
                    }
                }
                $fileString = implode(" | ", $fileUrls);

                // Encode the flexible form data back to JSON for the CSV cell so no data is lost
                $dataJson = json_encode($detail->data);

                fputcsv($file, [
                    $detail->id,
                    $detail->order_id,
                    $detail->user->name ?? 'N/A',
                    $detail->user->email ?? 'N/A',
                    $detail->user->phone ?? 'N/A',
                    $detail->service_name,
                    $detail->created_at->format('Y-m-d H:i:s'),
                    $dataJson,
                    $fileString
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
