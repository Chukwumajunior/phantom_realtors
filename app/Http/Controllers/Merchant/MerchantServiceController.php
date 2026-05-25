<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Services\ImageService;
use Illuminate\Http\Request;

class MerchantServiceController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(Request $request)
    {
        $services = $request->user()->services()
            ->with('images')
            ->latest()
            ->paginate(10);

        return view('merchant.services.index', compact('services'));
    }

    public function create()
    {
        return view('merchant.services.create');
    }

    public function store(StoreServiceRequest $request)
    {
        $data = $request->validated();
        $images = $data['images'] ?? [];
        unset($data['images']);

        $data['user_id'] = $request->user()->id;
        $service = Service::create($data);

        if (!empty($images)) {
            $this->imageService->uploadImages($images, 'services', $service);
        }

        return redirect()->route('merchant.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        abort_unless(auth()->user()->isAdmin() || $service->user_id === auth()->id(), 403);
        $service->load('images');

        return view('merchant.services.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $data = $request->validated();
        $images = $data['images'] ?? [];
        unset($data['images']);

        $service->update($data);

        if (!empty($images)) {
            $this->imageService->uploadImages($images, 'services', $service);
        }

        return redirect()->route('merchant.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        abort_unless(auth()->user()->isAdmin() || $service->user_id === auth()->id(), 403);

        $this->imageService->deleteAllImages($service);
        $service->delete();

        return redirect()->route('merchant.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
