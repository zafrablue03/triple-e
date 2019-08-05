<?php

namespace App\Http\Controllers\Backend\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Service;
use File;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::get();
        
        return view('pages.backend.services.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.backend.services.create');
    }

    public function checkSlug($slug)
    {
        return Service::where('slug', $slug)->exists();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( ($this->checkSlug(str_slug($request->name))) ) {
            return redirect()->back()->withError('Service already exists!');
        }

        $request->request->add(['slug' => str_slug($request->name)]);

        $request->validate([
            'name'          =>  'required|min:2',
            'description'   =>  '',
            'image'         =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=25,max_width=2000',
        ]);

        $image = $request->file('image')->store('gallery','public');

        $thumbnail = $request->file('image')->store('thumbnail','public');

        $imageThumbnail = Image::make(public_path("storage/{$thumbnail}"))->fit(800,800);
        $imageThumbnail->save();

        Service::create(array_merge(
            $request->except(['_token', 'type', 'image']),
            ['type_id'      => $request->type],
            ['image'        => $image],
            ['thumbnail'    => $thumbnail]
        ));

        if ($request->get('action') == 'save') {
            return redirect()->route('services.index')->withSuccess('A new Service/Occassion has been successfully added!');
        } elseif ($request->get('action') == 'continue') {
            return redirect()->route('services.create')->withSuccess('A new Service/Occassion has been successfully added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('pages.backend.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('pages.backend.services.edit', compact('service'));
    }

    public function checkImage($image)
    {
        return File::exists(storage_path('app/public/'.$image));
    }

    public function checkThumbnail($thumbnail)
    {
        return File::exists(storage_path('app/public/'.$thumbnail));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        if ( ($this->checkSlug(str_slug($request->name))) ) {
            $request->request->add(['slug' => str_slug($request->name).str_random(5)]);
        }else {
            $request->request->add(['slug' => str_slug($request->name)]);
        }
        

        $request->validate([
            'name'          =>  'required|min:2',
            'description'   =>  '',
            'image'         =>  'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=25,max_width=2000',
        ]);

        $img_arr = [];

        if( request()->has('image') ){
            if($this->checkImage($service->image)){
                File::delete(storage_path('app/public/'.$service->image));
            }
            $image = $request->file('image')->store('gallery','public');
            array_push($img_arr, ['image' => $image]);

            if($this->checkThumbnail($service->thumbnail)){
                File::delete(storage_path('app/public/'.$service->thumbnail));
            }
            $thumbnail = $request->file('image')->store('thumbnail','public');

            $imageThumbnail = Image::make(public_path("storage/{$thumbnail}"))->fit(800,800);
            $imageThumbnail->save();

            array_push($img_arr, ['thumbnail' => $thumbnail]);
        }

        $service->update(array_merge(
            $request->except(['_token', 'type', 'image']),
            $img_arr[0] ?? [],
            $img_arr[1] ?? []
        ));
        if ($request->get('action') == 'save') {
            return redirect()->route('services.index')->withSuccess('Service/Occassion has been successfully updated!');
        } elseif ($request->get('action') == 'continue') {
            return redirect()->route('services.edit',$service->slug)->withSuccess('Service/Occassion has been successfully updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->withSuccess('Service/Occassion has been successfully deleted!');
    }
}
