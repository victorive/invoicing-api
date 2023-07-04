<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\V1\Invoice\CreateInvoiceAction;
use App\Actions\V1\Invoice\UpdateInvoiceAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\InvoiceRequest;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function __construct(private CreateInvoiceAction $createInvoiceAction)
    {
    }

    public function getAllInvoices(Request $request): JsonResponse
    {
        $invoices = Invoice::query()->with('items');

        if ($request->has('invoice_code')) {
            $invoices->where('invoice_code', $request->input('invoice_code'));
        }

        $invoices = $invoices->paginate();

        return response()->success('Invoices retrieved successfully',
            InvoiceResource::collection($invoices), Response::HTTP_OK);
    }

    public function createInvoice(InvoiceRequest $invoiceRequest): JsonResponse
    {
        $invoice = $this->createInvoiceAction->execute($invoiceRequest->validated(), $invoiceRequest->user());

        return response()->success('Invoice created successfully',
            InvoiceResource::make($invoice), Response::HTTP_CREATED);
    }

    public function findInvoiceById(Request $request, int $invoiceId): JsonResponse
    {
        $invoice = Invoice::query()->where('id', $invoiceId)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$invoice) {
            return response()->error('Invoice not found', Response::HTTP_NOT_FOUND);
        }

        return response()->success('Invoice found',
            InvoiceResource::make($invoice), Response::HTTP_OK);
    }

    public function deleteInvoice(Request $request, int $invoiceId): JsonResponse
    {
        $invoice = Invoice::query()->where('id', $invoiceId)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$invoice) {
            return response()->error('Invoice not found', Response::HTTP_NOT_FOUND);
        }

        $invoice->delete();

        return response()->success('Invoice deleted successfully', null, Response::HTTP_OK);
    }
}
