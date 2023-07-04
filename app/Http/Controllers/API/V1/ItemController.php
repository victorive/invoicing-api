<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ItemRequest;
use App\Http\Resources\V1\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller
{
    public function getAllItems(Request $request): JsonResponse
    {
        $items = Item::query();

        if ($request->has('query')) {
            $items->whereFullText('name', $request->input('query'));
        }

        $items = $items->where('user_id', $request->user()->id)->get();

        if ($items->isEmpty()) {
            return response()->success('No items yet',
                null, Response::HTTP_OK);
        }

        return response()->success('Items retrieved successfully',
            ItemResource::collection($items), Response::HTTP_OK);
    }

    public function createItem(ItemRequest $itemRequest): JsonResponse
    {
        $data = $itemRequest->validated();
        $data['user_id'] = $itemRequest->user()->id;

        $item = Item::query()->create($data);

        return response()->success('Item created successfully', ItemResource::make($item), Response::HTTP_CREATED);
    }

    public function findItemById(Request $request, int $itemId): JsonResponse
    {
        $item = Item::query()->where('user_id', $request->user()->id)
            ->where('id', $itemId)
            ->first();

        if (!$item) {
            return response()->error('Item not found', Response::HTTP_NOT_FOUND);
        }

        return response()->success('Item found', ItemResource::make($item), Response::HTTP_OK);
    }

    public function updateItem(ItemRequest $itemRequest, int $itemId): JsonResponse
    {
        $item = Item::query()->where('user_id', $itemRequest->user()->id)
            ->where('id', $itemId)
            ->first();

        if (!$item) {
            return response()->error('Item not found', Response::HTTP_NOT_FOUND);
        }

        $this->authorize('update', $item);

        $item = tap($item, function ($item) use ($itemRequest) {
            $item->update($itemRequest->validated());
        });

        return response()->json([
            'status' => true,
            'message' => 'Item updated successfully',
            'data' => ItemResource::make($item)
        ], Response::HTTP_OK);
    }

    public function deleteItem(Request $request, int $itemId): JsonResponse
    {
        $item = Item::query()->where('user_id', $request->user()->id)
            ->where('id', $itemId)
            ->first();

        if (!$item) {
            return response()->error('Item not found', Response::HTTP_NOT_FOUND);
        }

        $this->authorize('delete', $item);

        $item->delete();

        return response()->success('Item deleted successfully', null, Response::HTTP_OK);
    }
}
